<?php
const HOSTNAME = 'localhost';
const USERNAME = 'root';
const PASSWORD = 'kure1312';
const DB_NAME = 'Quiz';
// Connect to mySQL
$conn = new mysqli (HOSTNAME, USERNAME, PASSWORD, DB_NAME);
// Check for errors
if (!$conn) {
    die ("Error Jevric: ".$conn->errno);
}