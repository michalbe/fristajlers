	
<html>
<head>
<LINK REL=STYLESHEET HREF="style.css" TYPE="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<title>the fristajlers</title>
</head>
<body>
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
$query = "SELECT * FROM F_wyzwania WHERE akcept='1' AND kiedy='$data' AND pora='0'"; 
	    $wynik = mysql_query($query); 
		while ($rekord = mysql_fetch_array ($wynik)) {
			Walcz($rekord[1], $rekord[2], $rekord['punche1'], $rekord['dynamika1'], $rekord['punche2'], $rekord['dynamika2'], $rekord['liga']);
		$queryDel = "DELETE FROM F_wyzwania WHERE nr='$rekord[0]'"; 
	    mysql_query($queryDel); 
		}

############################################
###WYROWNYWANIE ENERGII#####################
############################################

########################################
####ODEJMOWANIE ENERGII RAPEROM#########
########################################
$query = "SELECT ekipa FROM F_glowneDane WHERE ekipa <> 0"; 
$wynik = mysql_query($query); 
while ($rekord = mysql_fetch_array ($wynik)) {
	StylEkipy($rekord['ekipa']);
	DzialalnoscEkipy($rekord['ekipa']);
}
################################
####WYROWNANIE INT. I NAPIECIA##
################################
CenyMistrza();
 CzyscZnalazl();
?>
</body>
</html>