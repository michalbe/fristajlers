<?
include('conf/stats.php');

if (isset($_POST['wyzwij'])) {
$aktualna_data = date("Y-m-d");
$data = $rok .'-' .$miesiac .'-' .$dzien;
$data_czas = strtotime($data);
$data_czas = date("Y-m-d", $data_czas);
$query = "SELECT * FROM F_wyzwania WHERE (id_kto='$id' OR id_kogo='$id' OR id_kto='$id_kogo' OR id_kogo='$id_kogo') AND kiedy='$data' AND pora='$pora'"; 
 $pytanie = mysql_query($query); 

if ($pora=='0') { $poraText='8'; } elseif ($pora=='1') { $poraText='16';} else { $poraText='24';}

 if (($data_czas<date("Y-m-d")) || (($data_czas==date("Y-m-d")) && ($poraText<date("H"))) || (checkdate($miesiac, $dzien, $rok)==FALSE)) {
 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" width="90%" height="90%" ">
    <tr>
      <td width="193" height="192" valign=top><font size=-2 class=ziom><center><br><br><br><b>Wybrales date ktora juz byla, lub taka, ktora nie isnieje!</font>
	  	  </center></td>
    </tr>
  </table>
  </center>';
 } elseif (mysql_num_rows($pytanie) != 0) { 
 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" width="90%" height="90%" ">
    <tr>
      <td width="193" height="192" valign=top><font size=-2 class=ziom><center><br><br><br><b>Ty lub Twoj przeciwnik macie juz walke w tym okresie!</font>
	  	  </center></td>
    </tr>
  </table>
  </center>';



} else {
#$newsy = $newsy .date("Y-m-d", $data).' ' .$aktualna_data;
$text = strip_tags($text);
if ($pora=='0') { $poraText="08:00"; }elseif ($pora=='1') { $poraText="16:00";} else { $poraText="24:00";}
$data = $rok .'-' .$miesiac .'-' .$dzien;
$text = 'Zostales wyzwany na walke o ' .$poraText .' ' .$data .' przez ' .Ksywka($id) .'. Oto co mial Ci do powiedzenia: <br><br>' .$text;
$text = $text .'<br><br>Walke zaakceptowac mozesz w kalendarzu.';
$query = "INSERT INTO F_wyzwania (id_kto, id_kogo, kiedy, pora) VALUES ('$id', '$id_kogo', '$data', '$pora')"; 
        mysql_query($query); 
$text = pl_win2iso($text);
		PiszWiadomosc(0, $id_kogo, $text);

 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" width="90%" height="90%">
    <tr>
       <td width="193" height="192" valign=top><font size=-2 class=ziom><center><br><br><br><b>Gracz zostal wyzwany na Walke! Oczekuj jego odpowiedzi.</font>
	  	  </center></td>
    </tr>
    <tr>
<center> <font size=-2 class=ziom>' .Ksywka($id) .'<b> vs </b>' .Ksywka($id_kogo) .'</font>
	 </center>
 </td>
    </tr>
  </table>
  </center>';
}

} else {
$id_kogo = $_POST['id_kogo'];
 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" width="90%" height="90%" >
    <tr>
      <td width="193" height="192" valign=top><font size=-1 class=ziom><center><br><b>Wyzwanie na walke:</b></font><br>
	<font>' .NajblizszyTermin($id_kogo) .'<br>
	  <form method=post action=main.php?lokacja=l_wyzwanie>
	  <font size=-2 class=ziom>Wybierz date &nbsp;</font><select name=rok>';	  
		for ($rok=2007; $rok<=2017; $rok++) {
		$newsy = $newsy .'<option value=\'' .$rok .'\' '; 
		if ($rok==date("Y")) { $newsy = $newsy .'selected'; } 
		$newsy = $newsy .'>' .$rok .'</option>';
 }
	 $newsy = $newsy .'</select>
		<select name=miesiac>';

		for ($miesiac=1; $miesiac<=12; $miesiac++) {
		$newsy = $newsy .'<option value=\'' .$miesiac .'\' '; 
		if ($miesiac==date("m")) { $newsy = $newsy .'selected'; } 
		$newsy = $newsy .'>' .$miesiac .'</option>';
 }
 $newsy = $newsy .'</select>
		<select name=dzien>';
		for ($dzien=1; $dzien<=31; $dzien++) {
		$newsy = $newsy .'<option value=\'' .$dzien .'\' '; 
		if ($dzien==date("d")) { $newsy = $newsy .'selected'; } 
		$newsy = $newsy .'>' .$dzien .'</option>';
 }
	
 $newsy = $newsy .'</select><select name=pora>
		<option value=0>08:00</option><option value=1>16:00</option><option value=2 selected>24:00</option></select>

		<textarea rows="5" name="text" cols="30"></textarea>
		<input type=hidden value="' .$id .'" name=id_kto>
		<input type=hidden value="' .$id_kogo .'" name=id_kogo><br>
	  <input type="submit" value="wyzwij" name="wyzwij" style="font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;"></p>
	  </center></td>
    </tr>
    <tr>
      <td valign=top><font size=-2 class=ziom>
<center>' .Ksywka($id) .'<b> vs </b>' .Ksywka($id_kogo) .'</font>
	 </center>
 </td>
    </tr>
  </table>
  </center>';


}

$dane=array(
	'lokacja'=> TloLokacji('miasto'), 
	'przyciski'=> '<TD><a href="?lokacja=o_profil&nr=' .$id_kogo .'"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>