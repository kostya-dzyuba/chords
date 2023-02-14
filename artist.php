<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аккорды исполнителя "<?php
        include 'db.php';
        $id = $_GET['id'];
        $stmt = $conn->prepare('select name from artists where id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $artist = $stmt->get_result()->fetch_array()[0];
        echo $artist;
        ?>"
    </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="/">Аккорды</a></h1>
<?php
$stmt = $conn->prepare('select id, name from albums where artist = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 0) {
    echo "<h2>Альбомы исполнителя \"$artist\"</h2>";
}
?>
<div class="center">
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            $album = $row['id'];
            echo "<li><a href=\"album.php?id=$album\">" . $row['name'] . '</a></li>';
        }
        ?>
    </ul>
</div>
<?php
$stmt = $conn->prepare('select count(*) from songs where artist = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$count = $stmt->get_result()->fetch_array()[0];
echo "<h2>Песни исполнителя \"$artist\" (всего $count)</h2>";
$stmt = $conn->prepare('select id, name from songs where artist = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="center">
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            echo "<li><a href=\"song.php?id=$id\">" . $row['name'] . '</a></li>';
        }
        ?>
    </ul>
</div>
</body>
</html>
