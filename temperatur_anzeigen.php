<?php
 error_reporting(E_ALL);
  // Fehler in der Webseite anzeigen (nicht in Produktion verwenden)
  ini_set('display_errors', 'On');
 
 $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
?>
<?php
	 function date_german($date) {
    $d    =    explode("-",$date);
    
    return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}
?>
<html>
<head>
<title>Wohnzimmer Temperatur</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="deutsch, de" />
<meta name="description" content="Monitoring Wohnzimmer Temperatur"/>
<meta name="author" content="mockauer"/>
<meta name="copyright" content="(c)mockauer-2019-<?php echo date('Y'); ?>" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>


</head>
<body>
<div id="maincontent">
  
      <div id="leftcontent">
		   <h2>Wohnzimmer</h2>
		    <div id="uberschrift"><strong>Temperatur und Luftfeuchtigkeit in Tabellenform</strong></div>
		           <?php
		           
		                               $anzahl = 0;
$results = $db->query('SELECT count(*) as count FROM wohnzimmer');

	while ($row = $results->fetchArray()) {
		$anzahl = $row["count"];
	}

	
          $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
?>

<?php

  $results = $db->query('SELECT * FROM wohnzimmer ORDER BY datum DESC');
  $i=0;
	while ($row = $results->fetchArray()) {
		$time = explode(" ", $row["datum"]);
		if ($i % 2){
			echo "<div style='background-color: #DDD; width: 20%;'>";
		}
		
		echo date_german($time[0])." " . $time[1] . " - ". $row["temperatur"] . "°C - " . $row["luftfeuchtigkeit"] ."%";
		if ($i % 2){
			echo "</div>";
		}
		$i++;
	}
    ?>
       


           </div>
 
</div>


    
  </div>

</body>
</html>
