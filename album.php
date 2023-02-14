<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Песни альбома "<?php
        include 'db.php';
        $id = $_GET['id'];
        $stmt = $conn->prepare('select name from albums where id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $album = $stmt->get_result()->fetch_array()[0];
        echo $album;
        ?>"
    </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="/">Аккорды</a></h1>
<h2>Песни альбома "<?php echo $album ?>"</h2>
<div class="center">
    <ul>
        <?php
        $stmt = $conn->prepare('select id, name, number from songs where album = ? order by number');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            echo "<li><a href=\"song.php?id=$id\">" . $row['number'] . ". $name</a></li>";
        }
        ?>
    </ul>
</div>
</body>
</html>
