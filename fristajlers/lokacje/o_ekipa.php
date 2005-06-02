<?
include('conf/stats.php');

if(CzyZaproszony($id)!=0) {
$id_ekipy=CzyZaproszony($id);
$ekipa=Ekipa($id_ekipy);

	$newsy = $newsy .'<center><br><br><font> Zostales zaproszony do ekipy <b>' .$ekipa[1] .'</b>. Czy przyjmujesz zaproszenie?</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_ekipa_zaproszenie">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_ekipa_zaproszenie">
	<INPUT TYPE="submit" value="nie" name=nie>
	</FORM></td></tr></table></center>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
} else {

   if (CzyWEkipie($id)==0) {
	     ####ZIOMEK NIE JEST W ZADNEJ EKIPIE, MOZE TWORZYC WLASNA
if (isset($_POST['stworz'])) {

$newsy = $newsy .'<form method="post" action=main.php?lokacja=o_ekipa ENCTYPE="multipart/form-data"><INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000"> <table>
		<tr><td>nazwa ekipy: <br><font size=-2><i>maxymalnie 15 liter i cyfr</i></font></td><td><input type="text" name="nazwa"></td></tr>
		<tr><td>opis: <br><font size=-2><i>krotki opis ekipy, motto, czy co?</i></font></td><td><textarea rows="3" name="opis" cols="15"></textarea></td></tr>
<tr><td>logo: <br><font size=-2><i>logo, format .jpg</i></font></td><td><INPUT NAME="logo" TYPE="file"></td></tr>
</table>
		<input type="submit" name="wyslane" value="zaakceptuj"></form>';

$przyciski = $przyciski .'<td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';

} elseif (isset($_POST['wyslane'])) {

if (ereg("^[??êæ¿·³óñ.|¯?ÊÆÑ£Ó0-9a-zA-Z]{2,15}$", $nazwa))
			{

#################################################				
####### Nazwa zaakceptowana, jadziem dalej ######
#################################################

 if (SprawdzEkipe($nazwa))   {

##############
###DOBRZE#####
##############
	$data =  date("Y-m-d");
	$opis = strip_tags($opis);
	$nazwa = strip_tags($nazwa);
	$query = "INSERT INTO F_ekipy (nazwa, motto, id_szef, data_zalozenia) VALUES ('$nazwa',  '$opis', '$id', '$data')"; 
     mysql_query($query); 


$queryid = "SELECT id_ekipy FROM F_ekipy WHERE `id_szef`='$id'";
$respid = mysql_query($queryid);
$rekordid = mysql_fetch_array ($respid);

	$id_ekipy=$rekordid['id_ekipy'];

	if (($logo!='')) {
		$newName = $id_ekipy .'.jpg';
		copy($logo, "lokacje/loga_ekip/$newName");
	 } else {
		 $newName = "brak.jpg";
	 }

	$query = "UPDATE F_ekipy SET logo='$newName' WHERE id_szef='$id'"; 
     mysql_query($query); 


	$queryLose = "UPDATE F_glowneDane SET ekipa='$id_ekipy' WHERE id='$id'"; 
			mysql_query($queryLose); 

$newsy = $newsy .'<img src=lokacje/loga_ekip/thumb.php?w=155&f=' .$newName .' border=2><br>		
		<font size=-2><? $newsy = $newsy .$nazwa; ?> </font><br><br><font size=-1> Gratulacje! Zostales szefem nowej rap-ekipy. Pokazcie teraz, kto rzadzi w miescie.</font>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
OdejmijHajs($id, 300);

############
##DO TAD####
############
} else {
	$newsy = $newsy .'Taka ekipa juz istnieje.';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
}


			} else {
					$newsy = $newsy .'Nazwa ekipy powinna zawierac tylko litery i cyfry oraz nie powinna byc dluzsza niz 15 znakow!';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';		
					}


} else {
$newsy = $newsy .'<center><font size=-1><br><br> Tutaj mozesz zalozyc wlasna rap-ekipe. </font>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
		
		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

		if (($pkt_stylu<=750) || (Hajs($id)<300)) {
$newsy = $newsy .'<font size=-1><br> Musisz w tym celu miec ponad 750pkt stylu oraz zaplacic <b>300HJS.</b> </font></center>';
		} else {
			$newsy = $newsy .'<form action=main.php?lokacja=o_ekipa method=post><input type=submit name=stworz value="stworz"></form></center>';
			}
}


} else {
##### ZIOMEK JEST W EKIPIE SPRAWDZAMY CZY JEST BOSEM CZY NIE ####
$boss=FALSE;
if (CzyWEkipie($id)==1) { $boss=TRUE; }
$nr=NrEkipy($id);
$ekipa=Ekipa($nr);

$queryq = "SELECT id FROM F_glowneDane WHERE ekipa='$nr' ORDER by ksywka"; 
    $wynikq = mysql_query($queryq); 

	while ($rekordq = mysql_fetch_array ($wynikq)) {
			$id_czlonkow[] = $rekordq['id'];
	}

if ($boss) {
$przyciski = $przyciski .'<TD><a href=main.php?lokacja=o_ekipa_edytuj><img src=gfx/ekipa.jpg border=0 title="Edytuj dane ekipy"></a></TD></a>';
} else {
$przyciski = $przyciski .'<TD><a href=main.php?lokacja=o_ekipa_odejdz><img src=gfx/kosz.jpg border=0 title="Odejdz z ekipy"></a></TD></a>';
}

$newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="90%" height="90%" id="AutoNumber1">
    <tr>
      <td width=36% height=30% valign=top><center><font size=-1><b>' .$ekipa[1] .'</b><br></font><font size=-2><i>dziala od '.$ekipa[5] .'</i></font><br>
	  <img src=lokacje/loga_ekip/thumb.php?w=155&f=' .$ekipa[2] .' border=2></center></td>
      <td width="193" height="192" rowspan="2" valign=top><font size=-1><center><br><b>O ekipie:</b><br><br><i>' .$ekipa[3] .'</i></center><br><b>&nbsp;czlonkowie:</b></font><br>&nbsp;';
	for ($i=0; $i<count($id_czlonkow); $i++) {
		  		
		$query = "SELECT wygrane, przegrane FROM F_walki WHERE id='$id_czlonkow[$i]'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$rekord['przegrane'] = $rekord['przegrane']+$rekord['wygrane'];
		$walki_ekipy[0]=$walki_ekipy[0]+$rekord['wygrane'];
		$walki_ekipy[1]=$walki_ekipy[1]+$rekord['przegrane'];
		

		 $newsy = $newsy .'<font size=-2> .<a href=main.php?lokacja=o_profil&nr=' .$id_czlonkow[$i] .'>';
		if ($ekipa[4]==$id_czlonkow[$i]) { $newsy = $newsy ."<b>"; }
		$newsy = $newsy .Ksywka($id_czlonkow[$i]);
		if ($ekipa[4]==$id_czlonkow[$i]) { $newsy = $newsy ."</b>"; }
		$newsy = $newsy .' </a></font>';
	  }


	  
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_ekipa_pisz><img src=gfx/poczta.jpg border=0 title="Wiadomosc do wszystkich"></a></TD><td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
$newsy = $newsy .'</td>
    </tr>
    <tr>
      <td valign=top><font size=-1><br><b>walki:</b> ' .$walki_ekipy[0] .'/' .$walki_ekipy[1].'<br><b>styl:</b>' .$ekipa[6] .' pkt<br><b>obiekty sport.:</b> ' .$ekipa[7].'<br><b>sklepy:</b> ' .$ekipa[8] .'<br><b>dilerzy:</b> ' .$ekipa[9] .'<br><b>burdele:</b> ' .$ekipa['burdele'] .'</font>
 </td>
    </tr>
  </table>';

}
}





$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>