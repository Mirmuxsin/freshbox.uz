<?php



if(!isset($_POST["text1"])){
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="text1">BIRINCHI TEKST<br>
    <input type="text" name="text2">IKKINCHI TEKST<br>
    <input type="text" name="text3">UCHINCHI TEKST<br>
    <input type="file" name="photot" id="photo">
    <button type="SUBMIT">OK</button>
</form>

<?php
    exit;
}else{
    $target_file = "photo.jpg";
    unlink($target_file);
    move_uploaded_file($_FILES["photot"]["tmp_name"], $target_file);
    $png = imagecreatefrompng('./mask1.png');
    $png2 = imagecreatefrompng('./mask2.png');
    $jpeg = imagecreatefromjpeg('./photo.jpg');



    list($width, $height) = getimagesize('./photo.jpg');
    list($newwidth, $newheight) = getimagesize('./mask1.png');
    $out = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
    imagecopyresampled($out, $jpeg, 320, 100, 0, 0, 700, 700, $width, $height);
    imagecopyresampled($out, $png2, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);

    // Allocate A Color For The Text
    $white = imagecolorallocate($out, 0, 0, 0);

    // Set Path to Font File
    $font = __DIR__.'/font.otf';

    // Set Text to Be Printed On Image
    $text = $_POST['text1'];
    $text2 = $_POST['text2'];
    $text3 = $_POST['text3'];

    // Print Text On Image
    imagettftext($out, 30, 0, 110, 420, $white, $font, $text);
    imagettftext($out, 30, 0, 110, 580, $white, $font, $text2);
    imagettftext($out, 30, 0, 110, 730, $white, $font, $text3);



    imagejpeg($out, 'out.jpg', 100);

    echo "<img src=\"out.jpg\"/>";


}

