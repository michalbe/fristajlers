<?
/**********************************************

	Polish Chars - zmiana kodowania liter z WIN-CP-1250 na ISO-8859-2
	Wersja 0.1.0 z dnia 2002.10.04

	Autor: Marek REGGI Reinowski
	www.reggi.pl, reggi@reggi.pl
	
	Status: freeware
	
	Plik wolno uzywac i modyfikowac dowolnie. 
	W przypadku znaczacych modyfikacji, badz usprawnien prosze o informacje 
	w celu dodania ich do ponizszego pliku i udostepnienia szerszemu gronu uzytkownikow.
	
	
************************************************
	
	SPOSOB UZYCIA:
	Plik nalezy wlaczyc do projektu za pomoca f-cji include().
	Po dolaczeniu pliku dostepne sa nastepujace funkcje:
	
	string pl_strtolower(string text) 
		- zamiana wszystkich liter w ciagu na male litery, wlaczajac polski 'ogonki'
			z jednoczesnym przekodowaniem znakow z win-cp-1250 na iso-8859-2
	
	string pl_strtoopper(string text) 
		- zamiana wszystkich liter w ciagu na WIELKIE LITERY, wlaczajac polski 'ogonki'
			z jednoczesnym przekodowaniem znakow z win-cp-1250 na iso-8859-2
	
	string pl_ucfirst(string text) 
		- zamiana pierwszej litery w ciagu na WIELKA, wlaczajac polski 'ogonki'
			z jednoczesnym przekodowaniem znakow z win-cp-1250 na iso-8859-2
	
	string pl_win2iso(string text) 
		- przekodowanie znakow z win-cp-1250 na iso-8859-2
		
	W wywolaniu kazdej z funkcji przekazujemy jej jako argument ciga, ktory ma zostac poddany
	obrobce. Funkcja zwraca:
		- zmieniony ciag - w przypadku pomyslnego wkonania funkcji
		- wartosc 'false' w przypadku wystepienia bledu.
	
************************************************/



$win2iso = array ("185"=>"177", "165"=>"161", "159"=>"188", "143"=>"172", "156"=>"182", "140"=>"166");
$win2iso_toupper = 	array ("185"=>"161", "165"=>"161", "177"=>"161", "191"=>"175", "143"=>"172", "159"=>"172", "188"=>"172", "230"=>"198", "241"=>"209", "140"=>"166", "156"=>"166", "182"=>"166", "234"=>"202", "243"=>"211", "179"=>"163");
$win2iso_tolower = 	array ("185"=>"177", "165"=>"177", "161"=>"177", "175"=>"191", "143"=>"188", "159"=>"188", "172"=>"188", "198"=>"230", "209"=>"241", "140"=>"182", "156"=>"182", "166"=>"182", "202"=>"234", "211"=>"243", "163"=>"179");

// Zmiana wielkich liter na male z uwzgednieniem polskich  znakow (ogonkow), 
// z przekodowaniem z win-cp-1250 na iso-8859-2
function pl_strtolower ($str)
{
	if (!is_string($str)) return false;
	global $win2iso_tolower;
	$str = strtolower($str);
	for (reset($win2iso_tolower);$key=key($win2iso_tolower);next($win2iso_tolower))
	{
		$str = ereg_replace(chr($key), chr($win2iso_tolower[$key]), $str);
	}
	return ($str);
}

// Zmiana wszystkich liter na wielkie z uwzgednieniem polskich znakow (ogonkow), 
// z przekodowaniem z win-cp-1250 na iso-8859-2
function pl_strtoupper ($str)
{
	if (!is_string($str)) return false;
	global $win2iso_toupper;
	$str = strtoupper($str);
	for (reset($win2iso_toupper);$key=key($win2iso_toupper);next($win2iso_toupper))
	{
		$str = ereg_replace(chr($key), chr($win2iso_toupper[$key]), $str);
	}
	return ($str);
}

// Zmiana pierwszej litery w ciagu na wielka z uwzglednieniem polskich  znakow (ogonkow)
// z przekodowaniem z win-cp-1250 na iso-8859-2
function pl_ucfirst ($str)
{
	if (!is_string($str)) return false;
	global $win2iso_toupper;
	$str = ucfirst($str);
	for (reset($win2iso_toupper);$key=key($win2iso_toupper);next($win2iso_toupper))
	{
		$str[0] = ereg_replace(chr($key), chr($win2iso_toupper[$key]), $str[0]);
	}
	return ($str);
}

// Przekodowanie polskich znakow z win-cp-1250 na iso-8859-2
function pl_win2iso ($str)
{
	if (!is_string($str)) return false;
	global $win2iso;
	for (reset($win2iso);$key=key($win2iso);next($win2iso))
	{
		$str = ereg_replace(chr($key), chr($win2iso[$key]), $str);
	}
	return ($str);
}

?>