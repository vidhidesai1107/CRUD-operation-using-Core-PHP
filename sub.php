<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $document_path = '';

    $state_id = $_POST['state_id'];
    $city_id = $_POST['city_id'];

    $documentName = $_FILES["document"]["name"];
    $documentTmpName = $_FILES["document"]["tmp_name"];
    $documentType = $_FILES["document"]["type"];
    $documentSize = $_FILES["document"]["size"];


    $allowedExtensions = ['pdf'];
    $documentNameParts = pathinfo($documentName);
    $documentExtension = strtolower($documentNameParts['extension']);

    if ($documentType !== 'application/pdf') {
        http_response_code(400); // Bad Request
        echo "Invalid file type. Please upload a PDF file.";
        exit;
    }

    $targetDir = "C:/xampp/htdocs/VidhiDesai/uploads/";

    $documentNameParts = pathinfo($documentName);
    $documentExtension = $documentNameParts['extension'];
    $documentUniqueName = uniqid() . '.pdf';
    $targetFilePath = $targetDir . $documentUniqueName;


    if (move_uploaded_file($documentTmpName, $targetFilePath)) {

        $document_path = $targetFilePath;
        $sql = "INSERT INTO candidates_info (name, state_id, city_id, age, document_path) VALUES ('$name', '$state_id', '$city_id', '$age', '$document_path')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
