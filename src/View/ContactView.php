<?php
// src/View/ContactView.php

namespace Telefonbuch\View;

class ContactView
{

    /**
     * @return void
     */
    public function showContactForms(): void
    {
        require_once __DIR__ . '/../Templates/addContactForm.html';
        require_once __DIR__ . '/../Templates/searchContactForm.html';
    }

    /**
     * @param array $contacts
     * @return void
     */
    public function printContacts(array $contacts = []): void
    {
        // Print the table header
        echo '<h2>Search Results</h2>';
        echo '<table>';
        echo '<tr><th>First Name</th><th>Last Name</th><th>Phone Number</th></tr>';

        // Print each contact
        foreach ($contacts as $contact) {

            echo '<tr>';
            echo '<td>' . htmlspecialchars($contact['firstName'], ENT_QUOTES) . '</td>';
            echo '<td>' . htmlspecialchars($contact['lastName'], ENT_QUOTES) . '</td>';
            echo '<td>' . htmlspecialchars($contact['phoneNumber'], ENT_QUOTES) . '</td>';
            echo '</tr>';
        }

        // Close the table
        echo '</table>';
    }
}