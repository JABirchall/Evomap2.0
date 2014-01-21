<?php


$databasehost = "localhost";
$databasename = "evomap";
$databasetable = "coord_info";
$databaseusername ="root";
$databasepassword = "";
$fieldseparator = ",";
$lineseparator = "\n";
$csvfile = "166.csv";
$SID = 323;
/********************************/
/* Would you like to add an ampty field at the beginning of these records?
/* This is useful if you have a table with the first field being an auto_increment integer
/* and the csv file does not have such as empty field before the records.
/* Set 1 for yes and 0 for no. ATTENTION: don't set to 1 if you are not sure.
/* This can dump data in the wrong fields if this extra field does not exist in the table
/********************************/
$addauto = 0;
/********************************/

/* Would you like to save the mysql queries in a file? If yes set $save to 1.
/* Permission on the file should be set to 777. Either upload a sample file through ftp and
/* change the permissions, or execute at the prompt: touch output.sql && chmod 777 output.sql
/********************************/
$save = 0;
$outputfile = "output.sql";
/********************************/

if (!file_exists($csvfile)) {
        echo "File not found. Make sure you specified the correct path.\n";
        exit;
}

$file = fopen($csvfile,"r");

if (!$file) {
        echo "Error opening data file.\n";
        exit;
}

$size = filesize($csvfile);

if (!$size) {
        echo "File is empty.\n";
        exit;
}

$csvcontent = fread($file,$size);

fclose($file);

$con = @mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
@mysql_select_db($databasename) or die(mysql_error());

$servername = explode($csvfile,".csv");
//mysql_query("insert into servers(id, name) values (" . $SID . ",\"" . $servername[0] . "\");");

$lines = 0;
$queries = "";
$linearray = array();

foreach(explode($lineseparator,$csvcontent) as $line) {
		/* @mysql_query("CREATE TABLE IF NOT EXISTS `".$databasetable."` (
		`x` int(3) NOT NULL,
		`y` int(3) NOT NULL,
		`city_name` text NOT NULL,
		`lord_name` text NOT NULL,
		`allaince` text NOT NULL,
		`status` int(1) NOT NULL,
		`flag` text NOT NULL,
		`honor` text NOT NULL,
		`prestige` int(15) NOT NULL,
		`disposition` int(1) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
        $lines++;

        $line = trim($line," \t");

        $line = str_replace("\r","",$line);

        /************************************
        This line escapes the special character. remove it if entries are already escaped in the csv file
        ************************************/
        $line = str_replace("'","",$line);
        $line = str_replace("\"","",$line);
        /*************************************/

        $linearray = explode($fieldseparator,$line);

        $linemysql = implode("','",$linearray);

        if($addauto)
                $query = "insert into $databasetable values('','$linemysql');";
        else
                $query = "insert into coord_info (servers_id, x, y, city_name, lord_name, alliance, status, flag, honor, prestige, disposition)
							values ('$SID','$linemysql');";

        $queries .= $query . "\n";

        @mysql_query($query);
}

@mysql_close($con);

/* if ($save) {

        if (!is_writable($outputfile)) {
                echo "File is not writable, check permissions.\n";
        }

        else {
                $file2 = fopen($outputfile,"w");

                if(!$file2) {
					echo "Error writing to the output file.\n";
                }
                else {	
					fwrite("CREATE TABLE IF NOT EXISTS `".$databasetable."` (
					`x` int(3) NOT NULL,
					`y` int(3) NOT NULL,
					`city_name` text NOT NULL,
					`lord_name` text NOT NULL,
					`allaince` text NOT NULL,
					`status` int(1) NOT NULL,
					`flag` text NOT NULL,
					`honor` text NOT NULL,
					`prestige` int(15) NOT NULL,
					`disposition` int(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
					@mysql_query("TRUNCATE `".$databasetable."`;");
					fwrite($file2,$queries);
					fclose($file2);
                }
        }

} */

echo "Found a total of $lines records in this csv file.\n";

?>