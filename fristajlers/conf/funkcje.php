<?
require('polish_chars.php');
## wedza 33348
function TloLokacji($lokacja, $wynik=0){

	if ($wynik==0) {
	return '.lokacja {
		background-image: url(gfx/tla/' .$lokacja .'.jpg);
		background-repeat: no-repeat;
		height: 363px;
		width: 598px;
		margin-top: 70px;
		position: absolute;
		margin-left: 60px;
	}';
	} else {
		return '.lokacja {
		background-image: url(gfx/tla/' .$lokacja .');
		background-repeat: no-repeat;
		height: 363px;
		width: 598px;
		margin-top: 70px;
		position: absolute;
		margin-left: 60px;
	}';
	}
}

############################

function LosujPunch() {

		$plik = file ("texty/punch.txt");

	$nrWersu = rand(0, count($plik)-1);   //  losuj wers z pliku
	$wers = pl_win2iso("<b>" .$plik[$nrWersu] ."</b><br>");
	return $wers;

}

######################################


function LosujWersy($poczatkowyPlik, $koncowyPlik) {
	$ksywka="budzyk";

	$nazwaPliku=rand ($poczatkowyPlik,$koncowyPlik);   //  losowanie numeru pliku z textami
	$rozszerzenie=rand(0,1);
	$nazwaPliku = $nazwaPliku .'_' .$rozszerzenie .'.txt';
	$plik = file ("texty/$nazwaPliku");

	for ($a=0; $a<2; $a++)
	{
	$nrWersu = rand(0, count($plik)-1);   //  losuj wers z pliku
	if ($nrWersu==$nrWersu2) {     // ta petla, zeby w jednym losowaniu nie bylo takeigo samego wersu 2 razy
		$a--;
	} else {
	$wers = $plik[$nrWersu] ."<br>";
	$wers_ost = $wers_ost .$wers;
	}
	$nrWersu2= $nrWersu;
		}
return $wers_ost;
}

######################################

function PolaczMysql() {

		$host = "";
		$user = "";
		$pass = "";
		$dbname = "";
		mysql_connect($host,$user,$pass);
        mysql_select_db($dbname);
}

###############################

function GlowneDane($logo, $ksywka, $imie, $nazwisko, $data_urodzenia, $o_sobie, $email) {




	$query = "INSERT INTO F_glowneDane (id, logo, ksywka, imie, nazwisko, data_urodzenia, o_sobie, email) VALUES ('', '$logo',  '$ksywka', '$imie', '$nazwisko', '$data_urodzenia', '$o_sobie', '$email')";
        mysql_query($query);


		$query2 = "SELECT * FROM F_glowneDane WHERE ksywka='$ksywka'";
        $wynik = mysql_query($query2);
		$rekord = mysql_fetch_array ($wynik);
		$id = $rekord[0];
		$queryWalki = "INSERT INTO F_walki (id, wygrane, przegrane) VALUES ('$id', '0',  '0')";
		mysql_query($queryWalki);
		return $id;

}

#############################

function LosujStatsy() {

	$energia = rand(70, 255);
	$inteligencja = rand(70, 255);
	$wiedza =  rand(70, 255);
	$flow =  rand(10, 100);
	$styl = $inteligencja + $wiedza + $flow;
	$napiecie =  rand(100, 999);

$statsy = array($energia, $inteligencja, $wiedza, $flow, $styl, $napiecie);
	return $statsy;

}

#############################

function WstawStatsy($id, $energia, $inteligencja, $wiedza, $flow, $styl, $napiecie) {



	$query = "INSERT INTO F_stats (id, energia, energia_aktualna, inteligencja, inteligencja_aktualna, wiedza, flow, styl, napiecie, napiecie_aktualne) VALUES ('$id', '$energia', '$energia', '$inteligencja', '$inteligencja', '$wiedza', '$flow', '$styl', '$napiecie', '$napiecie')";
        mysql_query($query);

}


#########################

function WyswietlStatsy($energia, $inteligencja, $wiedza, $flow, $styl, $napiecie)  {



		$inteligencja = ceil(sqrt($inteligencja));
		$wiedza = round(sqrt($wiedza));
		$flow = floor(sqrt($flow));
		$napiecie = floor(($napiecie/1000)*100);
		$tab = $tab ."<font>energia: " .$energia;
		$tab = $tab . "<br>inteligencja: " .$inteligencja;
		$tab = $tab ."<br>wiedza: " .$wiedza;
		$tab = $tab ."<br>flow: " .$flow;
		$tab = $tab ."<br>pkt. stylu: " .$styl;
		$tab = $tab ."<br>napiecie: $napiecie</font> ";
		return $tab;
}

#############################

function Zmeczenie($id) {

	$stats = PrzekazStatsyBazowe($id);
		if ($stats[0]<3) {
			return 1;
		} else {
			return 0;
		}
}

##########################

function WyswietlStatsy2($id)  {




		$query = "SELECT * FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		$inteligencja = ceil(sqrt($rekord[4]));
		$inteligencja_aktualna = ceil(sqrt($rekord[3]));
		$wiedza = round(sqrt($rekord[5]));
		$flow = floor(sqrt($rekord[6]));
		$pkt_stylu = $rekord[7];
		$kondycja = $rekord['kondycja'];
		$napiecie = ceil(($rekord[9]/1000)*100);
		if (Zmeczenie($id)==1) { $zwrot = $zwrot .'<b> ! '; }
		$zwrot = $zwrot .'energia: ' .$rekord[2] .'/' .$rekord[1];
		if (Zmeczenie($id)==1) { $zwrot = $zwrot .'</b>'; }
        $zwrot = $zwrot .'<br>inteligencja: ' .$inteligencja;
		$zwrot = $zwrot ."<br>wiedza: " .$wiedza ."<br>flow: " .$flow ."<br>pkt. stylu: " .$pkt_stylu .'<br>kondycja: ' .$kondycja;
		if ($napiecie>0) {
		$zwrot = $zwrot .'<br>napiecie: ' .$napiecie .'%<br>';
		} else {
		$zwrot = $zwrot .'<br>';
		}
		return $zwrot;

}

#############################

function PrzekazStatsy($id)  {




		$query = "SELECT * FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		if($rekord[1]==0){ $rekord[1]=1; } ### jak nie ma takiego zawodnika
		$energia = round(($rekord[2]/$rekord[1])*100);
		$inteligencja = ceil(sqrt($rekord[4]));
		$inteligencja_aktualna = ceil(sqrt($rekord[3]));
		$wiedza = round(sqrt($rekord[5]));
		$flow = floor(sqrt($rekord[6]));
		$pkt_stylu = $rekord[7];
		$napiecie = floor(($rekord[9]/1000)*100);
		### rekord[10] to punche
		$statsy = array ($energia, $inteligentcja, $inteligencja_aktualna, $wiedza, $flow, $pkt_stylu, $napiecie, $rekord[10]);
		 return $statsy;

}
#############################

