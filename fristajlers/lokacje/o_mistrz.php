<?
include('conf/stats.php');
		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

	if ((700<$pkt_stylu)){
$stats = PrzekazStatsyBazowe($id);
if ($stats[5]>700) {

	#### EKRAN G£ÓWNY#####
if (!isset($_POST['tak'])) {
$newsy = $newsy .'"Witaj. Jestem Mistrzem Stylu. Chcialbys nauczyc sie punchy? Lepszego nauczyciela nie znajdziesz w calym miescie...<br><br>';
$przyciski = '<TD><a href="?lokacja=osiedle"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
		$query = "SELECT ciuchy FROM F_inne WHERE id='0'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);

		$dzielnik=date(h);
		$energia= ceil($rekord['ciuchy']/$dzielnik)+140;
		$newsy = $newsy .'<b>Cena za jeden pakiet:' .$rekord[ciuchy] .'HJS</b><br><b>Potrzebna energia:' .$energia .'</b><br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=o_mistrz">
	<INPUT TYPE="submit" value="bierz pakiet" name=tak>
	</FORM></center>';
		$newsy = $newsy .'<br>[w pakiecie znajduje sie losowa ilosc punchy, CENA PAKIETU ZMIENIA SIE PARE RAZY DZIENNIE]';

}  else {

		$query = "SELECT ciuchy FROM F_inne WHERE id='0'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);

		$dzielnik=date(h);
		$energia= ceil($rekord['ciuchy']/$dzielnik)+50;
		$hajs = $rekord['ciuchy'];

	$stats = PrzekazStatsyBazowe($id);
				if (($stats[0]<$energia) || (Hajs($id)<$hajs)) {
			$newsy = $newsy .'<center><br><font>Jestes za bardzo zmeczony lub masz za malo hajsu. Wpadnij pozniej. Rap z Toba..</font><br><br>';
$przyciski = '<TD><a href="?lokacja=osiedle"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
				} else {
					$super = rand(0, 1000);
					if ($super==1) { $punche=100; 
					$co = Ksywka($id) .' rozbil setke pancziwa';
					PiszWiadomosc(0, 1, $co);
					} else { $punche=rand(1, 8); } 
					$stats[9]=$stats[9]+$punche;
					OdejmijHajs($id, $hajs);
					$newsy = $newsy .'<center><br><font>Ilosc nauczonych punchy: <b>' .$punche .'</b><br><br>Aktualna ilosc punchy: <b> ' .$stats[9] .'</b><br></font>';
$przyciski = '<TD><a href="?lokacja=o_mistrz"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
					$energia = $stats[0]-$energia;
					$query = "UPDATE F_stats SET energia_aktualna='$energia', punche='$stats[9]'  WHERE id='$id'"; 
				mysql_query($query); 
				}
	}
}


$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
}
?>