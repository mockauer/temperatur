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
        
        
        <div id="chartdiv"></div>
           </div>
    
    <div id="rightcontent">
		
    </div>
                    <?php
                    $anzahl = 0;
$results = $db->query('SELECT count(*) as count FROM wohnzimmer');
	while ($row = $results->fetchArray()) {
		$anzahl = $row["count"];
	}
	
	//echo $anzahl;
?>  
</div>


  <!--</div>-->
  

    
  </div>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Export
chart.exporting.menu = new am4core.ExportMenu();

// Data for both series
var data = [
	<?php
	  $results = $db->query('SELECT * FROM wohnzimmer ORDER BY datum DESC');
	  $i = 0;
	while ($row = $results->fetchArray()) { ?>{
		"date":"<?php echo $row['datum']; ?>",
		"luftfeuchtigkeit":"<?php echo $row['luftfeuchtigkeit']; ?>",
		"temperatur":"<?php echo $row['temperatur']; ?>"
}<?php 
$i++;
if ($anzahl > $i){
	echo ",";
}
}
 ?>
];

/* Create axes */
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "date";
categoryAxis.renderer.minGridDistance = 30;

/* Create value axis */
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Temperatur in °C";

var durationAxis = chart.yAxes.push(new am4charts.DurationAxis());
durationAxis.title.text = "Luftfeuchtigkeit in %";
//durationAxis.baseUnit = "minute";
durationAxis.renderer.grid.template.disabled = true;
categoryAxis.renderer.labels.template.rotation = 270;
durationAxis.renderer.opposite = true;

/* Create series */
var columnSeries = chart.series.push(new am4charts.ColumnSeries());
columnSeries.name = "luftfeuchtigkeit";
columnSeries.dataFields.valueY = "luftfeuchtigkeit";
columnSeries.dataFields.categoryX = "date";

columnSeries.columns.template.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}%[/] [#fff]{additional}[/]"
columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
columnSeries.columns.template.propertyFields.stroke = "stroke";
columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
columnSeries.tooltip.label.textAlign = "middle";

// Add scrollbar
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(columnSeries);

// Add cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.xAxis = categoryAxis;
chart.cursor.snapToSeries = columnSeries;

var lineSeries = chart.series.push(new am4charts.LineSeries());
lineSeries.name = "Temperatur";
lineSeries.dataFields.valueY = "temperatur";
lineSeries.dataFields.categoryX = "date";

lineSeries.stroke = am4core.color("#ff0000");
lineSeries.strokeWidth = 3;
lineSeries.propertyFields.strokeDasharray = "lineDash";
lineSeries.tooltip.label.textAlign = "middle";

var bullet = lineSeries.bullets.push(new am4charts.Bullet());
bullet.fill = am4core.color("#ff0000"); // tooltips grab fill from parent by default
bullet.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}°C[/] [#fff]{additional}[/]"
var circle = bullet.createChild(am4core.Circle);
circle.radius = 4;
circle.fill = am4core.color("#fff");
circle.strokeWidth = 3;

chart.data = data;
</script>
</body>
</html>