function PrzekazStatsyBazowe($id)  {



		$query = "SELECT * FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		$energia_st = $rekord[1];
		$energia = $rekord[2];
		$inteligencja = $rekord[3];
		$inteligencja_aktualna = $rekord[4];
		$wiedza = $rekord[5];
		$flow = $rekord[6];
		$pkt_stylu = $rekord[7];
		$napiecie = $rekord[8];
		$napiecie_akt = $rekord[9];
		$forma = $rekord['forma'];
		### rekord[10] to punche
		$statsy = array ($energia, $inteligencja, $inteligencja_aktualna, $wiedza, $flow, $pkt_stylu, $napiecie, $energia_st, $napiecie_akt, $rekord[10], $forma);
		 return $statsy;

}
#############################

function PrzekazStatsyArray($id)  {



		$query = "SELECT * FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		 return $rekord;

}

##############################

function Ksywka($id)  {




		$query = "SELECT ksywka FROM F_glowneDane WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		return $rekord['ksywka'];

}

###############################

function Werdykt($id1, $glownePunkty1, $id2, $glownePunkty2)  {


	if ($glownePunkty1>$glownePunkty2) {
			$tempPunkty=$glownePunkty1+5;
			$tempPunkty=rand(1, $tempPunkty);
				if ($tempPunkty>$glownePunkty1){
					$wygral=$id2;
				} else {
			$wygral=$id1;
					}
	}
	if ($glownePunkty1<$glownePunkty2) {
			$tempPunkty=$glownePunkty2+5;
			$tempPunkty=rand(1, $tempPunkty);
				if ($tempPunkty>$glownePunkty2){
					$wygral=$id1;
				} else {
			$wygral=$id2;
					}
	}
	if ($glownePunkty1==$glownePunkty2) {
			if ($id1<$id2) {
			$wygral=$id1;
			}
			if ($id1>$id2) {
			$wygral=$id2;
			}

	}
	return $wygral;
}

######################################

function Respect($id) {


		$query = "SELECT styl FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

	if ((0<$pkt_stylu) && ($pkt_stylu<=700)){
		$respect = "Dziecko Rapu";
	}

	if ((700<$pkt_stylu) && ($pkt_stylu<=1200)) {
		$respect = "Osiedlowy Rap";
	}

	if ((1200<$pkt_stylu) && ($pkt_stylu<=2500)) {
		$respect = "Rap z Boiska";
	}

	if ((2500<$pkt_stylu) && ($pkt_stylu<=5000)) {
		$respect = "Rap z Krwi i Kosci";
	}

	if ((5000<$pkt_stylu) && ($pkt_stylu<=10000)) {
		$respect = "Rap Zajawka od Lat";
	}

	if ((10000<$pkt_stylu) && ($pkt_stylu<=20000)) {
		$respect = "Rekin Rapu";
	}

	if ((20000<$pkt_stylu) && ($pkt_stylu<=30000)) {
		$respect = "Samuraj Rapu";
	}

	if ((30000<$pkt_stylu) && ($pkt_stylu<=45000)) {
		$respect = "Extra gangsta rap";
	}

	if ((45000<$pkt_stylu) && ($pkt_stylu<=60000)) {
		$respect = "Super Hiper Mega MC";
	}

	if ((60000<$pkt_stylu) && ($pkt_stylu<=80000)){
		$respect = "God of Rap";
	}

	if ((80000<$pkt_stylu) ){
		$respect = "Masta of Dizasta";
	}

	return $respect;
}


###################

function WyrownajKsywke($Ksywka) {


		$temp = strlen($Ksywka);
		$temp = 10-$temp;
		$temp = $temp/2;
		$temp = floor($temp);
		for ($a=0; $a<$temp; $a++) {
				$Ksywka = "%20" .$Ksywka;
		}

		return $Ksywka;
}

#####################

function Punkty($glownePunkty, $pkt_stylu, $flow, $wiedza, $napiecie) {

	return $glownePunkty+round(sqrt($pkt_stylu)/9)+round($flow/5)+floor($wiedza/7)-floor($napiecie/10);

}

######################

function SprawdzPunche($id) {


		$query2 = "SELECT * FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query2);
		$rekord = mysql_fetch_array ($wynik);

		if ($rekord[10] == 0) {
			return 0;
		} else {
			$zostalo=$rekord[10]-1;
			$query = "UPDATE F_stats SET punche='$zostalo' WHERE id='$id'";
			mysql_query($query);
			return 1;
			}

}

#############################

function Fristajluj($id, $energia, $inteligencja, $wiedza) {
	$ksywka = Ksywka($id);
	if ($wiedza<=15) {
		$zakresp=0;
		$zakresk=$wiedza-1;
	} elseif ($wiedza>32) {
		$zakresk=32;
		$zakresp=$zakresk-15;
	} else {
		$zakresk=$wiedza-1;
		$zakresp=$zakresk-15;
	}
	$punkty = (ceil($energia/10));
	for ($a=0; $a<6; $a++){
	if ($inteligencja>=80) {
		$zmiennaPuncha = 1;
	} else {
		$zmiennaPuncha=80-$inteligencja;
		$zmiennaPuncha=round($zmiennaPuncha/10);
	}
		$pp = rand(1,$zmiennaPuncha); //prawdopodobienstwo uzycia puncha

	if ($pp==1) {
		$punch=SprawdzPunche($id);
		if ($punch) {
		$text=$text .LosujPunch();
		$punkty = $punkty+5;
		} else {
		$text = $text .LosujWersy($zakresp,$zakresk);
		$punkty=$punkty+2;
		}
	} else {
		$text = $text .LosujWersy($zakresp,$zakresk);
		$punkty=$punkty+2;
	}
	}
	$text = pl_win2iso($text);
	#$zakres = $zakresp .'/' .$zakresk;
	$tablica = array ($punkty, $text);
return $tablica;

}

#############################

function Wynik($id1, $id2, $id3) {

	if (($id1==$id2) || ($id1==$id3)) {
		return $id1;
	}
	if ($id2==$id3) {
		return $id2;
	}
}

############################

function KtoWygral($id1, $id2, $idWin) {

	if ($id1==$idWin) {
		$tablica = array ($id1, $id2);
	} else {
		$tablica = array ($id2, $id1);
	}

	return $tablica;
}

##############################




