<?php
include 'conn.php';

$sql = "SELECT * FROM city";
$result = $conn->query($sql);

$options = '<option value="">Select Cities</option>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options.= '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
    }
} else {
    $options.= '<option value="">No City found</option>';
}

echo $options;

$conn->close();
