<?php
if (isset($_POST['text']) && $_POST['text'] != '' && strlen($_POST['text']) <= 100) {
    session_start();
    if ($_POST['check'] == $_SESSION['number']) {
        include 'db.php';
        $address = $_SERVER['REMOTE_ADDR'];
        $stmt = $conn->prepare('select address from banned where address = ? and enabled');
        $stmt->bind_param('s', $address);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $text = htmlspecialchars($_POST['text']);
            $stmt = $conn->prepare('insert into posts (created, address, text) values (now(), ?, ?)');
            $stmt->bind_param('ss', $address, $text);
            $stmt->execute();
        }
    }
}
header('Location: /');
