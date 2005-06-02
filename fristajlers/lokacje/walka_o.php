<?
include('conf/stats.php');

 if (isset($nr)) {

	$walka = PokazWalke($nr);
$newsy = '<div class="transp"><TABLE width=100% border=0 height=90%>
	<TR>
		<TD width=50% valign=top><font size=-1><CENTER><img src="wyglad/' .Logo($walka[1]) .'.jpg" width=55 border=2><br><b>' .Ksywka($walka[1]) .'</b></CENTER></font>
		</td><td valign=top>
		<font size=-1><CENTER><img src="wyglad/' .Logo($walka[2]) .'.jpg" width=55 border=2><br><b>' .Ksywka($walka[2]) .'</b></CENTER></font>
		</TD></tr><tr>
		<TD width=50% valign=top>
		<font class="rapy">' .pl_win2iso($walka[3]) .'</font>
		</td><td valign=top>
		<font class="rapy">' .pl_win2iso($walka[4]) .'</font></TD>
	</TR>
	</TABLE></div>';
	
$przyciski = '<TD><a href="?lokacja=walka_o&skad=tv&wynik=' .$nr .'"><img src=gfx/win.jpg border=0 alt="Powrót"></a></TD>';
$tlo = 'tv';
$win=0;

} elseif (isset($wynik)) {
	
		$query2 = "SELECT * FROM F_archiwum WHERE nr_walki='$wynik'"; 
    $wynik = mysql_query($query2); 
	$walka = mysql_fetch_array ($wynik);
#$wynik = explode("==+=", $walka[6]);


#$tlo = 'img.php?Ksywka1=' .WyrownajKsywke($wynik[0]) .'&Ksywka2=' .WyrownajKsywke($wynik[1]) .'&Ksywka3=' .WyrownajKsywke($wynik[2]);
$tlo = 'img.php?Ksywka1=' .$walka['werdykt'] .'&Ksywka2=' .$walka['werdykt'] .'&Ksywka3=' .$walka['werdykt'];
$skad=tv;
$win=1;
}

$dane=array(
	'lokacja'=> TloLokacji($tlo, $win), 
	'przyciski'=> $przyciski .'<TD><a href="?lokacja=' .$skad .'"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $newsy,
	'statsy' => $statsy );

	
?>