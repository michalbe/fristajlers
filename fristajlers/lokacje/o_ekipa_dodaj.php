<?
include('conf/stats.php');


$nr=NrEkipy($id);
$ekipa=Ekipa($nr);

$queryq = "SELECT count(*) FROM F_glowneDane WHERE ekipa='$nr'"; 
    $wynikq = mysql_query($queryq); 
	$rekordq = mysql_fetch_array ($wynikq);
	$czlonkowie=$rekordq[0];
	$queryq = "SELECT count(*) FROM F_ekipyDodaj WHERE id_ekipy='$nr'"; 
    $wynikq = mysql_query($queryq); 
	$rekordq = mysql_fetch_array ($wynikq);
	$czlonkowie= $czlonkowie+$rekordq[0];

if ($czlonkowie<35) {
if ((isset($id_kogo)) && (CzyWEkipie($id)==1)) {

$ekipa=NrEkipy($id);
$data =  date("Y-m-d");
$tablica=Ekipa($ekipa);
$query = "INSERT INTO F_ekipyDodaj (id_ekipy, id_kto, data) VALUES ('$ekipa', '$id_kogo', '$data')"; 
        mysql_query($query); 
		$tresc = '<b>' .Ksywka($id) .'</b>, szef ekipy <b>' .$tablica[1] .'</b> pragnie, abys zasilil szeregi jego grupy. Aby dolaczyc do <b>' .$tablica[1] .'</b> przejdz na osiedle, do panelu zarzadzania ekipami. Dobrze sie zastanow - mozesz dzialac tylko w jednej ekipie jednoczesnie.';
		$tresc = pl_win2iso($tresc);
		PiszWiadomosc(0, $id_kogo, $tresc);
		$newsy = $newsy .'<center><br><br><font>Fristajlowiec <b>' .Ksywka($id_kogo) .'</b> zostal zaproszony do Twojej ekipy.</font><center>';
}

} else {
		$newsy = $newsy .'<center><br><br><font>Niestety, mozesz miec maxymalnie 35 osob w ekipie.<font><center>';
}


$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Wiadomosc do wszystkich"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>