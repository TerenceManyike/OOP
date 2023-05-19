<?php

class Files
{
    public $file_content;
    public $file_id;

    //Displays file content
    function showFileContent($file_path){
        try{
            $content = file_get_contents($file_path);
            echo($content);
        }catch(Exception $e){
            // echo("Exception raised: ". $e);
        }
    }
    function showFileSize(){}
}
$my_file = new Files();
$my_file->showFileContent("includess/testFileOne.txt");