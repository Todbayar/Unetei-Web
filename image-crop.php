<?php
$img_r = imagecreatefromjpeg($_FILES["img"]["tmp_name"]);
$dst_r = ImageCreateTrueColor( $_POST['w'], $_POST['h'] );

imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'],$_POST['h']);

ob_start();
imagejpeg($dst_r);
$rawImageBytes = ob_get_clean();
echo "data:image/jpeg;base64,".base64_encode($rawImageBytes);
?>