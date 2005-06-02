<?
include('conf/stats.php');

if (isset($kwota)) {
	###WP£ATA OPERACJE NA BAZIE
			$kwota=$_POST['kwota'];
			
				$query = "SELECT hajs FROM F_bank WHERE id='$id'"; 
				$wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);

			if ($rekord['hajs']<$kwota) {

				$newsy = $newsy .'<br>Nie masz tyle pieniedzy na koncie!';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
			}  else {
				$data =  date("Y-m-d");
				DodajHajs($id, $kwota);
				$kwotaCalosc = $rekord['hajs']-$kwota;
				$query = "UPDATE F_bank SET hajs='$kwotaCalosc', data='$data' WHERE id='$id'"; 
				mysql_query($query); 
				$newsy = $newsy .'<br><br>Wyplacono: <b>' .$kwota .'</b>HJS<br>Stan konta: <b>' .$kwotaCalosc .'</b>HJS';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
			}



} else {
	## FORMULARZ DO WP£ATY
$newsy = $newsy .'<br>POBIERANIE PIENIEDZY<br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=bank_pobierz">Podaj kwote do pobrania: <INPUT size=6 TYPE="text" NAME="kwota"><br>
	<INPUT TYPE="submit" value="pobierz" name=wplac>
	</FORM></center>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bank><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
}


$dane=array(
	'lokacja'=> TloLokacji('bank'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>