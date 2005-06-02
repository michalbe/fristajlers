<?
include('conf/stats.php');

if (!isset($_POST['tak'])) {

	$newsy = $newsy .'<center><br><font> Nowe dziwki do swojego burdelu mozesz zdobyc organizujac wypad za granice. Cena jednego wypadu to ' .ModyfikatorCen(1000, $id) .'HJS, w jego trakcie mozesz zlapac losowa ilosc dziwek. Wchodzisz w to?</font><br><br>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_zaopatrzenie">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM>
		<FORM METHOD=POST ACTION="main.php?lokacja=burdel_start">
	<INPUT TYPE="submit" value="nie">
	</FORM>';
} else {
	$hajs = Hajs($id);
				if ($hajs<ModyfikatorCen(1000, $id)) {
			$newsy = $newsy .'<center><br><font>Tysiaczek powiedzialem ziomus. Bez hajsu ani rusz!</font><br><br>';
				} else {
					srand(time());
					$super = rand(0, 1000);
					if ($super==1) { $dziwki=100; 
					$co = Ksywka($id) .' rozbil setke dziwek';
					$co = pl_win2iso($co);
					PiszWiadomosc(0, 1, $co);
					} else { $dziwki=rand(0, 9); } 

					if ($dziwki!=0) {
						$dziwkiP=rand(0,$dziwki);
						$dziwki=$dziwki-$dziwkiP;
					} else {
						$dziwkiP=0;
					}

					if ($dziwki!=0) {
						$dziwkiD=rand(0,$dziwki);
						$dziwki=$dziwki-$dziwkiD;
					} else {
						$dziwkiD=0;
					}
					 
					 $dziwkiT=$dziwki;

					$newsy = $newsy .pl_win2iso('<center><br><font>Ilosc zlapanych dziwek:<br><br>');
					if ($dziwkiP!=0){
						$newsy = $newsy .pl_win2iso('<img src=gfx/ikony/dziwki/1.jpg border=2><br>Slabe dziwki: <b>' .$dziwkiP .'</b><br>');
					}
					if ($dziwkiD!=0){
						$newsy = $newsy .pl_win2iso('<img src=gfx/ikony/dziwki/2.jpg border=2><br>Sredniawe dziwki: <b>' .$dziwkiD .'</b><br>');
					}
					if ($dziwkiT!=0) {
						$newsy = $newsy .'<img src=gfx/ikony/dziwki/3.jpg border=2><br>Dobre dziwki: <b>' .$dziwkiT .'</b><br>';
					}
					if (($dziwkiP==0) && ($dziwkiT==0) && ($dziwkiD==0)) {
						$newsy = $newsy .'Niestety, nie udalo sie nic zlapac. Sprobuj nastepnym razem';
					}
$newsy = $newsy .'</font>';
					OdejmijHajs($id, ModyfikatorCen(1000, $id));
					$burdel_id=MaBurdel($id);
			#####DODANIE DZIWEK 1go STOPNIA ######
					
					if ($dziwkiP!=0) {
					$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$burdel_id' AND dziwka='1'"; 
					$wynik = mysql_query($query); 
						if (mysql_num_rows($wynik) == 0) {
						$query = "INSERT INTO F_burdeleStan (burdel_id, dziwka, ilosc) VALUES ('$burdel_id', '1', '$dziwkiP')"; 
						mysql_query($query);
						} else {
							$rekord = mysql_fetch_array ($wynik);
				$dziwkiP=$rekord[ilosc]+$dziwkiP;
		 		$query = "UPDATE F_burdeleStan SET ilosc='$dziwkiP' WHERE burdel_id='$burdel_id' AND dziwka='1'"; 
							 mysql_query($query);
						}
					}
##### DOTAD ######

			#####DODANIE DZIWEK 2go STOPNIA ######
					
					if ($dziwkiD!=0) {
					$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$burdel_id' AND dziwka='2'"; 
					$wynik = mysql_query($query); 
						if (mysql_num_rows($wynik) == 0) {
						$query = "INSERT INTO F_burdeleStan (burdel_id, dziwka, ilosc) VALUES ('$burdel_id', '2', '$dziwkiD')"; 
						mysql_query($query);
						} else {
							$rekord = mysql_fetch_array ($wynik);
				$dziwkiD=$rekord[ilosc]+$dziwkiD;
		 		$query = "UPDATE F_burdeleStan SET ilosc='$dziwkiD' WHERE burdel_id='$burdel_id' AND dziwka='2'"; 
							 mysql_query($query);
						}
					}
##### DOTAD ######

			#####DODANIE DZIWEK 3go STOPNIA ######
					if ($dziwkiT!=0) {
					$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$burdel_id' AND dziwka='3'"; 
					$wynik = mysql_query($query); 
						if (mysql_num_rows($wynik) == 0) {
						$query = "INSERT INTO F_burdeleStan (burdel_id, dziwka, ilosc) VALUES ('$burdel_id', '3', '$dziwkiT')"; 
						mysql_query($query);
						} else {
							$rekord = mysql_fetch_array ($wynik);
				$dziwkiT=$rekord[ilosc]+$dziwkiT;
		 		$query = "UPDATE F_burdeleStan SET ilosc='$dziwkiT' WHERE burdel_id='$burdel_id' AND dziwka='3'"; 
							 mysql_query($query);
						}
					}
##### DOTAD ######

					


				}
	}


$dane=array(
	'lokacja'=> TloLokacji('burdel'), 
	'przyciski'=> '<td><a href=main.php?lokacja=burdel_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>