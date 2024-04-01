
<?php
include 'conn.php';
$sql = "SELECT * FROM state";

$result = $conn->query($sql);

$options = '<option value="">Select State</option>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
    }
} else {
    $options .= '<option value="">No states found</option>';
}

echo $options;

$conn->close();
?>
