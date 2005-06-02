<?
session_start();
$id=$_SESSION['id'];
#$id=1;

if (isset($id)) { 
#### SPRAWDZANIE STANU LOGOWANIA ######
			header("Location: main.php?lokacja=miasto");	
} ## KONIEC SPRAWDZANIA STANU LOGOWANIA ####
####INCLUDY#####
include('conf/include.php');
include('conf/funkcje.php');
####KONIEC######

PolaczMysql();  ##########POLACZENIE Z BAZA DANYCH #############
if (isset($pass)) {
	if (isset($wyslane)) {
		if($haslo2!=$haslo1) {
			$newsy = $newsy ."<br><b><font>HASLA NIE SA TAKIE SAME</font></b><br><center><form method=\"post\" action=zmianahasla.php> <table><tr><td><font>ksywka:</font></td><td><input type=\"text\" name=\"ksywka\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr>
			<tr><td><font >nowe haslo:</font></td><td><input type=\"password\" name=\"haslo1\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr><tr><td><font>powtorz nowe haslo:</font></td><td><input type=\"password\" name=\"haslo2\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr></table>
<input type=hidden value=$pass name=pass>
<input type=\"submit\" name=\"wyslane\" value=\"Akceptuj\" style='font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;'></FORM></center>";
		} else {
		$query = "SELECT id FROM F_glowneDane WHERE haslo = '$pass' AND ksywka='$ksywka'"; 
        $wynik = mysql_query($query); 
			if (mysql_num_rows($wynik) == 0) {
				$newsy = $newsy .'<br><b><font>BLEDNA KSYWKA LUB KOD PODANY W EMAILU. SPROBOJ JESZCZE RAZ LUB SKONTAKTUJ SIE Z ADMINISTRATOREM.</font></b>';
			} else {
				$rekord = mysql_fetch_array ($wynik);
				$haslo = md5($haslo1);
				$queryWin = "UPDATE F_glowneDane SET haslo='$haslo' WHERE id='$rekord[id]'"; 
				mysql_query($queryWin); 
				$newsy = $newsy .'<br><b><font>HASLO ZMIENIONE. WROC  NA STRONE GLOWNA I ZALOGUJ SIE. <a href=http://fristajlers.net>[powrot]</a></font></b>';
			}
	}
		} else {
$newsy = $newsy ."<br><center><form method=\"post\" action=zmianahasla.php> <table><tr><td><font>ksywka:</font></td><td><input type=\"text\" name=\"ksywka\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr>
		<tr><td><font >nowe haslo:</font></td><td><input type=\"password\" name=\"haslo1\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr><tr><td><font>powtorz nowe haslo:</font></td><td><input type=\"password\" name=\"haslo2\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr></table>";
$newsy = $newsy .'<input type=hidden value=' .$pass .' name=pass><input type="submit" name="wyslane" value="Akceptuj" style="font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;"></FORM></center>';
}
}



		$query = "SELECT count(*) FROM F_glowneDane WHERE haslo <> ''"; 
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

	$statsy = '<br><br><br><font class=stats>Liczba graczy: <b>' .$graczy .'</b></font><br><font class=stats>Liczba ekip: <b>' .$ekip .'</b></font><br><font class=stats>Stoczonych walk: <b>' .$walki .'</b></font><br><font class=stats>Wyslanych wiadomosci: <b>' .$wiadomosci .'</b></font><br><font class=stats>Postow na forach: <b>' .$posty .'</b></font><br><br><br><center><img src=wyglad/' .$temp .'.jpg width=80 border=4></center>';
	

$dane=array(
	'lokacja'=> TloLokacji('index'), 
	'przyciski'=> '<td><a href="mailto:info@fristajlers.net"><img src=gfx/poczta.jpg border=0 title="Kontakt z Tworcami"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );	
	

	
	$tmpl = new Template('templaty/main.tpl');
	
	$tmpl->add($dane);
	echo $tmpl->execute();


?>