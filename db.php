<?php
$host = 'localhost';
$user = 'root';
$password = '123456789';
$db = 'chords';

$conn = new mysqli($host, $user, $password, $db);
$conn->set_charset("utf8");
