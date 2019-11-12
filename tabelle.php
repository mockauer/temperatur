<?php
 error_reporting(E_ALL);
  ini_set('display_errors', 'On');

	 function date_german($date) {
    $d    =    explode("-",$date);
    
    return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}
	 function date_german_time($date) {
    $d    =    explode("-",$date);
    return    sprintf("%02d.%02d.%04d %4s", $d[2], $d[1], $d[0], substr($d[2],3,8));
	}

$monat=array("Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
?>
<html>
<head>
<title>Wohnzimmer Temperatur Tabelle</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="deutsch, de" />
<meta name="description" content="Monitoring Wohnzimmer Temperatur in Tabellenform"/>
<meta name="author" content="mockauer"/>
<meta name="copyright" content="(c)mockauer-2019-<?php echo date('Y'); ?>" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<body>
<div id="maincontent">
  
      <div id="leftcontent">
		   <h2>Wohnzimmer</h2>
		           <?php
		           $zahl_monat = date("m")-1;
          $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
		?>
		 <div id="uberschrift"><strong>Temperaturen und Luftfeuchtigkeit von <?php echo $monat["$zahl_monat"]; ?></strong></div>

       

        <div id="link_uber_tabelle">
			<a class="site_link" href="index.php" target="_self">&Uuml;bersichtsseite</a>
		</div>
    
        <div id="temperatur_tabelle">
					<?php
		  $results = $db->query('select *,strftime(\'%M\', datum) as mintime, strftime(\'%m\', datum) as monat FROM wohnzimmer WHERE ((mintime = "00" OR mintime= "30") AND monat = "'.date("m").'") ORDER BY datum DESC');
		  //$results = $db->query('select *,strftime(\'%M\', datum) as mintime, strftime(\'%m\', datum) as monat FROM wohnzimmer WHERE ((mintime = "00" OR mintime= "30") AND monat = "06") ORDER BY datum DESC');
  $i=0;
while ($row = $results->fetchArray()) {
	$color = ($i % 2) ? "#FFF" : "#ffdd99";
	echo "<span style='background-color:$color; margin: 5px;'>";
	echo date_german_time($row["datum"])." - " . $row["temperatur"]."°C - " . $row["luftfeuchtigkeit"]."%<br/>";
	echo "</span>";
    $i++;
}
    ?>
			<br/>
			<div id="link_unter_tabelle"><a class="site_link" href="index.php" target="_self">&Uuml;bersichtsseite</a></div>
        </div>
        
           </div>
                   
</div>




</body>
</html>
