<?php 


function writeToLog($text){

    $filename = "../log/log1.txt";

    file_put_contents($filename, $text . "\r\n", FILE_APPEND);

}

?>