function Walcz($id1, $id2, $punche1, $dynamika1, $punche2, $dynamika2, $liga=0) {

	$data =  date("Y-m-d");

		###################
		## ZAWODNIK 1SZY ##
		###################

	$statsy = PrzekazStatsy($id1);
	$energia1 = $statsy[0];
	$inteligencja_aktualna1 = $statsy[2];
	$wiedza1 = $statsy[3];
	$flow1 = $statsy[4];
	$pkt_stylu1 = $statsy[5];
	$napiecie1 = $statsy[6];

	 $free1 = Fristajluj2($id1, $energia1, $inteligencja_aktualna1, $wiedza1, $punche1, $dynamika1);
	 $punktyZaWersy1 = $free1[0];

	 $text_1 = $free1[1]; #### text fristajlu 1szego typa

	 $glownePunkty1 = round(UstalForme($id1)*Punkty($punktyZaWersy1, $pkt_stylu1, $flow1, $wiedza1, $napiecie1));

		###################
		## ZAWODNIK 2GI  ##
		###################

	$statsy = PrzekazStatsy($id2);
	$energia2 = $statsy[0];
	$inteligencja_aktualna2 = $statsy[2];
	$wiedza2 = $statsy[3];
	$flow2 = $statsy[4];
	$pkt_stylu2 = $statsy[5];
	$napiecie2 = $statsy[6];

	 $free2 = Fristajluj2($id2, $energia2, $inteligencja_aktualna2, $wiedza2, $punche2, $dynamika2);
	 $punktyZaWersy2 = $free2[0];

	 $text_2 = $free2[1]; #### text fristajlu 2go typa

	 $glownePunkty2 = round(UstalForme($id2)*Punkty($punktyZaWersy2, $pkt_stylu2, $flow2, $wiedza2, $napiecie2));

	$werdykt1=Werdykt($id1, $glownePunkty1, $id2, $glownePunkty2);
	$werdykt2=Werdykt($id1, $glownePunkty1, $id2, $glownePunkty2);
	$werdykt3=Werdykt($id1, $glownePunkty1, $id2, $glownePunkty2);

	$winner=Wynik($werdykt1, $werdykt2, $werdykt3); //id zwyciescy
	$wynik=KtoWygral($id1, $id2, $winner);

	$werdykt = Ksywka($werdykt1) ."==+=" .Ksywka($werdykt2) ."==+=" .Ksywka($werdykt3);
	$query = "INSERT INTO F_archiwum (nr_walki, id_kto, id_zkim, text_1, text_2, data, werdykt) VALUES ('', '$id1', '$id2',  '$text_1', '$text_2', '$data', '$werdykt')";
        mysql_query($query);

	UaktualnijStatsy($wynik[0], $wynik[1]);

if ($id1==$wynik[0]) { ##1szy id wygral
		$male_win = $glownePunkty1;
		$male_los = $glownePunkty2;
} else {
		$male_los = $glownePunkty1;
		$male_win = $glownePunkty2;
}
	if ($liga==1) {
		DodajHajs($wynik[0], 800);
		$query = "SELECT pkt_duze, pkt_male FROM F_liga WHERE `id`='$wynik[0]'";
		$resp = mysql_query($query);
		$rekord = mysql_fetch_array ($resp);
		$rekord['pkt_duze'] = $rekord['pkt_duze'] + 3;
		$rekord['pkt_male'] = $rekord['pkt_male'] + $male_win;
		$query = "UPDATE F_liga SET pkt_duze = '$rekord[pkt_duze]', pkt_male = '$rekord[pkt_male]' WHERE id = '$wynik[0]'";
        mysql_query($query);

		$query = "SELECT pkt_male FROM F_liga WHERE `id`='$wynik[1]'";
		$resp = mysql_query($query);
		$rekord = mysql_fetch_array ($resp);
		$rekord['pkt_male'] = $rekord['pkt_male'] + $male_los;
		$query = "UPDATE F_liga SET pkt_male = '$rekord[pkt_male]' WHERE id = '$wynik[1]'";
        mysql_query($query);
		}

	ZmienIloscWalk($wynik[0], 1);
	ZmienIloscWalk($wynik[1], 2);

if ($dynamika1==0) {
$odejmij1 = 0.7;
}
if ($dynamika1==1) {
$odejmij1 = 0.4;
}
if ($dynamika1==2) {
$odejmij1 = 0.1;
}
if ($dynamika2==0) {
$odejmij2 = 0.7;
}
if ($dynamika2==1) {
$odejmij2 = 0.4;
}
if ($dynamika2==2) {
$odejmij2 = 0.1;
}


		$query = "SELECT energia_aktualna FROM F_stats WHERE id='$id1'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$energia = round($rekord['energia_aktualna']*$odejmij1);
		$queryWin = "UPDATE F_stats SET energia_aktualna='$energia' WHERE id='$id1'";
		mysql_query($queryWin);
		$query = "SELECT energia_aktualna FROM F_stats WHERE id='$id2'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$energia = round($rekord['energia_aktualna']*$odejmij2);
		$queryWin = "UPDATE F_stats SET energia_aktualna='$energia' WHERE id='$id2'";
		mysql_query($queryWin);




}


##############################


function Fristajluj2($id, $energia, $inteligencja, $wiedza, $punche, $dynamika) {

$forma = UstalForme($id);
$wiedza = round($wiedza*$forma);
	if ($wiedza<=15) {
		$zakresp=0;
		$zakresk=$wiedza-1;
	} elseif ($wiedza>32) {
		$zakresk=32;
		$zakresp=$zakresk-15;
	} else {
		$zakresk=$wiedza-1;
		$zakresp=$zakresk-15;
	}

	switch ($dynamika) {
	case 0:
	$punkty = (ceil($energia/10));
	break;

	case 1:
	$punkty = (ceil($energia/9));
	break;

	case 2:
	$punkty = (ceil($energia/8));
	break;

	}

	for ($a=6; $a>0; $a--){

	if ($punche==$a) {
		$losuj=1;
	} elseif ($punche!=0) {
		$losuj = rand(1, 2);

	} else {
		$losuj = 0;
	}

	if ($losuj==1) {
		$punch=SprawdzPunche($id);
		if ($punch) {
		$text=$text .LosujPunch();
		$punche--;
		$punkty = $punkty+5;
		} else {
		$text = $text .LosujWersy($zakresp,$zakresk);
		$punkty=$punkty+2;
		}
	} else {
		$text = $text .LosujWersy($zakresp,$zakresk);
		$punkty=$punkty+2;
	}
	}
	$text = pl_win2iso($text);
	#$zakres = $zakresp .'/' .$zakresk;
	$tablica = array ($punkty, $text);
return $tablica;

}

###############################

function PokazWalke($nrWalki) {



	$query2 = "SELECT * FROM F_archiwum WHERE nr_walki='$nrWalki'";
    $wynik = mysql_query($query2);
	$rekord = mysql_fetch_array ($wynik);
return $rekord;

}

###############################

function UaktualnijStatsy($win, $lose) {   //po walce


	$statsWin = PrzekazStatsyBazowe($win);
	$statsLose = PrzekazStatsyBazowe($lose);

		$stylWin = $statsWin[5]+ceil($statsLose[5]*0.02);
		$napiecieWin = $statsWin[6]-5;
		$flowWin = $statsWin[4]+ceil($statsWin[4]*0.03);
		$intWin = $statsWin[1]+ceil($statsWin[1]*0.02);
		$wiedzaWin = $statsWin[3]+ceil($statsWin[3]*0.02);

		$napiecieLose = $statsLose[6]+3;
		$flowLose = $statsLose[4]+round($statsLose[4]*0.02);
		$queryWin = "UPDATE F_stats SET styl='$stylWin', napiecie='$napiecieWin', flow='$flowWin', inteligencja='$intWin', wiedza='$wiedzaWin' WHERE id='$win'";
			mysql_query($queryWin);
		$queryLose = "UPDATE F_stats SET napiecie='$napiecieLose', flow='$flowLose' WHERE id='$lose'";
			mysql_query($queryLose);

}


