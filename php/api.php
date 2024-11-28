<?php
// Nastavení hlaviček pro JSON odpověď
header('Content-Type: application/json');

// Vytvoření objektu
$response = array(
    "organization" => "Student Cyber Games"
);

// Vrácení JSON odpovědi
echo json_encode($response);
?>
