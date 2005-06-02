
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
$query2 = "SELECT id FROM F_glowneDane"; 

  $wynik2 = mysql_query($query2); 
while($rekord2 = mysql_fetch_array ($wynik2)) {
Odpoczywaj($rekord2['id']);
	}

Randomy();


?>
</body>
</html>