#################################

function ZmienIloscWalk($id, $status) {

	$query = "SELECT * FROM F_walki WHERE id='$id'";
    $wynik = mysql_query($query);
	$rekord = mysql_fetch_array ($wynik);

	if ($status==1) {
		$win = $rekord[1]+1;
		$pytanie = "UPDATE F_walki SET wygrane='$win' WHERE id='$id'";
	}
	if ($status==2) {
		$lose = $rekord[2]+1;
		$pytanie = "UPDATE F_walki SET przegrane='$lose' WHERE id='$id'";
	}

	mysql_query($pytanie);

}

###################################

function WyswietlFormularzRejestracyjny() {
	return "<form method=\"post\" action=\"rejestracja.php\"> <table>		<tr><td><font>ksywka: </font><br><font size=-2><i>max. 10 znakow, bez znakow specjalnych</i></font></td><td><input type=\"text\" name=\"ksywka\" style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr>
		<tr><td><font>adres email: </font><br><font size=-2><i>potrzebny do obslugi konta</i></font></td><td><input type=\"text\" name=\"email\" style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr></table>
		<input type=\"submit\" name=\"wyslane\" value=\"Wyslij\" style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'> ";

}


#######################


function GenerujHaslo() {
	$znaki = "abcdefghijklmoprstuwxyzq";
	for ($a=0; $a<4; $a++) {
		$liczba =rand(0,9);
		$haslo = $haslo .$liczba;
	}
	for ($a=0; $a<2; $a++) {
		$liczba =rand(0,23);
		$haslo = $haslo .$znaki[$liczba];
	}
	return $haslo;
}


####################

function WprowadzDane($ksywka, $haslo, $email) {

	$haslo = md5($haslo);

	$query = "INSERT INTO F_glowneDane (ksywka, email, haslo) VALUES ('$ksywka', '$email', '$haslo')";
        mysql_query($query);
}

####################

function WyslijEmailRejestracyjny($email, $ksywka, $haslo) {

	$mailTemat = "Rejestracja w systemie FIRSTAJLERS.NET";
	$mailTresc = "Witaj!\n\nAby zarejestrowac sie do systemu, przejdz na strone glowna (http://fristajlers.net) i podaj swoje haslo oraz login";
	$mailTresc .= "\n\nlogin: $ksywka\nhaslo: $haslo\n\nZyczymy dobrej zabawy.\nTworcy FRISTAJLERS";
	$mailNaglowek = "From: fristajlers.net <>";

	mail($email, $mailTemat, $mailTresc, $mailNaglowek);

}

########################

function SprawdzKsywke($ksywka) {


	$query = "SELECT * FROM F_glowneDane WHERE `ksywka`='$ksywka'";
	$resp = mysql_query($query);

	if (mysql_num_rows($resp) == 0) {
		return 1;
	} else {
		return 0;
	}
}

#########################

function SprawdzMejl($email) {


	$query = "SELECT * FROM F_glowneDane WHERE `email`='$email'";
	$resp = mysql_query($query);

	if (mysql_num_rows($resp) == 0) {
		return 1;
	} else {
		return 0;
	}
}

########################

function SprawdzPoprawnoscMejla($email)
{
		$pat1 = "@";
		$emailarr = split ($pat1,$email);
		$email1 = $emailarr[0];
		$email2 = $emailarr[1];
		$email = trim($email);
		$elen = strlen($email);
		$dotpresent = 0;
		for ($i=2;$i<=$elen;$i++)
		{
			$j = substr($email,0,$i);
			$jlen = strlen($j);
			$lastj = substr($j,$jlen-1,$jlen);
			$asci = ord($lastj);
			if ($asci==46)
			{
				$dotpresent = 1;
			}
		}
		$spaceexist = 0;
		for ($k=0;$k<$elen;$k++)
		{
			$myword = substr($email,$k,1);
			if (ord($myword)==32)
			{
				$spaceexist = 1;
			}
		}
		if ($email2)
		{
			$atpresent = 1;
		}
		if ($atpresent=='1' AND $dotpresent=='1' AND $spaceexist=='0')
		{
			$validmail = 1;
		}
		else
		{
			$validmail = 0;
		}
		return ($validmail);
}

#######################


function WyswietlFormularzDoLogowania() {
	return "<form method=\"post\" action=logowanie.php> <table><tr><td><font class=stats>ksywka:</font></td><td><input type=\"text\" name=\"ksywka\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr>
		<tr><td><font class=stats>haslo:</font></td><td><input type=\"password\" name=\"haslo\" size=14 style='padding:0px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;'></td></tr></table>
<table border=0>
	<tr>
		<td><input type=\"submit\" name=\"wyslane\" value=\"Wbitka\" style='font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;'></FORM></td>
		<td>		<form method=\"post\" action=rejestracja.php>	<input type=\"submit\" value=\"Rejestracja\" style='font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;'></form></td>
	</tr>
</table>
 ";
}


#######################

function KsywkaDoID($ksywka)  {



		$query = "SELECT id FROM F_glowneDane WHERE ksywka='$ksywka'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		return $rekord['id'];
}

###################################

function PierwszeLogowanie($id) {

	$query = "SELECT * FROM F_walki WHERE `id`='$id'";
	$resp = mysql_query($query);

	if (mysql_num_rows($resp) == 0) {
		return 1;
	} else {
		return 0;
	}
}

##################################

function SprawdzDate($txtData)
{
    //controlla della data     //date validation
    //controllo del formato gg/mm/aaaa  e recupero dei componenti della data :)       //Date Format DD/MM/YYYY
    if(ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $txtData, $aDate))    //$aDate[1]->GG, $aDate[2]->MM e $aDate[3]->AAAA
    {   //formato corretto controlla i valori
        $aGiorni=array(0,31,29,31,30,31,30,31,31,30,31,30,31);
        if($aDate[1]<1900 || $aDate[1]>2100) //y10k bug :)))
             $errMex.=((strlen($errMex)>0)?"<br>":"")."Niepoprawny Rok";    //not a valid Year
        else
             if($aDate[2]<1 || $aDate[2]>12)
                 $errMex.=((strlen($errMex)>0)?"<br>":"")."Niepoprawny miesi±c";     //not a valid Month
             else
             {
                 $giorni=($aGiorni[$aDate[2]-0]+((2==$aDate[2])?((!($aDate[1]%4) && $aDate[1]%100) || !($aDate[1]%400)):0));
                 if($aDate[3]<1 || $aDate[3]>$giorni)
                     $errMex.=((strlen($errMex)>0)?"<br>":"")."Niepoprawny dzieñ!";     //not a valid Day
                 else
                     return true;
             }
    }
    else
        $errMex.=((strlen($errMex)>0)?"<br>":"")."Niepoprawny format daty (DD-MM-RRRR)";    //not a valid date format

    return $errMex;
}

