<?
include('conf/stats.php');

	if (!isset($liga)) {
		$liga=Liga($id);
	}

	if ($liga==0) {
		#nie jest w  lidze
	 	$newsy = $newsy. '<font>Nie bierzesz udzialu w rozgrywkach ligowych. Obejrzyj 		<a href=?lokacja=cr&liga=1> TABELE LIGOWE </a></font>';
	} else {
		###TABELA LIGOWA LIGI ZAWODNIKA I LINKI DO INNYCH LIG###
		$query = "SELECT * FROM F_liga WHERE liga='$liga' ORDER BY pkt_duze DESC, pkt_male DESC";
		$resp = mysql_query($query);
		$newsy = $newsy .'<center><b>' .$liga .' LIGA </b></center><table width=98% height=88% border=0 cellpadding=0 cellspacing=0><tr><td bgcolor=grey width=25 height=20>LP</td><td bgcolor=grey>Ksywka</td><td bgcolor=grey><center>Ekipa</center></td><td bgcolor=grey><center>Punkty</center></td><td bgcolor=grey><center>Dodatkowe</center></td></tr><tr>';
		$lp=1;
		while ($rekord = mysql_fetch_array ($resp)) {
			$ekipa=NrEkipy($rekord['id']);
			$ekipa=Ekipa($ekipa);
	$newsy = $newsy .'<td><b>' .$lp .'</b></td><td><b><a href=?lokacja=o_profil&nr=' .$rekord['id'] .'>' .Ksywka($rekord['id']) .'</a></b></td><td><b><center><a href=?lokacja=o_ekipa_podglad&nr_ekipy=' .$ekipa['id_ekipy'] .'>' .$ekipa['nazwa'] .'</a></center></b></td><td><b><center>' .$rekord['pkt_duze'] .'</center></b></td><td><b><center>' .$rekord['pkt_male'] .'</center></b></td></tr>';
			$lp++;
		}
		$newsy = $newsy .'</tr></table><br><center><a href=?lokacja=cr&liga=1> I liga </a> || <a href=?lokacja=cr&liga=2> II liga </a> || <a href=?lokacja=cr&liga=3> III liga </a> || <a href=?lokacja=cr&liga=4> IV liga </a></center>';

	}


$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href=?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
	
?>