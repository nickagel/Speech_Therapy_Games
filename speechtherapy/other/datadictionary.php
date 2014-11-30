<?php include 'top.php' ?>

<style type="text/css">   
aside{
    height: 600px; 
    float: left; 
    overflow: auto; 
    margin-left: 2em;            
}
section{
    width: 35%; 
    height: 600px; 
    float: left; 
    overflow: auto;
}
table{
    border: medium #000080 solid;
    border-collapse: collapse;
}

td {
    border: thin #000080 solid;
    border-collapse: collapse;
}

.odd{
    background-color: lightcyan;
}

.even{
    background-color: whitesmoke;
}
</style>

<!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
<![endif]-->
    
</head>


<?php
$debug=false;
//############################################################################
//
// This page lists your tables and fields within your database. if you click on
// a database name it will show you all the records for that table.
//
//############################################################################

print '<body id="' . $path_parts['filename'] . '">';


$tableName="";

if(isset($_GET['getRecordsFor'])){
    // Sanitize the input to help prevent sql injection
    $tableName=  htmlentities($_GET['getRecordsFor'], ENT_QUOTES);
}


print "<h2>Database: " .  $dbName . "</h2>";

// print out a list of all the tables and their description
// make each table name a link to display the record
print "<section id='table'>";

$tableNameName = "Tables_in_" . $dbName;
print "<table>";

$query = "SHOW TABLES";
$results = $thisDatabase->select($query);

foreach($results as $row){

    // table name link
    print '<tr class="odd">';
    echo "<th colspan='6' style='text-align: left'><a href='?getRecordsFor=" . $row[0] ."#" . $row[0] . "'>" . $row[0] . "</a></th></tr>";
    //get the fields and any information about them
    

    $query = "SHOW COLUMNS FROM " . $row[0];
    $results2 = $thisDatabase->select($query);

    foreach($results2 as $row2){
        print "<tr>";
        print "<td>" . $row2['Field'] . "</td>";
        print "<td>" . $row2['Type'] . "</td>";
        print "<td>" . $row2['Null'] . "</td>";
        print "<td>" . $row2['Key'] . "</td>";
        print "<td>" . $row2['Default'] . "</td>";
        print "<td>" . $row2['Extra'] . "</td>";
        print "</tr>";
    }
}
print "</table></section>";

if($tableName!=""){
	print "<aside id='records'>";

	$query = "SHOW COLUMNS FROM " . $tableName;
        $info = $thisDatabase->select($query);
        
	$span = count($info);

	//print out the table name and how many records there are
	print "<table border='1'>";
	echo "<tr>";
        
        echo "<th colspan='" . $span . "' style='text-align: left'>" . $tableName;

	$query = "SELECT * FROM " . $tableName;
        $a = $thisDatabase->select($query);
        
 
	echo " " . count($a). " records";

	echo "</th></tr>";
	
	//print out the column headings
	print "<tr>";
	$columns=0;
        foreach($info as $field){
            // ok messes up the pk since its not a 3 letter prefix. oh well
            print "<td>";
            $camelCase = preg_split('/(?=[A-Z])/',substr($field[0],3));
        
            foreach ($camelCase as $one){
                 print $one . " ";
            }
            
            "</td>";
            $columns++;
	}
	print "</tr><tr>";
	
	//now print out each record
	$query = "SELECT * FROM " . $tableName;
        
        $info2 = $thisDatabase->select($query);
        
        $highlight=0; // used to highlight alternate rows
        foreach($info2 as $rec){
            $highlight++;
            if ($highlight % 2 != 0){
			$style=" odd ";
		}else{
			$style = " even ";	
		}
		print '<tr class=' . $style . '>';
		for($i=0; $i<$columns;$i++){
			print "<td>" . $rec[$i]  . "</td>";
		}
		print "</tr>";
	}
	
	// all done
	print "</table>";
	print "</aside>";
}

?>
</body>
</html>

