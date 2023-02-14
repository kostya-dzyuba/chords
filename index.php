<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аккорды</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form class="search-form" action="search.php">
    <input name="name" placeholder="Название песни">
    <input type="submit" value="Поиск">
</form>
<h1><a href="/">Аккорды</a></h1>
<h2>Если ты украл отсюда аккорды — то ты плохой человек. Эти аккорды подобраны лично <a
            href="https://t.me/kostya_dzyuba">мной</a> на слух.</h2>
<h3>Все аккорды подобраны в оригинальной тональности. Продолжая использовать этот сайт, ты подтверждаешь, что тебе
    исполнилось 18 лет.</h3>
<?php
include 'db.php';
$count = $conn->query('select count(*) from songs')->fetch_array()[0];
echo "<h4>На данный момент уже подобрано $count песен. Все авторские права принадлежат исполнителям. Некоторые в состоянии недопила, но однажды я обязательно их доделаю...</h4>";
?>
<h5>Я начал работать над этим проектом еще в далеком 2020 году. Тогда эти подборы представляли собой файловую иерархию,
    поэтому может встречаться служебная информация, например, альбомная нумерация.</h5>
<div class="center">
    <table>
        <tr>
            <td><h2>Исполнители</h2></td>
            <td><h2>Новости сайта</h2></td>
        </tr>
        <tr>
            <td>
                <ul>
                    <?php
                    $result = $conn->query('select id, name from artists');
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $name = $row['name'];
                        echo "<li><a href=\"artist.php?id=$id\">$name</a></li>";
                    }
                    ?>
                </ul>
            </td>
            <td style="vertical-align: top">
                <ul>
                    <?php
                    $result = $conn->query('select text from news order by id desc');
                    while ($row = $result->fetch_assoc()) {
                        $text = $row['text'];
                        echo "<li>$text</li>";
                    }
                    ?>
                </ul>
            </td>
        </tr>
    </table>
</div>
<div class="center">
    <h2>Стена</h2>
    <p>Здесь ты можешь оставить свои комментарии и предложения,<br>расписаться или оставить контакты для обратной связи.<br>Или
        вообще написать че угодно (не более 100 символов)</p>
    <div class="center">
        <form action="post.php" method="post" autocomplete="off">
            <input name="text" placeholder="Введите ваше сообщение">
            <div class="center">
                <label>Введите</label>
                <img src="image.php">
                <input name="check" style="width: 35px" placeholder="Код">
            </div>
            <div class="center">
                <input type="submit" value="Отправить">
            </div>
        </form>
    </div>
</div>
<div class="center" style="width: 100%">
    <h3>Посты</h3>
    <?php
    $result = $conn->query('select created, text from posts where not hidden order by created desc');
    $fmt = datefmt_create('ru_RU', IntlDateFormatter::LONG, IntlDateFormatter::SHORT, null, null, 'd MMMM k:m');
    while ($row = $result->fetch_assoc()) {
        $created = datefmt_format($fmt, date_create($row['created']));
        $text = $row['text'];
        echo "<p>$created: $text</p>";
    }
    ?>
</div>
</body>
</html>
