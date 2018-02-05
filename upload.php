<?php

 
$storeFolder = 'uploads/';   
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];   
      
     
    $targetFile =  $storeFolder. $_FILES['file']['name'];  
 
    move_uploaded_file($tempFile,$targetFile); 
	

	if(file_exists($targetFile)){

		auto_import_sql($targetFile);
	}
}



// credits : https://stackoverflow.com/questions/19751354/how-to-import-sql-file-in-mysql-database-using-php
function auto_import_sql($filename){


		$mysql_host = 'localhost';
		
		$mysql_username = 'root';
		
		$mysql_password = '';
		
		$mysql_database = 'vx'; // database name where you want to import the tables inside your uploaded sql file

			$con = mysqli_connect($mysql_host, $mysql_username, $mysql_password,$mysql_database) or die('Error connecting to MySQL server: ' . mysqli_error($con));
			

			$templine = '';

			$lines = file($filename);

			foreach ($lines as $line)
			{

			if (substr($line, 0, 2) == '--' || $line == '')
			    continue;


			$templine .= $line;

			if (substr(trim($line), -1, 1) == ';'){

			    mysqli_query($con,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($con) . '<br /><br />');
			
			    $templine = '';
			}

		}

}

?> 