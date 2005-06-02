<?
include('conf/stats.php');

$newsy = $newsy .'Witaj w banku. Mozesz tutaj zostawic swoje pieniadze. Dostajesz <b>1%</b> odsetek za kazdy dzien, liczac od dnia ostatniej wplaty lub wyplaty. Zostana doliczone w nocy z wtorku na srode.<br><br>';

	$query = "SELECT * FROM F_bank WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);

	if (mysql_num_rows($wynik) == 0) {
			
	$newsy = $newsy .'<b>Aby zalozyc konto wystarczy dokonac 1szej wplaty.</b>';
$przyciski = '<td><a href=main.php?lokacja=bank_wplata&first=1><img src=gfx/wplata.jpg border=0 title="Wplac pieniadze"></a></TD>';
		} else {

				$query = "SELECT hajs, data FROM F_bank WHERE id='$id'"; 
				$wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);

		$newsy = $newsy .'<b>Stan Twojego konta: ' .$rekord['hajs'] .'HJS</b><br><b>Odsetki naliczane od: ' .$rekord['data'] .'</b>';
$przyciski = '<td><a href=main.php?lokacja=bank_wplata><img src=gfx/wplata.jpg border=0 title="Wplac pieniadze"></a></TD><td><a href=main.php?lokacja=bank_pobierz><img src=gfx/wyplata.jpg border=0 title="Pobierz pieniadze"></a></TD>';
		}

include('_item.php');

$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski .'<td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>' .$przed,
	'statsy' => $statsy );
?>