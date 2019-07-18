<?php 
    $dir = __DIR__ . ($_REQUEST['d']?'/'.$_REQUEST['d'].'/*':"/sys/*");

	// Open a known directory, and proceed to read its contents
    $searchString = $_REQUEST['s']?$_REQUEST['s']:'hk-listing-location.css\'';
    checkFolder($dir, $searchString);
    $searchedFolder = array();
    function checkFolder($dir, $searchString)
    {
        //echo "<p>$dir</p>";
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
                                echo "<h4>filename: $file </h4>";
                                $nameflag = false;
                            }
                            echo '<p>--         line '.$lineNo.': '.$line.'</p>';
                        }
                        $lineNo++;
                    }
                    fclose($handle);
                } else {
                    //echo '<p>error opening error log file.</p>';
                    // error opening the file.
    
                }
            }
            else if(filetype($file) == 'dir' && !in_array($file, $searchedFolder)){
                //echo "<p> moving in $file </p>";
                array_push($searchedFolder, $file);
                checkFolder($file.'/*', $searchString);
            }
        }
    }
?>