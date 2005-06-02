<?
include('conf/stats.php');


if (isset($wyslane)) {
	
	if (($logo!='')) {
		 $newName = $_POST['id_ekipy'] .'.jpg';
		 copy($logo, "lokacje/loga_ekip/$newName");
	   $query = "UPDATE F_ekipy SET logo='$newName', motto='$opis' WHERE id_szef = '$id' "; 
	 } else {
		$query = "UPDATE F_ekipy SET motto='$opis' WHERE id_szef = '$id' "; 
	 }
		 
        mysql_query($query); 
	$newsy = $newsy .'<br><br><center><font size=-1> Dane zostaly zmienione.</font></center>';

} else {

$nr=NrEkipy($id);
$ekipa=Ekipa($nr);
$newsy = $newsy .'<form method="post" action=main.php?lokacja=o_ekipa_edytuj ENCTYPE="multipart/form-data"><INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000"> <table>
		<tr><td>nazwa ekipy: <br><font size=-2><i>maxymalnie 15 liter i cyfr</i></font></td><td><font><b>[ <i>' .$ekipa[1] .'</i> ]</b></font></td></tr>
		<tr><td>opis: <br><font size=-2><i>krotki opis ekipy, motto, czy cos</i></font></td><td><textarea rows="3" name="opis" cols="15">' .$ekipa[3] .'</textarea></td></tr>
		<tr><td>logo: <br><font size=-2><i>maxymalnie 100KB, zostanie<br> wykadrowane do 160x160, <b>format jpg!</b></i></font></td><td><INPUT NAME="logo" TYPE="file"></td></tr></table><br><table border=0><tr><td><INPUT TYPE="hidden" name=id_ekipy value=' .$ekipa[0] .'><input type="submit" name="wyslane" value="zaakceptuj"></form></td><td>	
		</td></tr></table>';
}

$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>