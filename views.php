<?php
include 'db.php';
$result = $conn->query('select name, views from songs where views > 0 order by views desc');
if ($result->num_rows == 0) {
    echo 'Просмотров нет';
} else {
    echo '<table>';
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $views = $row['views'];
        echo "<tr><td>$name</td><td>$views</td></tr>";
    }
    echo '</table>';
}