##############################

function Logo($id)  {



		$query = "SELECT logo FROM F_glowneDane WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		return $rekord['logo'];


}

##############################

function Hajs($id)  {


		$query = "SELECT hajs FROM F_inne WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		return $rekord['hajs'];


}

##############################

function StosunekWalk($id)  {


		$query = "SELECT wygrane, przegrane FROM F_walki WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$rekord['przegrane'] = $rekord['przegrane']+$rekord['wygrane'];
		$zwrot = $rekord['wygrane'] .'/' .$rekord['przegrane'];
		return $zwrot;


}

##############################

function OdejmijEnergie($id)  {


		$query = "SELECT energia_aktualna FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$energia = $rekord['energia_aktualna']-1;
		$queryWin = "UPDATE F_stats SET energia_aktualna='$energia' WHERE id='$id'";
		mysql_query($queryWin);
		return true;


}

##############################

function Odpoczywaj($id)  {




		$query = "SELECT energia, energia_aktualna, kondycja FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$kondycja=$rekord['kondycja'];
		$energia = $rekord['energia'];
		$energia_akt = $rekord['energia_aktualna'];
		if (($energia_akt+$kondycja)>$energia) {
			$energia_akt=$energia;
		} else {
			$energia_akt=$energia_akt+$kondycja;
		}
		$queryWin = "UPDATE F_stats SET energia_aktualna='$energia_akt' WHERE id='$id'";
		mysql_query($queryWin);
		return true;




}
##############################

function PiszWiadomosc($idkto, $iddo, $co)  {


	$data =  date("Y-m-d H:i:s");

		$co = addslashes($co);
		$query = "INSERT INTO F_poczta (id_kto, id_do, data, co) VALUES ('$idkto', '$iddo',  '$data', '$co')";
        mysql_query($query);




}

##############################

function OdejmijHajs($id, $ile)  {



		$query = "SELECT hajs FROM F_inne WHERE id='$id'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$hajs = $rekord['hajs']-$ile;
		$queryHajs = "UPDATE F_inne SET hajs='$hajs' WHERE id='$id'";
        mysql_query($queryHajs);

		return true;


}

##############################

function DodajHajs($id, $ile)  {



		$query = "SELECT hajs FROM F_inne WHERE id='$id'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$hajs = $rekord['hajs']+$ile;
		$queryHajs = "UPDATE F_inne SET hajs='$hajs' WHERE id='$id'";
        mysql_query($queryHajs);

		return true;


}
##############################

function OSobie($id)  {



		$query = "SELECT o_sobie FROM F_glowneDane WHERE id='$id'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

		return $rekord['o_sobie'];


}

#########################


function PrzywrocIntNap($id)  {




		$query = "SELECT inteligencja, napiecie FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$inteligencja = $rekord['inteligencja'];
		$napiecie = $rekord['napiecie'];
		$queryWin = "UPDATE F_stats SET inteligencja_aktualna='$inteligencja', napiecie_aktualne='$napiecie' WHERE id='$id'";
		mysql_query($queryWin);
		return true;




}
##############################

function NoweWiad($id)  {



		$query = "SELECT count(*) FROM F_poczta WHERE czytane='0' AND id_do='$id'";
        $wynik = mysql_query($query);
	    $rekord = mysql_fetch_array ($wynik);

		if (($rekord[0]) == 0) {
		} else {
		$string='<a href=main.php?lokacja=poczta><img src=gfx/meil.png border=0 alt="Nowe wiadomosci"><font class=stats> [' .$rekord[0] .']</font></a>';
		return $string;
	}

}

############################
function Punche($id)  {


		$query = "SELECT punche FROM F_stats WHERE id='$id' AND punche <> 0";
        $wynik = mysql_query($query);

		if (mysql_num_rows($wynik) == 0) {

		} else {
		$rekord = mysql_fetch_array ($wynik);
		$string = 'punche: ' .$rekord['punche'] .'<br>';
		return $string;
	}

}
##############################

function SprawdzEkipe($ekipa) {


	$query = "SELECT * FROM F_ekipy WHERE `nazwa`='$ekipa'";
	$resp = mysql_query($query);

	if (mysql_num_rows($resp) == 0) {
		return 1;
	} else {
		return 0;
	}
}

#############################

function CzyWEkipie($id) {

$query = "SELECT ekipa FROM F_glowneDane WHERE `id`='$id' AND ekipa <> '0'";
$resp = mysql_query($query);
	if (mysql_num_rows($resp) == 0) {

		return 0;

	} else {


	$rekord = mysql_fetch_array ($resp);
	$ekipa=$rekord['ekipa'];
$query = "SELECT * FROM F_ekipy WHERE `id_szef`='$id' AND id_ekipy='$ekipa'";
$wynik = mysql_query($query);
		if (mysql_num_rows($wynik) == 0) {
			return 2;
		} else {
			return 1;
		}

	}
}

#############################

function NrEkipy($id) {

$query = "SELECT ekipa FROM F_glowneDane WHERE `id`='$id'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

	return $rekord['ekipa'];


}
#############################

function Liga($id) {

$query = "SELECT liga FROM F_liga WHERE `id`='$id'";
$resp = mysql_query($query);
		if (mysql_num_rows($resp) == 0) {

	return 0;

		} else {
$rekord = mysql_fetch_array ($resp);

	return $rekord['liga'];
		}

}

#############################

function Ekipa($nr) {

$query = "SELECT * FROM F_ekipy WHERE `id_ekipy`='$nr'";
$resp = mysql_query($query);
$tablica = mysql_fetch_array ($resp);

	#$tablica = array ($rekord[0], $rekord[1], $rekord[2], $rekord[3], $rekord[4], $rekord[5], $rekord[6], );
	return $tablica;

}

###########################

function CzyZaproszony($id) {

$query = "SELECT id_ekipy FROM F_ekipyDodaj WHERE `id_kto`='$id'";
$resp = mysql_query($query);
	if (mysql_num_rows($resp) == 0) {

		return 0;

	} else {
   	$rekord = mysql_fetch_array ($resp);
	return $rekord['id_ekipy'];

	}

}

#########################

function Szama($typTowaru) {

$query = "SELECT * FROM F_sklepyTowary WHERE `typTowaru`='$typTowaru'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;
}

##################################################

function Bron($typTowaru) {

$query = "SELECT * FROM F_bronRodzaje WHERE `lp`='$typTowaru'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;
}

#########################

function PelneInv($id) {

$query = "SELECT count(*) FROM F_skrytkaItemy WHERE `id_kto`='$id'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

	if ($rekord[0]>=12) {
		return 0;
	} else {
		return 1;
	}
}

