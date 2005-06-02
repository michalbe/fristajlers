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
if (isset($wyslane)) {

if (!(SprawdzPoprawnoscMejla($email))) {

		$newsy = $newsy ."Podaj dobry email, albo sie nie bawimy. <a href=rejestracja.php>Wroc</a>";

} else {

		if (ereg("^[??êæ¿¥³óñ·|¯?ÊÆÑ£Ó0-9a-zA-Z]{1,10}$", $ksywka))
			{

#################################################				
####### Ksywka zaakceptowana, jadziem dalej #####
#################################################

 if ((SprawdzKsywke($ksywka)) && SprawdzMejl($email))  {
	$haslo = GenerujHaslo();
	WprowadzDane($ksywka, $haslo, $email);
	WyslijEmailRejestracyjny($email, $ksywka, $haslo);

$newsy = $newsy .'Na Twoja skrzynke zostalo wyslane haslo, przy pomocy ktorego mozesz sie zalogowac do serwisu.';
} else {
	$newsy = $newsy ."Mamy juz w miescie fristajlowca o  takiej ksywce lub takim adresie email! Wybierz sobie nowy pseudonim. Pamietaj ze wg. regulaminu mozesz posiadac tylko jedno konto na FRISTAJLERS!  <a href=rejestracja.php>Wroc.</a>";
}


			} else {
				$newsy = $newsy ."Ksywka powinna zawierac tylko litery i cyfry oraz nie powinna byc dluzsza niz 10 znakow! <a href=rejestracja.php>Wroc</a>";
			}

}
	
} else {
PolaczMysql();
$query2 = "SELECT count(*) FROM F_glowneDane WHERE haslo <> ''"; 
        $wynik = mysql_query($query2); 
		$rekord = mysql_fetch_array ($wynik);
	if ($rekord[0]<=119) {
	$newsy = $newsy .WyswietlFormularzRejestracyjny();
	} else {
$newsy = $newsy .'<center>Niestety, liczba kont mozliwych do zalozenia w wersji beta zostala wyczerpana. Czekaj na pelna wersje. <a href=http://fristajlers.net>[powrot]</a></center>';
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