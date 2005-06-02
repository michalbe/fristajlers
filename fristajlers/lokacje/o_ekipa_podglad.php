<?
include('conf/stats.php');



$ekipa=Ekipa($nr_ekipy);

$queryq = "SELECT id FROM F_glowneDane WHERE ekipa='$nr_ekipy' ORDER by ksywka"; 
    $wynikq = mysql_query($queryq); 

	while ($rekordq = mysql_fetch_array ($wynikq)) {
			$id_czlonkow[] = $rekordq['id'];
	}


$newsy = $newsy .'<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="90%" height="90%" id="AutoNumber1">
    <tr>
      <td width=36% height=30% valign=top><center><font size=-1><b>' .$ekipa[1] .'</b><br></font><font size=-2><i>dzialamy od ' .$ekipa[5].'</i></font><br>
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


	  $newsy = $newsy .'</td>
    </tr>
    <tr>
      <td valign=top><font size=-1><br><b>walki:</b>' .$walki_ekipy[0] .'/' .$walki_ekipy[1] .'<br><b>styl:</b>' .$ekipa[6] .' pkt<br><b>obiekty sport.:</b>' .$ekipa[7] .'<br><b>sklepy:</b>' .$ekipa[8] .'<br><b>dilerzy:</b>' .$ekipa[9] .'<br><b>burdele:</b> ' .$ekipa['burdele'] .'</font>
 </td>
    </tr>
  </table>';


$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Osiedle"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>