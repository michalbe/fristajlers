<?
header("Content-type: image/jpeg");
$image = imagecreatefromjpeg("jury.jpg");



$colorr = imagecolorallocate($image, 0, 0, 0);
#imagefill ($image, 10, 10, $colorRed);

##############
##  LASKA1  ##
##############
$font = "md.ttf";
$size = 10;
$angle = -40;
$startx = 125;
$starty = 40;
$Ksywka1=$_GET['Ksywka1'];
imagettftext($image, $size, $angle, $startx, $starty, $colorr, $font, $Ksywka1);



#############
##YAMAKASI###
#############
$angle2 = 6;
$size2=10;
$startx2 = 248;
$starty2 = 125;
$Ksywka2=$_GET['Ksywka2'];
imagettftext($image, $size2, $angle2, $startx2, $starty2, $colorr, $font, $Ksywka2);

##########
##Barney##
##########
$angle3 = 40;
$size3=10;
$startx3 = 400;
$starty3 = 90;
$Ksywka3=$_GET['Ksywka3'];
imagettftext($image, $size3, $angle3, $startx3, $starty3, $colorr, $font, $Ksywka3);
imagejpeg($image);

?>
