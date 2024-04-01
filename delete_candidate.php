<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM candidates_info WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Candidate deleted successfully!";
    } else {
        echo "Error deleting candidate: " . $conn->error;
    }
}

$conn->close();
?>
