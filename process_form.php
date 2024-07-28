<?php
session_start();
include('admin/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $message = $_POST['message'];

    // Prepare and execute SQL query to insert form data into a table
    $sql = "INSERT INTO form_data (name, message) VALUES ('$name', '$message')";
    if ($conn->query($sql) === TRUE) {
        // Echo a Bootstrap alert for success
        echo '<div class="alert alert-success" role="alert">New record created successfully</div>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}