<?
include('conf/stats.php');

if (!isset($_POST['tak'])) {

	$newsy = $newsy .'<center><br><font> W lesie mozesz znalezc grzyby. Zjedzenie jednego grzyba podnosi o <b>1pkt</b> poziom Twojego stylu.</font><br><FORM METHOD=POST ACTION="main.php?lokacja=las"><INPUT TYPE="submit" value="wejdz do lasu" name=tak>
	</FORM>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
} else {
	$stats = PrzekazStatsyBazowe($id);
				if ($stats[0]<150) {
			$newsy = $newsy .'<center><br><font>Jestes za bardzo zmeczony zeby wejsc do lasu. Wroc tu, kiedy wypoczniesz.</font><br><br>';
include('_item.php');
$przyciski = $przyciski .'<td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
				} else {
					$supergrzyb = rand(0, 1000);
					if ($supergrzyb==1) { $grzyby=100; 
					$co = Ksywka($id) .' rozbil setke grzybiwa';
					$co = pl_win2iso($co);
					PiszWiadomosc(0, 1, $co);
					} else { $grzyby=rand(1, 8); } 
					$stats[5]=$stats[5]+$grzyby;
					$newsy = $newsy .'<center><br><font>Ilosc zjedzonych grzybow: <b>' .$grzyby .'</b><br><br>Twoje aktualne punkty stylu: <b> ' .$stats[5] .'</b></font>';
$przyciski = $przyciski .'<td><a href=main.php?lokacja=las><img src=gfx/back.jpg border=0 title="Powrot"></a></td>';
					$energia = $stats[0]-150;
					$query = "UPDATE F_stats SET energia_aktualna='$energia', styl='$stats[5]'  WHERE id='$id'"; 
				mysql_query($query); 
				}
	}


$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>' .$przed,
	'statsy' => $statsy );
?>