<?php
// src/Model/Contact.php

namespace Telefonbuch\Model;

class Contact {
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;

    public function __construct(string $firstName, string $lastName, string $phoneNumber) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getFirstName(): string {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }
}