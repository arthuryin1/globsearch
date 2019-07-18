<?php 
    $dir = __DIR__ . "/*";

	// Open a known directory, and proceed to read its contents
    $searchString = $_REQUEST['s']?$_REQUEST['s']:'responsive.php';
	foreach(glob($dir) as $file) 
	{
        if(filetype($file) == 'file'){
            /*if(exec('grep '.escapeshellarg($searchString).' '.$file)) {
            echo "*** $searchString exists in $file *** <br>";
            }*/
            $handle = fopen($file, "r+");
            if ($handle) {
                $nameflag = true;
                $lineNo = 1;
                while (($line = fgets($handle)) !== false) {
                    // process the line read.
                    if(preg_match('/'.$searchString.'/',$line)){
                        if($nameflag){
                            echo "<p>filename: $file </p>";
                            $nameflag = false;
                        }
                        echo '<p>--   Found in line '.$lineNo.': '.$line.'</p>';
                    }
                    $lineNo++;
                }
                fclose($handle);
            } else {
                echo '<p>error opening error log file.</p>';
                // error opening the file.
            }
        }
    }
?>
    
