<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
	 function date_german($date) {
    $d    =    explode("-",$date);
    
    return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}

	 function date_german_time($date) {
    $d    =    explode("-",$date);
    return    sprintf("%02d.%02d.%04d %4s", $d[2], $d[1], $d[0], substr($d[2],3,8));
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


</head>
<body>
<div id="maincontent">
  
      <div id="leftcontent">
		   <h2>Wohnzimmer</h2>
		           <?php
          $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);


  $results = $db->query('SELECT * FROM wohnzimmer ORDER BY datum DESC LIMIT 1');
	while ($row = $results->fetchArray()) {
		$zeit = explode(" ", $row["datum"]);
		?>
		 <div id="uberschrift"><strong>Aktuelle Temperatur und Luftfeuchtigkeit</strong></div>

    
    <div id="start"><?php echo date_german($row["datum"])." " . $zeit[1] . " - " . $row["temperatur"]."°C - " . $row["luftfeuchtigkeit"]."%"; ?> </div>
       
		<?php
	}
    ?>
    
 <?php
	include("menu.php");
 ?>
</div>
</div>

</body>
</html>

<?php
//DurchschnittTemperatur speichern und alles nach einem Jahr löschen
?>
