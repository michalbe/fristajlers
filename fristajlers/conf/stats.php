<?
	###STATSY####
	
	$ekipa=NrEkipy($id);
	$ekipa=Ekipa($ekipa);

		if ($ekipa[1]!='') { $ekipa[1] = '[ <i><b>' .$ekipa[1] .'</i></b> ]'; } ##CZY W EKIPIE ###

	$forma = UstalForme($id);

		$query = "SELECT typTowaru FROM F_ekwipunek WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
while ($rekord = mysql_fetch_array ($wynik)) {
	$ekwip[] = '<a href=?lokacja=item-szcz-ek&item=' .$rekord['typTowaru'] .'><img src=gfx/ikony/itemy/' .$rekord['typTowaru'] .'.jpg width=42 border=2 style="border-color:black"></a>';
}
	$statsy =  '<center>' .Ksywka($id) .'</b><br><i>' .Respect($id) .'</i>
<table border=0 cellspacing=0 cellpadding=0><tr><td valign=top width=40>' .$ekwip[0] .$ekwip[1] .'</td><td valign=top><img src=wyglad/' .Logo($id) .'.jpg width=80 border=3></td><td valign=top width=40>' .$ekwip[2] .$ekwip[3] .'</td></tr></table>';
	$statsy .= '<a href=main.php?lokacja=o_ekipa><font class=ekipa>' .$ekipa[1] .'</font></a></center>';
	$statsy .= '<font class=stats>' .WyswietlStatsy2($id) .'hajs: ' .Hajs($id) .'HJS<br>walki: ' .StosunekWalk($id);
	$statsy .= '<br>' .Punche($id) .'forma: ' .WyswietlForme($forma) .'<br>' .NoweWiad($id) .'</font>';

	###KONIEC STATSOW####
	
?>