#######################


function Znalazl($id) {

$query = "SELECT * FROM F_znalazl WHERE `id`='$id'";
$resp = mysql_query($query);

 return mysql_num_rows($resp);
}

#######################


function DodajZnalazl($id) {

$query = "INSERT INTO F_znalazl (id) VALUES ('$id')";
$resp = mysql_query($query);

}

#######################


function CzyscZnalazl() {

$query = "DELETE FROM F_znalazl";
$resp = mysql_query($query);

}

#######################

function LosujPrzedmiot($id) {

	srand(time());
	$rand = rand(0, 101);

if ((0<$rand) && ($rand<=50)){
		$rare = 1;
	}

if ((50<$rand) && ($rand<=70)){
		$rare = 2;
	}

if ((70<$rand) && ($rand<=82)){
		$rare = 3;
	}
if ((90<$rand) && ($rand<=96)){
		$rare = 4;
	}
if (96<$rand){
		$rare = 5;
	}

$query = "SELECT lp FROM F_itemy WHERE `rare`='$rare'";
$resp = mysql_query($query);
	while($rekord = mysql_fetch_array ($resp)) {
		$elpy[] = $rekord['lp'];
	}
$rand = rand(0, count($elpy));
if ($elpy[$rand]==0) { $elpy[$rand] = 2; }
return $elpy[$rand];

}

#########################

function Itemy($typTowaru) {

$query = "SELECT * FROM F_itemy WHERE `lp`='$typTowaru'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;
}

#########################

function Dziwka($typTowaru) {

$query = "SELECT * FROM F_burdeleDziwki WHERE `dziwka`='$typTowaru'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;
}

#########################

function ZamianaHajsu($id_kto, $id_komu, $ile) {

		$query = "SELECT hajs FROM F_inne WHERE id='$id_kto'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$hajs = $rekord['hajs']-$ile;
		$queryHajs = "UPDATE F_inne SET hajs='$hajs' WHERE id='$id_kto'";
        mysql_query($queryHajs);
		$query = "SELECT hajs FROM F_inne WHERE id='$id_komu'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$hajs = $rekord['hajs']+$ile;
		$queryHajs = "UPDATE F_inne SET hajs='$hajs' WHERE id='$id_komu'";
        mysql_query($queryHajs);
		return true;
}
#########################

function Drag($typDraga) {

$query = "SELECT * FROM F_dilerkaDragi WHERE `typDraga`='$typDraga'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;

}

#########################

function Trening($typTreningu) {

$query = "SELECT * FROM F_sportyTreningi WHERE `typTreningu`='$typTreningu'";
$resp = mysql_query($query);
$rekord = mysql_fetch_array ($resp);

return $rekord;

}

#########################

function CzyDiluje($id) {

$query = "SELECT * FROM F_dilerka WHERE `id_kto`='$id'";
$resp = mysql_query($query);
if (mysql_num_rows($resp) == 0) {
		return 0;

	} else {
		return 1;
	}

}

#########################

function MaSklep($id) {

$query = "SELECT * FROM F_sklepy WHERE `id_wlasc`='$id'";
$resp = mysql_query($query);
if (mysql_num_rows($resp) == 0) {
		return 0;

	} else {
		$rekord = mysql_fetch_array ($resp);
		return $rekord['sklep_id'];
	}

}

##################################################

function MaBron($id) {

$query = "SELECT * FROM F_bron WHERE `id_wlasc`='$id'";
$resp = mysql_query($query);
if (mysql_num_rows($resp) == 0) {
		return 0;

	} else {
		$rekord = mysql_fetch_array ($resp);
		return $rekord['bron_id'];
	}

}

#########################

function MaBurdel($id) {

$query = "SELECT * FROM F_burdele WHERE `id_wlasc`='$id'";
$resp = mysql_query($query);
if (mysql_num_rows($resp) == 0) {
		return 0;

	} else {
		$rekord = mysql_fetch_array ($resp);
		return $rekord['burdel_id'];
	}

}

#########################

function Randomy() {

	$query2 = "SELECT id_kto FROM F_dilerka";
	    $wynik2 = mysql_query($query2);
	while($rekord2 = mysql_fetch_array ($wynik2)) {
		$rand = rand(1, 255);
		$query = "UPDATE F_dilerka SET rand='$rand' WHERE id_kto='$rekord2[id_kto]'";
	mysql_query($query);
	}


	$query23 = "SELECT sklep_id FROM F_sklepy";
	    $wynik23 = mysql_query($query23);
	while($rekord23 = mysql_fetch_array ($wynik23)) {
		$rand2 = rand(1, 255);
		$queryq = "UPDATE F_sklepy SET rand='$rand2' WHERE sklep_id='$rekord23[sklep_id]'";
	mysql_query($queryq);
	}

		$query223 = "SELECT sport_id FROM F_sporty";
	    $wynik223 = mysql_query($query223);
	while($rekord223 = mysql_fetch_array ($wynik223)) {
		$rand22 = rand(1, 255);
		$queryq2 = "UPDATE F_sporty SET rand='$rand22' WHERE sport_id='$rekord223[sport_id]'";
	mysql_query($queryq2);
	}
		$query2223 = "SELECT burdel_id FROM F_burdele";
	    $wynik2223 = mysql_query($query2223);
	while($rekord2223 = mysql_fetch_array ($wynik2223)) {
		$rand22 = rand(1, 255);
		$queryq22 = "UPDATE F_burdele SET rand='$rand22' WHERE burdel_id='$rekord2223[burdel_id]'";
	mysql_query($queryq22);
	}

}


#########################

function MaKs($id) {

$query = "SELECT * FROM F_sporty WHERE `id_wlasc`='$id'";
$resp = mysql_query($query);
if (mysql_num_rows($resp) == 0) {
		return 0;

	} else {
		$rekord = mysql_fetch_array ($resp);
		return $rekord['sport_id'];
	}

}

#############################

