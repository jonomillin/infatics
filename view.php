<?php
include "lib/library.php";

if($_POST['pwd'] != 'notepad')
{
	$html = "<html></body><form action='view.php' method='post'><center><strong>Enter password to login:</strong> <input type='password' name='pwd'/><input type='submit' name='submit' value='Login'/></centeR></body></html>";
	print $html;
	exit;
}

?>

<html>

<head>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);


      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('datetime', 'Date');
      data.addColumn('number', 'Activity');
      data.addRows([

<?php
$grain = 1; //hour
$count = 0;
$start = date('U') - 1200;
$end   = date('U');

//$end = round($end/60)*60;
//od_query_value("SELECT MAX(UNIX_TIMESTAMP(registered)) FROM users");

for($lv = $start; $lv <= $end; $lv=$lv+$grain)
{
	$count = 0 + good_query_value("SELECT sum(count) FROM captures WHERE time >= ".$lv." AND time < ".($lv+$grain));
	$Time =  "new Date(".date("Y", $lv).",".(date("m", $lv)-1).",".(date("d", $lv)-1).")";
$Time = "new Date($lv*1000)";
	print "[" . $Time . ", " . $count . "],";
}

?>
      ]);

      // Set chart options
      var options = {'title':'Viewer Activity',
                     'width':800,
                     'height':600,
                     'colors':['red'],
		     };
                                    

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>


<link rel="stylesheet" href="admin.css" type="text/css" media="screen" />



</head>


<body>


<center>
<div id="chart_div" style="width:800; height:600"></div>
</center>
</body>
</html>




