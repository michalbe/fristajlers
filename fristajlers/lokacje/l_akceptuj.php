<?
include('conf/stats.php');

$id_kto=$_POST['id_kto'];
$id_kogo=$_POST['id_kogo'];
$data=$_POST['data'];
$pora=$_POST['pora'];
	$query = "SELECT * FROM F_wyzwania WHERE (id_kto='$id' OR id_kogo='$id') AND kiedy='$data' AND pora='$pora' AND akcept='1'"; 
 $pytanie = mysql_query($query); 
 if (mysql_num_rows($pytanie) != 0) {
	 
 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="90%" height="90%" id="AutoNumber1">
    <tr>
       <td width="193" height="192" valign=top><font size=-2><center><br><br><br><b>Nie mozesz zaakceptowac tej walki, masz juz walke w tym czasie!</font>
	  	  </center></td>
    </tr>
    <tr>
      <td valign=top><font size=-2><br><br>Wyzwanie na walke:<br><b></b>
<center>' .Ksywka($id_kto) .'<b> vs </b>' .Ksywka($id_kogo) .'</font>
	 </center>
 </td>
    </tr>
  </table>
  </center>';
} else {
	 $newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="90%" height="90%" id="AutoNumber1">
    <tr>
      <td width="193" height="192" valign=top><font size=-2><center><br><br><br><b>Zaakceptowano wyzwanie. O wyniku dowiesz sie po walce ze swojego domowego telewizora.</b></font>
	  	  </center></td>
    </tr>
    <tr>
      <td valign=top><font size=-2><br><br>Wyzwanie na walke:<br><b></b>
<center>' .Ksywka($id_kto) .'<b> vs </b>' .Ksywka($id_kogo) .'</font>
	 </center>
 </td>
    </tr>
  </table>
  </center>';

				PolaczMysql();
			$query = "UPDATE F_wyzwania SET akcept='1' WHERE id_kto='$id_kto' AND id_kogo='$id_kogo' AND kiedy='$data' AND pora='$pora'"; 
			 mysql_query($query); 
			 mysql_close;
$text = Ksywka($id_kogo) .' przyjal Twoje wyzwanie na walke.<br> Po walce bedziesz mogl obejrzec ja w swoim domowym telewizorze';
			 PiszWiadomosc(0, $id_kto, $text);
	 }


$dane=array(
	'lokacja'=> TloLokacji('kalendarz'), 
	'przyciski'=> '<TD><a href="?lokacja=kalendarz"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>