function ModyfikatorCen($cena, $id) {

;

		$query = "SELECT styl FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];


	if ((0<$pkt_stylu) && ($pkt_stylu<=700)){
		$cena = $cena;
	}

	if ((700<$pkt_stylu) && ($pkt_stylu<=1200)) {
		$cena = $cena;
	}

	if ((1200<$pkt_stylu) && ($pkt_stylu<=2500)) {
		$cena = $cena-round($cena*0.1);
	}

	if ((2500<$pkt_stylu) && ($pkt_stylu<=5000)) {
		$cena = $cena-round($cena*0.15);
	}

	if ((5000<$pkt_stylu) && ($pkt_stylu<=10000)) {
		$cena = $cena-round($cena*0.2);
	}

	if ((10000<$pkt_stylu) && ($pkt_stylu<=20000)) {
		$cena = $cena-round($cena*0.25);
	}

	if ((20000<$pkt_stylu) && ($pkt_stylu<=30000)) {
		$cena = $cena-round($cena*0.3);
	}

	if ((30000<$pkt_stylu) && ($pkt_stylu<=45000)) {
		$cena = $cena-round($cena*0.35);
	}

	if ((45000<$pkt_stylu) && ($pkt_stylu<=60000)) {
		$cena = $cena-round($cena*0.45);
	}

	if ((60000<$pkt_stylu) && ($pkt_stylu<=80000)){
		$cena = $cena-round($cena*0.6);
	}

	if ((80000<$pkt_stylu) ){
		$cena = $cena-round($cena*0.7);
	}
	if (CzyWEkipie($id)!=0) {
	$nr=NrEkipy($id);
	$ekipa=Ekipa($nr);
			  	$querye = "SELECT count(*) FROM F_glowneDane WHERE ekipa='$nr'";
		        $wynike = mysql_query($querye);
				$rekorde = mysql_fetch_array ($wynike);
				$czlonkow = $rekorde[0];
	if ($ekipa[6]>1100 && $czlonkow>3) {
		$cena = $cena-round($cena*0.1);
	}
	if ($ekipa[6]>2000 && $czlonkow>4) {
		$cena = $cena-round($cena*0.05);
	}
	if ($ekipa[6]>3000 && $czlonkow>5) {
		$cena = $cena-round($cena*0.05);
	}
	}

	return $cena;
}


###################

function Odsetki($id) {

$query = "SELECT hajs, data FROM F_bank WHERE id='$id'";
				$wynik = mysql_query($query);
				$rekord = mysql_fetch_array ($wynik);

$data =  date("Y-m-d");
$dzis = strtotime($data);
$a = strtotime($rekord['data']);

$ble = ($dzis-$a)/3600/24;

$hajs=$rekord['hajs'];
for ($i=0; $i<$ble; $i++) {

$hajs = $hajs+($hajs*0.01);

}

$hajs = round($hajs);
$query = "UPDATE F_bank SET hajs='$hajs', data='$data' WHERE id='$id'";
				mysql_query($query);

$odsetki = $hajs-$rekord['hajs'];
$co = pl_win2iso("Stan Twojego konta wynosi obecnie $hajs PLN. Naliczono $odsetki PLN odsetek w ci¹gu $ble dni.");

PiszWiadomosc(0, $id, $co);

}

######################

function Forma($id) {

		$query = "SELECT styl FROM F_stats WHERE id='$id'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$max = ceil(sqrt($rekord['styl']));
		$forma = rand(0, $max);

		$query = "UPDATE F_stats SET forma='$forma' WHERE id='$id'";
		mysql_query($query);
}

######################

function UstalForme($id) {

		$query = "SELECT forma FROM F_stats WHERE id='$id'";
	    $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);

	if ((0<=$rekord['forma']) && ($rekord['forma']<=8)){
		$forma = 0.7;
	}

	if ((8<$rekord['forma']) && ($rekord['forma']<=13)){
		$forma = 0.9;
	}


	if ((13<$rekord['forma']) && ($rekord['forma']<=29)){
		$forma = 1;
	}

	if ((29<$rekord['forma']) && ($rekord['forma']<=39)){
		$forma = 1.1;
	}

	if (39<$rekord['forma']) {
		$forma = 1.3;
	}

	return $forma;
}

#######################

function WyswietlForme($forma) {

switch ($forma) {
	case 0.7:
		$opis = pl_win2iso('<font class=kiepska><b>kiepska</b></font>');
	break;

	case 0.9:
		$opis = pl_win2iso('<font class=slaba><b>slaba</b></font>');
	break;

	case 1:
		$opis = pl_win2iso('<font><b>neutralna</b></font>');
	break;

	case 1.1:
		$opis = pl_win2iso('<font class=dobra><b>dobra</b></font>');
	break;

	case 1.3:
		$opis = pl_win2iso('<font class=mistrzowa><b>mistrzowska</b></font>');
	break;
}

return $opis;
}


######################

function StylEkipy($nr) {

		$queryq = "SELECT id FROM F_glowneDane WHERE ekipa='$nr'";
    $wynikq = mysql_query($queryq);
	$i=0;

	while ($rekordq = mysql_fetch_array ($wynikq)) {

		$query = "SELECT styl FROM F_stats WHERE id='$rekordq[id]'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$styl_ekipy=$styl_ekipy+$rekord['styl'];
		$i++;

	}

		$styl_ekipy=round($styl_ekipy/$i);
		$query = "UPDATE F_ekipy SET styl='$styl_ekipy' WHERE id_ekipy='$nr'";
		mysql_query($query);


}

######################

function PowtarzajaceIp($nr) {

$query2 = "SELECT id, ip FROM F_glowneDane WHERE ip <> 0 ORDER BY ip";


 $wynik2 = mysql_query($query2);
 while($rekord2 = mysql_fetch_array ($wynik2)) {
	 $tabela[]=$rekord2['ip'];
  $i=count($tabela)-2;
 if ($tabela[$i]==$rekord2['ip']) {
	 echo Ksywka($rekord2['id']) .'<br>';
 }

 }

}

######################

function CenyMistrza() {


		$cena=rand(100, 600);
		$query = "UPDATE F_inne SET ciuchy='$cena' WHERE id='0'";
		mysql_query($query);


}

##########################

function DzialalnoscEkipy($nr) {

		$queryq = "SELECT id FROM F_glowneDane WHERE ekipa='$nr'";
    $wynikq = mysql_query($queryq);
	$i=0;

	while ($rekordq = mysql_fetch_array ($wynikq)) {

				$query = "SELECT count(*) FROM F_dilerka WHERE id_kto='$rekordq[id]'";
		        $wynik = mysql_query($query);
				$rekord = mysql_fetch_array ($wynik);
				$iluDilerow = $iluDilerow + $rekord[0];


				$query = "SELECT count(*) FROM F_sklepy WHERE id_wlasc='$rekordq[id]'";
		        $wynik = mysql_query($query);
				$rekord = mysql_fetch_array ($wynik);
				$ileSklepow = $ileSklepow + $rekord[0];

				$query = "SELECT count(*) FROM F_sporty WHERE id_wlasc='$rekordq[id]'";
		        $wynik = mysql_query($query);
				$rekord = mysql_fetch_array ($wynik);
				$ileSportow = $ileSportow + $rekord[0];

				$query = "SELECT count(*) FROM F_burdele WHERE id_wlasc='$rekordq[id]'";
		        $wynik = mysql_query($query);
				$rekord = mysql_fetch_array ($wynik);
				$ileBurdeli = $ileBurdeli + $rekord[0];

	}


		$query = "UPDATE F_ekipy SET silownie='$ileSportow', sklepy='$ileSklepow', dilerka='$iluDilerow', burdele='$ileBurdeli' WHERE id_ekipy='$nr'";
		mysql_query($query);


}


######################

