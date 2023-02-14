<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аккорды песни "<?php
        include 'db.php';
        $id = $_GET['id'];
        $stmt = $conn->prepare('select name, chords from songs where id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo $row['name'];
        ?>"
    </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1><a href="/">Аккорды</a></h1>
<?php
$stmt = $conn->prepare('update songs set views = views + 1 where id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
echo '<div><pre>' . $row['chords'] . '</pre></div>';
?>
</body>
</html>
