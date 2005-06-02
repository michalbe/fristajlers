<?
	srand(time());
include ('conf/funkcje.php');
PolaczMysql();

##########################################################
##########PRZETASOWYWANIE KOLEJNOSCI LOKACJI##############
##########################################################
Randomy();


#####################################################################
#####PRZEPROWADZENIE WALK UMÓWIONYCH NA DZISIEJSZY DZIEÑ#############
#####################################################################

	$data =  date("Y-m-d");
$query = "SELECT * FROM F_wyzwania WHERE akcept='1' AND kiedy='$data' AND pora='2'"; 
	    $wynik = mysql_query($query); 
		while ($rekord = mysql_fetch_array ($wynik)) {
			Walcz($rekord[1], $rekord[2], $rekord['punche1'], $rekord['dynamika1'], $rekord['punche2'], $rekord['dynamika2'], $rekord['liga']);
		$queryDel = "DELETE FROM F_wyzwania WHERE nr='$rekord[0]'"; 
	    mysql_query($queryDel); 
		}

############################################
###WYROWNYWANIE ENERGII#####################
############################################

$query2 = "SELECT id FROM F_glowneDane"; 
	    $wynik2 = mysql_query($query2); 
	while($rekord2 = mysql_fetch_array ($wynik2)) {
	Forma($rekord2['id']);
	PrzywrocIntNap($rekord2['id']); 
	DodajHajs($rekord2['id'], 80);
	}
########################################
####STATYSTYKI EKIPY           #########
########################################

$query = "SELECT ekipa FROM F_glowneDane WHERE ekipa <> 0"; 
$wynik = mysql_query($query); 
while ($rekord = mysql_fetch_array ($wynik)) {
	StylEkipy($rekord['ekipa']);
	DzialalnoscEkipy($rekord['ekipa']);
}
CenyMistrza();
CzyscZnalazl();
################################
####WYROWNANIE INT. I NAPIECIA##
################################


?>