function Transakcje($nr, $typ) {


$query = "SELECT * FROM F_transakcje WHERE nr='$nr' AND typ='$typ'";
				 $wynik = mysql_query($query);
				 if (mysql_num_rows($wynik) == 0) {
								$query = "INSERT INTO F_transakcje (nr, typ, ilosc) VALUES ('$nr', '$typ', '1')";
								mysql_query($query);

				 } else {

				$rekord = mysql_fetch_array ($wynik);
				$ile=$rekord[ilosc]+1;
		 		$query = "UPDATE F_transakcje SET ilosc='$ile' WHERE nr='$nr' AND typ='$typ'";
							 mysql_query($query);

				 }


}

#####################

function Grupy() {
	 $query2 = "SELECT * FROM F_stats ORDER BY styl DESC";

  $wynik2 = mysql_query($query2);
$grupa=1;
	while($rekord2 = mysql_fetch_array ($wynik2)) {
if ($i==0) {
	echo '<br><b>Grupa ' .$grupa .'</b><br>';
}
echo $i+1 .'.' .Ksywka($rekord2[id]) .' (' .$rekord2[id] .')<br>';
if ($i==7) {
	$i=0;
	$grupa++;
} else {
	$i++;
}
}
}

####################



function PuncheDoWalki($id) {

$query = "SELECT styl FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query);
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];


if ((0<$pkt_stylu) && ($pkt_stylu<=1200)) {
		$ilosc = 2;
	}

	if ((1200<$pkt_stylu) && ($pkt_stylu<=2500)) {
		$ilosc = 3;
	}

	if ((2500<$pkt_stylu) && ($pkt_stylu<=5000)) {
		$ilosc = 3;
	}

	if ((5000<$pkt_stylu) && ($pkt_stylu<=10000)) {
		$ilosc = 4;
	}

	if ((10000<$pkt_stylu) && ($pkt_stylu<=20000)) {
		$ilosc = 4;;
	}

	if ((20000<$pkt_stylu) && ($pkt_stylu<=30000)) {
		$ilosc = 5;
	}

	if ((30000<$pkt_stylu) && ($pkt_stylu<=45000)) {
		$ilosc = 5;
	}

	if ((45000<$pkt_stylu) && ($pkt_stylu<=60000)) {
		$ilosc = 6;
	}

	if (60000<$pkt_stylu) {
		$ilosc = 6;
	}

$query2 = "SELECT punche FROM F_stats WHERE id='$id'";
        $wynik = mysql_query($query2);
		$rekord = mysql_fetch_array ($wynik);

		if ($rekord['punche']<$ilosc) {
			$ilosc=$rekord['punche'];
		}
		return $ilosc;
}

###################

function NajblizszyTermin($id) {

## wolny=0 zajety=1 ###

$data = date("Y-m-d");
	$query = "SELECT * FROM F_wyzwania WHERE (id_kto = '$id' OR id_kogo = '$id') AND kiedy = '$data' AND pora=0";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				if (8<date("H"))	{
					$termin[0] = '1';
				} else {
					$termin[0] = '0';
				}
			} else {
				$termin[0] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=1";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				if (16<date("H"))	{
					$termin[1] = '1';
				} else {
					$termin[1] = '0';
				}
			} else {
				$termin[1] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=2";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[2] = '0';
			} else {
				$termin[2] = '1';
			}
$data =  mktime (0,0,0,date("m")  ,date("d")+1,date("Y"));
$data = date("Y-m-d", $data);
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=0";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[3] = '0';
			} else {
				$termin[3] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=1";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[4] = '0';
			} else {
				$termin[4] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=2";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[5] = '0';
			} else {
				$termin[5] = '1';
			}



$data =  mktime (0,0,0,date("m")  ,date("d")+2,date("Y"));
$data = date("Y-m-d", $data);
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=0";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[6] = '0';
			} else {
				$termin[6] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=1";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[7] = '0';
			} else {
				$termin[7] = '1';
			}
	$query = "SELECT * FROM F_wyzwania WHERE ((id_kto = '$id' OR id_kogo = '$id')) AND kiedy = '$data' AND pora=2";
        $wynik = mysql_query($query);
			if (mysql_num_rows($wynik) == 0) {
				$termin[8] = '0';
			} else {
				$termin[8] = '1';
			}


for($i=0;$i<count($termin);$i++) {
	if ($termin[$i]==0) {
		$wolny=$i+1;
		break;
	}
}
switch ($wolny) {
	case 0:
		$tresc = 'Brak wolnych terminow w ciagu najblizszych 3 dni';
		break;
	case 1:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d") .' 08:00';
		break;
	case 2:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d") .' 16:00';
		break;
	case 3:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d") .' 24:00';
		break;
	case 4:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+1,date("Y"))) .' 08:00';
		break;
	case 5:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+1,date("Y"))) .' 16:00';
		break;
	case 6:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+1,date("Y"))) .' 24:00';
		break;
	case 7:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+2,date("Y"))) .' 08:00';
		break;
	case 8:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+2,date("Y"))) .' 16:00';
		break;
	case 9:
		$tresc = 'Najblizszy wolny termin: ' .date("Y-m-d", mktime (0,0,0,date("m")  ,date("d")+2,date("Y"))) .' 24:00';
		break;
}

	return $tresc;
}

################
	function Onlajn($id) {
	$query = "SELECT id FROM Online WHERE `id`='$id'";
	$resp = mysql_query($query);

$time = time();

	if (mysql_num_rows($resp) == 0) {
			$query = "INSERT INTO Online (time, id) VALUES ('$time', '$id')";
	} else {
			$query = "UPDATE Online SET time = '$time' WHERE id='$id'";
	}
     mysql_query($query);
	}

########

	function OnlajnCzysc() {
	$time=time();
$bezczynnosc = 60*3;  ### 3 minuty

	 $time = $time-$bezczynnosc;

	 	$queryDel = "DELETE FROM Online WHERE time < '$time'";
	    mysql_query($queryDel);
	}

######################################

function Kondycja() {



			$query = "UPDATE F_stats SET kondycja='13' WHERE styl > '0' AND styl <= '700' AND kondycja <'13'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='15' WHERE styl > '700' AND styl <= '1200' AND kondycja <'15'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='17' WHERE styl > '1200' AND styl <= '2500' AND kondycja < '17'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='20' WHERE styl > '2500' AND styl <= '5000' AND kondycja < '20'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='25' WHERE styl > '5000' AND styl <= '10000' AND kondycja < '25'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='33' WHERE styl > '10000' AND styl <= '20000'  AND kondycja < '33'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='40' WHERE styl > '20000' AND styl <= '30000'  AND kondycja < '40'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='48' WHERE styl > '30000' AND styl <= '45000'  AND kondycja < '48'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='58' WHERE styl > '45000' AND styl <= '60000'  AND kondycja < '58'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='70' WHERE styl > '60000' AND styl <= '80000'  AND kondycja < '70'";
			mysql_query($query);

			$query = "UPDATE F_stats SET kondycja='85' WHERE styl > '80000'  AND kondycja < '85'";
			mysql_query($query);

}


###################



?>
