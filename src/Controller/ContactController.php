<?php
// src/Controller/ContactController.php

namespace Telefonbuch\Controller;

use PDOException;
use PDO;
use Telefonbuch\Model\Contact;
use Telefonbuch\View\ContactView;
use Telefonbuch\config\Database;

class ContactController
{
    private ContactView $contactView;
    private PDO $pdo;
    private array $t9_map = [
        '2' => '[abc]',
        '3' => '[def]',
        '4' => '[ghi]',
        '5' => '[jkl]',
        '6' => '[mno]',
        '7' => '[pqrs]',
        '8' => '[tuv]',
        '9' => '[wxyz]',
    ];

    public function __construct()
    {
        $this->contactView = new ContactView();

        $this->pdo = Database::getPDO();
    }

    /**
     * @param $postData
     * @return string
     */
    public function addContact($postData): string
    {
        // Validate input data
        $firstName = htmlspecialchars($postData['firstName'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $lastName = htmlspecialchars($postData['lastName'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $phoneNumber = htmlspecialchars($postData['phoneNumber'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        assert(!empty($firstName), "First name is required.");
        assert(!empty($lastName), "Last name is required.");
        assert(!empty($phoneNumber), "Phone number is required.");

        // Instantiate Contact object
        $contact = new Contact($firstName, $lastName, $phoneNumber);
        // Save contact to database
        $returnMessage = $this->saveContact($contact);

        echo $returnMessage;

        $this->showContactForms();

        return $returnMessage;
    }

    /**
     * @param Contact $contact
     * @return string
     */
    private function saveContact(Contact $contact): string
    {
        $pdo = $this->pdo;
        // Prepare statement
        $stmt = $pdo->prepare("INSERT INTO contacts (firstName, lastName, phoneNumber) VALUES (:firstName, :lastName, :phoneNumber)");

        // Bind parameters and execute
        try {
            $stmt->execute([
                'firstName' => $contact->getFirstName(),
                'lastName' => $contact->getLastName(),
                'phoneNumber' => $contact->getPhoneNumber()
            ]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return "Contact saved successfully.";
    }

    /**
     * @param array|null $postData
     * @return Contact[]
     */
    public function showContacts(array $postData = null): array
    {
        //if empty or no search query is provided, show all contacts
        if($postData === null || empty($postData['phoneNumberQuery'])) {
            $contacts = $this->getAllContacts();
        } else { //if search query is provided, show contacts matching the query
            // Validate and sanitize the input data
            $query = htmlspecialchars($postData['phoneNumberQuery'], ENT_QUOTES, 'UTF-8');
            // Search for contacts in the database
            $contacts = $this->getContactsByQuery($query);

            }

        // display the contacts
        $this->contactView->printContacts($contacts);
        return $contacts;
    }

    /**
     * @param string $query
     * @return array
     */
    private function getContactsByQuery(string $query): array
    {
        $pdo = $this->pdo;

        // Convert T9 input to a REGEXP condition
        $t9_input_arr = str_split($query);

        $query_conditions = '';
        // Build the query conditions
        foreach ($t9_input_arr as $digit) {
            if (isset($this->t9_map[$digit])) {
                $query_conditions .= " CONCAT(firstName, lastName) REGEXP '{$this->t9_map[$digit]}' AND";
            }
        }
        // Remove trailing "AND"
        $query_conditions = rtrim($query_conditions, " AND");

        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE $query_conditions");

        // Bind parameters and execute
        $stmt->execute();

        // Fetch all the matching contacts
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contacts;
    }

    /**
     * @return array
     */
    private function getAllContacts(): array
    {
        $pdo = $this->pdo;

        // Prepare statement
        $stmt = $pdo->prepare("SELECT * FROM contacts");
        $stmt->execute();

        //second variant of fetch without instantiating Contact objects
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $contacts;
    }

    /**
     * @return void
     */
    public function showContactForms(): void
    {
        $this->contactView->showContactForms();
    }

}