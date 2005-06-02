<?
include('conf/stats.php');


if (isset($kwota)) {
	###WP£ATA OPERACJE NA BAZIE
			$kwota=$_POST['kwota'];
			$first=$_POST['first'];
			if (Hajs($id)<$kwota) {

				$newsy = $newsy .'<br>Nie masz tyle pieniedzy!';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
			}  else {
				$data =  date("Y-m-d");
				OdejmijHajs($id, $kwota);
				if ($first==1) {
				$query = "INSERT INTO F_bank (id, hajs, data) VALUES ('$id', '$kwota',  '$data')"; 
				$kwotaCalosc = $kwota;
				} else {
				$query = "SELECT hajs FROM F_bank WHERE id='$id'"; 
				$wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$kwotaCalosc = $rekord['hajs']+$kwota;
				$query = "UPDATE F_bank SET hajs='$kwotaCalosc', data='$data' WHERE id='$id'"; 
				}
				mysql_query($query); 
				$newsy = $newsy .'<br><br>Przyjeto wplate: <b>' .$kwota .'</b>HJS<br>Stan konta: <b>' .$kwotaCalosc .'</b>HJS';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
			}



} else {
	## FORMULARZ DO WP£ATY
$newsy = $newsy .'<br>WPLATY<br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=bank_wplata">Podaj kwote do wplacenia:<INPUT size=6 TYPE="text" NAME="kwota"><br>
	<INPUT TYPE="hidden" name=first value=' .$first .'>
	<INPUT TYPE="submit" value="wplac" name=wplac>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
}





$dane=array(
	'lokacja'=> TloLokacji('bank'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>