<?php
header("Content-type: image/png");
$number = rand(1000, 9999);
session_start();
$_SESSION['number'] = $number;
$im = imagecreatetruecolor(32, 16);
$white = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 3, 2, 4, $number, $white);
imagepng($im);
imagedestroy($im);
