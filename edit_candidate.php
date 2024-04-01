<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    if (isset($_POST['name'], $_POST['state_id'], $_POST['city_id'], $_POST['age'])) {
        $name = $_POST['name'];
        $state_id = $_POST['state_id'];
        $city_id = $_POST['city_id'];
        $age = $_POST['age'];

        $update_sql = "UPDATE candidates_info SET name='$name', state_id='$state_id', city_id='$city_id', age='$age'  WHERE id = '$id'";
        if ($conn->query($update_sql) === TRUE) {
            echo json_encode(array("success" => true, "message" => "Candidate updated successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error updating candidate: " . $conn->error));
        }
    } else {
        $select_sql = "SELECT * FROM candidates_info WHERE id = '$id'";
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            echo json_encode(array(
                "success" => true,
                "id" => $row['id'],
                "name" => $row['name'],
                "state_id" => $row['state_id'],
                "city_id" => $row['city_id'],
                "age" => $row['age']
            ));
        } else {

            echo json_encode(array("success" => false, "message" => "Candidate not found"));
        }
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}

$conn->close();
