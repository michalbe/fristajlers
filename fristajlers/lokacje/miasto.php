<?
include('conf/stats.php');
OdejmijEnergie($id);

		$query2 = "SELECT * FROM Newsy ORDER BY lp DESC LIMIT 0, 2 "; 
        $wynik = mysql_query($query2); 
		
		$newsy = $newsy ."<center><font size=-1>| historia | autorzy | <a href=# OnClick=\"javascript:window.open('faq.php', 'noweOkno', 'toolbar=no, location=no, scrollbars=yes, width=280, height=420')\"><b>FAQ</b></a> | zmien.dane | <a href=main.php?lokacja=pisz&iddo=1><b>zglos.problem</b></a> |</font><br><br></center>";

		while ($rekord = mysql_fetch_array ($wynik)) {
		$newsy = $newsy .'<b>' .date("m.d.y H:i:s", $rekord['data']) .' || ' .$rekord['title'] .'</b><br>' .$rekord['text'] .'<br><br>';
		}



$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href=?lokacja=dom><img src=gfx/dom.jpg border=0 title="Dom" /></a></TD>
				   <TD><a href=?lokacja=osiedle><img src=gfx/osiedle.jpg border=0 title="Osiedle"></a></TD>
				   <TD><a href=?lokacja=bank><img src=gfx/bank.jpg border=0 title="Bank"></a></TD>
				   <TD><a href=?lokacja=las><img src=gfx/las.jpg border=0 title="Las"></a></TD>
				   <TD><a href=?lokacja=ks><img src=gfx/sporty.jpg border=0 title="Kompleksy Sportowe"></a></TD>
				   <TD><a href=?lokacja=dh><img src=gfx/sklepy.jpg border=0 title="Centra Handlowe"></a></TD>
				   <TD><a href=?lokacja=burdel><img src=gfx/burdel.jpg border=0 title="Burdele"></a></TD>',
					#<TD><a href=?lokacja=cr><img src=gfx/cr.jpg border=0 title="Centrum Rapu"></a></TD>',
				   #<TD><a href=?lokacja=fabryki><img src=gfx/fabryki.jpg border=0 title="Fabryki"></a></TD>
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
	
?>