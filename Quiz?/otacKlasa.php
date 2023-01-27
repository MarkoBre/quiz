<?php
class User
{
    protected $conn;
    protected $username;
    protected $email;
    protected $password;
    protected $dob;
    protected $errors = array();

    public function __construct ($conn)
    {
        $this->conn = $conn;
    }
}