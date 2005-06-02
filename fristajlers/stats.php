<?
	###STATSY####
	
	$ekipa=NrEkipy($id);
	$ekipa=Ekipa($ekipa);

		if ($ekipa[1]!='') { $ekipa[1] = '[ <i><b>' .$ekipa[1] .'</i></b> ]'; } ##CZY W EKIPIE ###

	$forma = UstalForme($id);
if($id!=1) {
	$statsy =  '<center>' .Ksywka($id) .'</b><br><i>' .Respect($id) .'</i><br><img src=wyglad/' .Logo($id) .'.jpg width=80 border=4>';
	$statsy .= '<br><a href=main.php?lokacja=o_ekipa><font class=ekipa>' .$ekipa[1] .'</font></a></center>';
	$statsy .= '<font class=stats>' .WyswietlStatsy2($id) .'hajs: ' .Hajs($id) .'HJS<br>walki: ' .StosunekWalk($id);
	$statsy .= '<br>' .Punche($id) .'forma: ' .WyswietlForme($forma) .'<br>' .NoweWiad($id) .'</font>';

	} else {

	$statsy =  '<center>' .Ksywka($id) .'</b><br><i>' .Respect($id) .'</i><br><img src=gfx/ikony/bron/10.jpg style="float:left margin:0px" width=35 border=2><img src=wyglad/' .Logo($id) .'.jpg width=80 border=4>';
	$statsy .= '<br><a href=main.php?lokacja=o_ekipa><font class=ekipa>' .$ekipa[1] .'</font></a></center>';
	$statsy .= '<font class=stats>' .WyswietlStatsy2($id) .'hajs: ' .Hajs($id) .'HJS<br>walki: ' .StosunekWalk($id);
	$statsy .= '<br>' .Punche($id) .'forma: ' .WyswietlForme($forma) .'<br>' .NoweWiad($id) .'</font>';
}
	###KONIEC STATSOW####
	
?>