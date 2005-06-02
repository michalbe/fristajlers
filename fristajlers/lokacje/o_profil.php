<?
include('conf/stats.php');

$ekipa=NrEkipy($nr);
$ekipa=Ekipa($ekipa);

	$newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" width="95%" height="90%">   <tr>
      <td width=36% height=30% valign=top><center><font size=-1 class=ziom><b>' .Ksywka($nr) .'</b><br><i>' .Respect($nr) .'</i></font><br>
	  <img src=wyglad/' .Logo($nr) .'.jpg width=100 border=2><br><a href=main.php?lokacja=o_ekipa_podglad&nr_ekipy=' .$ekipa[0] .'><font class=ziom><i>' .$ekipa[1] .'</i></a>';
	  if (($ekipa[4]==$id) && ($nr!=$id)) {
			$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa_wywal&id_wywal=' .$nr .'><img src=gfx/kosz.jpg border=0 title="Wyrzuc z ekipy"></a></td>';
	  }
	  $newsy = $newsy .'</font></center></td><td width="193" height="192" rowspan="2" valign=top><font size=-1 class=ziom><center><br>';
 if ($nr!=$id) { 
$przyciski = $przyciski .'<td><a href=main.php?lokacja=pisz&iddo=' .$nr .'><img src=gfx/poczta.jpg border=0 title="Napisz wiadomosc"></a></td>';

 } if ((CzyWEkipie($id)==1) && (CzyWEkipie($nr)==0) && (CzyZAproszony($nr)==0)) { 
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa_dodaj&id_kogo=' .$nr .'><img src=gfx/ekipa.jpg border=0 title="Zapros do ekipy"></a></td>';
 } 

$newsy = $newsy .'<br><b>O Sobie:</b><br><br><i>' .OSobie($nr) .'</i></font></center> </td>
    </tr>
    <tr>
      <td valign=top><br><br><font size=-1 class=ziom><b>walki: </b>' .StosunekWalk($nr);

 PolaczMysql();
		$query = "SELECT * FROM F_archiwum WHERE id_kto='$nr' OR id_zkim = '$nr' ORDER BY nr_walki DESC LIMIT 0,3"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2 class=ziom><br>Nie stoczyl jeszcze zadnej walki.</font><br>';
		} else {
			$newsy = $newsy .'<font size=-2 class=ziom><b><br>Ostatnie:</b><br></font>';
			while ($rekord = mysql_fetch_array ($wynik)) {
				$newsy = $newsy .'<a href=main.php?lokacja=walka_o&skad=o_szukaj&nr=' .$rekord[0] .'><font size=-2 class=ziom> - ' .Ksywka($rekord[1]) .' <b>vs</b> ' .Ksywka($rekord[2]) .'</font></a><br>';
			}

		}
					$query2 = "SELECT ost_log FROM F_glowneDane WHERE id='$nr'"; 
			        $wynik2 = mysql_query($query2); 
					$tabl=mysql_fetch_array($wynik2);
					$newsy = $newsy .'<font size=-2 class=ziom><b>Ostatnio zalogowany:</b> ' .$tabl['ost_log'] .'<br>';
 
 ?>
 
 	    <? if ($nr != $id) {
$przyciski = $przyciski .'<td><form action=main.php?lokacja=l_wyzwanie method=post><input type=hidden name=id_kogo value=' .$nr .'><input type="image" src="gfx/walka.jpg" name="submit" title="Wyzwij na walke"></form></td>';
   } 
 $newsy = $newsy .'</td></tr></table>';

$przyciski = $przyciski .'<TD><a href="?lokacja=o_szukaj"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';

$dane=array(
	'lokacja'=> TloLokacji('miasto'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>