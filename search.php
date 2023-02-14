<?php
if ($_GET['name'] == '') {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form class="search-form">
    <input name="name" placeholder="Название песни">
    <input type="submit" value="Поиск">
</form>
<h1><a href="/">Аккорды</a></h1>
<?php
include 'db.php';
$name = $_GET['name'];
$contains_name = "%$name%";
$stmt = $conn->prepare('select id, name from songs where name like ?');
$stmt->bind_param('s', $contains_name);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;
if ($count == 0) {
    echo "<h2>По запросу \"$name\" не найдено ни одной песни</h2>";
} else {
    echo "<h2>По запросу \"$name\" найдено $count песен</h2>";
    echo '<ul class="center">';
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        echo "<li><a href=\"song.php?id=$id\">" . $row['name'] . '</a></li>';
    }
}
?>
</ul>
</body>
</html>
