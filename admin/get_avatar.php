<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT img FROM alumnus_bio WHERE id = $id");
    $row = $query->fetch_assoc();
    
    header("Content-Type: image/jpeg"); // Change this if your image is not JPEG
    echo $row['avatar'];
}
?>