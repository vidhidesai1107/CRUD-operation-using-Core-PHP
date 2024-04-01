<?php
include 'conn.php';

$sql = "SELECT c.*, s.title as state_title, ci.title as city_title
FROM candidates_info c 
INNER JOIN state s ON c.state_id = s.id 
INNER JOIN city ci ON c.city_id = ci.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['state_title'] . "</td>";
        echo "<td>" . $row['city_title'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td><button class='editCandidate' data-id='" . $row['id'] . "'>Edit</button> <button class='deleteCandidate' data-id='" . $row['id'] . "'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No candidates found</td></tr>";
}

$conn->close();
?>
