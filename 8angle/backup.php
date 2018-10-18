<?php include 'includes/common.php';
error_reporting(E_ALL);

ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE); 
date_default_timezone_set('Asia/Kolkata');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
function getDB1()
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	try {
		$dbConnection = new PDO("mysql:host=$dbhost;", $dbuser, $dbpass);
		$dbConnection->exec("set names utf8");
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
		return $dbConnection;
	}
	catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	}

}
function getDB2()
{
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname  = DB_DATABASE;
	try {
		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbConnection->exec("set names utf8");
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
		return $dbConnection;
	}
	catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	}

}
$meta_title = "Import/Export Backup- 8angle | POS  ";
if(isset($_POST['import'])) 
{
		// Name of the file
	$filename = $_FILES["fileToUpload"]["name"];
	$target_file =basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	if($imageFileType == "sql" AND move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],  'backup/'.$filename))
	{
		// Database name
		$mysql_database = DB_DATABASE;
		
		$sql = "DROP DATABASE IF EXISTS $mysql_database ";
		getDB1()->exec($sql);
		
		$sql = "CREATE DATABASE IF NOT EXISTS $mysql_database ";
		getDB1()->exec($sql);
		
		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file("backup/".$filename);
		// Loop through each line
		foreach ($lines as $line)
		{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{  
			$prep = getDB2()->prepare($templine); 
			// Perform the query
			$prep->execute() or print('Error performing query \'<strong>' . $templine . '\': <br /><br />');
			// Reset temp variable to empty
			$templine = '';
		}
		}
		$created="Wow! Backup imported successfully";
		$created="<div class='alert alert-success alert-dismissible'><strong>Wow! </strong>Backup imported successfully !</div>";
	}
	else {
		$created="<div class='alert alert-danger alert-dismissible'><strong></strong>Error while importing Backup !</div>";
	}
}
if(isset($_POST['Backup'])) 
{
    $mysqlUserName      = DB_USERNAME;
    $mysqlPassword      = DB_PASSWORD;
    $mysqlHostName      = DB_SERVER;
    $DbName             = DB_DATABASE;
    $backup_name        = "mybackup.sql";
    $tables             = "";

   //or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables
  function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $backup_name = $backup_name ? $backup_name : $name.".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
	
			/** Include PHPExcel */
		require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
		$tableList = array();
        $result = getDB()->query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) 
		{
			$tableList[] = $row[0];
			$table_name = $row[0];
       
		
			$objPHPExcel = new PHPExcel();    

			$objPHPExcel->getProperties()->setCreator("8angle")
										 ->setLastModifiedBy("8angle POS")
										 ->setTitle("Backup Document")
										 ->setSubject("Backup Document")
										 ->setDescription("")
										 ->setKeywords("8angle POS GST Software")
										 ->setCategory($table_name." Backup file");
	   
			$SQL = "SELECT * from $table_name";
			$exportData = getDB()->prepare($SQL);
			$exportData->execute();
				 
			$fields = $exportData->columnCount();
				 
			$row = 1; 
			$col = 0;
			$col1= $col;
			$colums =  array();
			for ( $i = 0; $i < $fields; $i++ )
				{
					$colname = $exportData->getColumnMeta($i);
					$columns[$i] = $colname['name'];
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $colname['name']);
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
					$col++;
				}
				$row = 2; 
			while( $data = $exportData->fetch(PDO::FETCH_OBJ) )
				{
					for ( $j = 0; $j < $fields; $j++ )
					{
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1, $row, $data->$columns[$j]);
						$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col1)->setAutoSize(true);
						$col1++;
					}
					
					$row++;
					$col1 = 0;
				}
				
			$objPHPExcel->getActiveSheet()->setTitle('Simple');

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			$file_name = "backup/excel/".$table_name.'.xls';

			// Save Excel 95 file
			$callStartTime = microtime(true);

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($file_name);
			$callEndTime = microtime(true);
			$callTime = $callEndTime - $callStartTime;
		}
    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name=false );

}
require('header.php');
require('left.php');
isCompany($company_id);

/** Error reporting */
error_reporting(E_ALL);

ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE); 
date_default_timezone_set('Asia/Kolkata');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$table_fields = "id";
$table_name = "products_unit";

?>

<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Export/Import Backup
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Export/Import</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<?php
					if($created) { echo $created; }
					if($updated) { echo $updated; }
					if($deleted) { echo $deleted; }
					?>
			</div>
			<div class="box-body">
				<form action="" method="post"  class="col-sm-6" role="form">
					<h3>Export</h3>
					<!-- text input -->
					<div class="form-group col-sm-12">
						<label for="backup_path">Create Backup  </label>
						<button type="submit" name="Backup" class="btn btn-primary">Export</button>
					</div>
				</form>
			</div>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
