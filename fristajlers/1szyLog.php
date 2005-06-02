<?
session_start();
$id=$_SESSION['id'];
#$id=1;

if (isset($id)) { 
#### SPRAWDZANIE STANU LOGOWANIA ######
	

####INCLUDY#####
include('conf/include.php');
include('conf/funkcje.php');
####KONIEC######

PolaczMysql();  ##########POLACZENIE Z BAZA DANYCH #############
$newsy = $newsy ."<b>" .Ksywka($id) ."</b><br>";
if (!isset($co)) {
$query = "SELECT * FROM F_stats WHERE `id`='$id'";
	$resp = mysql_query($query);
	if (mysql_num_rows($resp) == 0) {
		$co='statsy';
	} else {
		$co='postac';
	}

}
switch($co) {
	case 'statsy': 
		srand(time());
		$stats = LosujStatsy();
		$newsy = $newsy ."<TABLE border=0><TR><TD>";
		$newsy = $newsy .WyswietlStatsy($stats[0], $stats[1], $stats[2], $stats[3], $stats[4], $stats[5]);

						$newsy = $newsy .pl_win2iso("<br><br><font>Energii lepiej miec jak najwiecej, wplywa ona na ocene sedziow, i poziom rapowania. Wiedza wplywa na roznorodnoc i poziom Twoich rymow (im wiecej wiedzy, tym wiekszy zasob rymow). Inteligecja wplywa na uzywanie PUNCHY, czyli super rymow. Flow pokazuje, w jaki sposob rymujesz, dlatego wiadomo, ze im wiekszy, tym lepiej. Napiecie to poziom Twojego stresu. Wiadomo, ze jesli masz go duzo, i sie tremujesz, to bedziesz oceniany gorzej. punkty stylu sa bardzo wazne, im wiecej ich masz, tym masz wiekszy poziom. .</FONT>");
		session_register("id");
		session_register("stats");
		$newsy = $newsy .'
		<form action="1szyLog.php" method=post>
		<input type="hidden" value="statsy" name="co">
		<input type=submit value="Losuj jescze raz" style="font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;">
		</form><form action="1szyLog.php" method=post>
		<input type="hidden" value="postac" name="co">
		<input type=submit value="Akceptuj statystyki" style="font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;">
		</form></TD></TR></TABLE>';
			break;

	case 'postac':
		session_register("id");
		WstawStatsy($id, $stats[0], $stats[1], $stats[2], $stats[3], $stats[4], $stats[5]);
require('formularo.html');
	break;

	case 'koniec':
	
	$imie=strip_tags($_POST['imie']);
	$nazwisko=strip_tags($_POST['nazwisko']);
	$o_sobie=strip_tags($_POST['o_sobie']);
	
	if (SprawdzDate($data)==1) {
	$query = "UPDATE F_glowneDane SET logo='$logo', imie='$imie', nazwisko='$nazwisko', o_sobie='$o_sobie', data_urodzenia='$data' WHERE id='$id'"; 
			mysql_query($query); 
	$queryInne = "INSERT INTO F_inne (id, hajs, ciuchy) VALUES ('$id', '1000',  '0')"; 
			mysql_query($queryInne); 
	$queryWalki = "INSERT INTO F_walki (id, wygrane, przegrane) VALUES ('$id', '0',  '0')"; 
		mysql_query($queryWalki); 

	$newsy = $newsy ."Gratulujemy! Jestes juz pelnoprawnym fristajlowcem. Wroc na strone glowna i zaloguj sie jeszcze raz";
	} else {
		$newsy = $newsy .'nieprawidlowy format daty
		<form action="1szyLog.php" method=post>
		<input type="hidden" value="postac" name="co">
		<input type=submit value="Wroc">
		</form>';
	}
	break;
}



		$query = "SELECT count(*) FROM F_glowneDane"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$graczy = $rekord[0];
		$query = "SELECT count(*) FROM F_ekipy"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$ekip = $rekord[0];
		$query = "SELECT count(*) FROM F_ForumPosty"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$posty = $rekord[0];
		$query = "SELECT count(*) FROM F_poczta"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$wiadomosci= $rekord[0];
		$query = "SELECT wygrane FROM F_walki"; 
        $wynik = mysql_query($query); 
		while($rekordwalki = mysql_fetch_array ($wynik)) {	
				$walki = $walki + $rekordwalki[0];
			}
srand(time());	
$temp =rand(1,24);
	$statsy = '<br><br><br><br><font class=stats>Liczba graczy: <b>' .$graczy .'</b></font><br><font class=stats>Liczba ekip: <b>' .$ekip .'</b></font><br><font class=stats>Stoczonych walk: <b>' .$walki .'</b></font><br><font class=stats>Wyslanych wiadomosci: <b>' .$wiadomosci .'</b></font><br><font class=stats>Postow na forach: <b>' .$posty .'</b></font><br><br><br><center><img src=wyglad/' .$temp .'.jpg width=80 border=4></center>';
	

$dane=array(
	'lokacja'=> TloLokacji('index'), 
	'przyciski'=> '<td><a href="mailto:info@fristajlers.net"><img src=gfx/poczta.jpg border=0 title="Kontakt z Tworcami"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );	
	

	
	$tmpl = new Template('templaty/main.tpl');
	
	$tmpl->add($dane);
	echo $tmpl->execute();
} ## KONIEC SPRAWDZANIA STANU LOGOWANIA #### 
?>