<?
include('conf/stats.php');

if (!isset($_GET['nr'])) {
}
if ((isset($_POST['imie'])) && ($_POST['imie'] != '') && (strlen($_POST['imie'])>1)) {
PolaczMysql();
	
		$imie = addslashes($_POST['imie']);
		$query = "SELECT * FROM F_glowneDane WHERE ksywka LIKE '%$imie%' AND  data_urodzenia <> '0000-00-00' LIMIT 0, 15"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-1>Nie ma w miescie nikogo takiego. Napewno ktos by o nim slyszal.</font>';
$przyciski = '<TD><a href="?lokacja=o_szukaj"><img src=gfx/back.jpg border=0 title="Szukaj ponownie"></a></TD>';
		} else {
			$newsy = $newsy .'<font size=-1>Czy chodzi Ci o ktoregos z nich?</font><br><br>';
		while ($rekord = mysql_fetch_array ($wynik)) {
			$newsy = $newsy .'<font size=-2><a href="main.php?lokacja=o_profil&nr=' .$rekord[0] .'"> + ' .$rekord[2] .'</a></font><br>';
			}
$przyciski = '<TD><a href="?lokacja=o_szukaj"><img src=gfx/back.jpg border=0 title="Szukaj ponownie"></a></TD>';
		}


	} else {
		
$newsy = $newsy .'<font size=-1>Na osiedlu mozna dowiedziec sie wszystkeigo o kazdym. Nie boj sie pytac. </font><br><br>		<form onSubmit="return styka(this)" action="main.php?lokacja=o_szukaj" method=post>
		<font size=-2>Podaj Ksywke fristajlowca [min. 2 znaki]<br></font>
		<INPUT TYPE="text" NAME="imie" size=15>
		<input type=submit value="szukaj">
		</form>	<br><br><br><center><table width=90%><tr><td width=50%>';
		$query = "SELECT * FROM F_glowneDane WHERE data_urodzenia <> '0000-00-00' ORDER BY id DESC LIMIT 0,9"; 
        $wynik = mysql_query($query); 
		$newsy = $newsy .'<font size=-1>Nowi na osiedlu</font><br>';
		while ($rekord = mysql_fetch_array ($wynik)) {
			$newsy = $newsy .'<font size=-2><a href="main.php?lokacja=o_profil&nr=' .$rekord[0] .'"> + ' .$rekord[2] .'</a></font><br>';
			}
	$newsy = $newsy .'</td><td valign=top>';
		$query = "SELECT id FROM Online"; 
        $wynik = mysql_query($query); 
		$newsy = $newsy .'<font size=-1>Zalogowani:</font><FORM METHOD=GET ACTION="main.php"><input type="hidden" name="lokacja" value="o_profil"><select name=nr onchange="this.form.submit()"><option value="1">----</option>';
		while ($rekord = mysql_fetch_array ($wynik)) {
			$newsy = $newsy .'<option value=' .$rekord['id'] .'>+ ' .Ksywka($rekord['id']) .'</option>';

			}
 $newsy = $newsy .'</select></form>';
$przyciski = '<TD><a href="?lokacja=osiedle"><img src=gfx/back.jpg border=0 title="Szukaj ponownie"></a></TD>';			
 $newsy = $newsy .'</td></tr></table></center>';
}



$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>