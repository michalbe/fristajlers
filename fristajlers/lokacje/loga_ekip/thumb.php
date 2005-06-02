<?php
function skaluj($nazwa_pliku,$w){
list($ow, $oh) = getimagesize($nazwa_pliku);
$big=imageCreateFromJpeg($nazwa_pliku);
if($big){
$bigX=imagesX($big);
$bigY=imagesY($big);
$thumb = imagecreatetruecolor($w, $w);

if ($ow > $oh) {
$off_w = ($ow-$oh)/4;
$off_h = 0;
$ow = $oh;
$smallY=$w;
$smallX=round(($bigX * $smallY) / $bigY);
} elseif ($oh > $ow) {
$off_w = 0;
$off_h = ($oh-$ow)/2;
$oh = $ow;
$smallX=$w;
$smallY=round(($bigY * $smallX) / $bigX);
} else {
$off_w = 0;
$off_h = 0;
$smallX=$w;
$smallY=$w;
}

imagecopyresampled($thumb, $big, 0, 0, $off_w, $off_h, $smallX, $smallY, $bigX, $bigY);
return $thumb;
}
}
if (isset($_GET['f'])){
header("Content-type: image/jpeg"); 
$malyobrazek=skaluj($_GET['f'],$_GET['w']);
ImageJPEG($malyobrazek);
ImageDestroy($malyobrazek); 
}


?>