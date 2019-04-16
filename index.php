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
<meta name="copyright" content="(c)mockauer-<?php echo date('Y'); ?>" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>
<body>
<div id="maincontent">
  
      <div id="leftcontent">
		   <h2>Wohnzimmer</h2>
        <div id="uberschrift"><strong>Aktuelle Temperatur und Luftfeuchtigkeit</strong></div>
        <?php
          $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

 // echo "<div id='uberschrift'>";
  $results = $db->query('SELECT * FROM wohnzimmer ORDER BY datum DESC LIMIT 1');
while ($row = $results->fetchArray()) {
	echo date_german($row["datum"])." - " . $row["temperatur"]."°C - " . $row["luftfeuchtigkeit"]."%<br/>";
    //var_dump($row);
}
//echo "</div>":
        ?>
        
           </div>
    
    <div id="rightcontent">
		
    </div>
                    <?php

?>  
</div>


  <!--</div>-->
  

    
  </div>

</body>
</html>
