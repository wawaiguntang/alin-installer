<?php

$status = true;
function custom_copy($src, $dst)
{

    $dir = opendir($src);

    @mkdir($dst);

    while ($file = readdir($dir)) {

        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                custom_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                $copy = copy($src . '/' . $file, $dst . '/' . $file);
                if(!$copy){
                    $GLOBALS['status'] = false;
                }
            }
        }
    }

    closedir($dir);
}


$dir = __DIR__;

$requestMethod = $_SERVER["REQUEST_METHOD"];
switch ($requestMethod) {
    case 'POST':
        $clientID = $_GET["clientID"];
        $app = $_GET["app"];
        $src = $dir . '/alin-'.$app;
        $dst = $dir . '/alin-'.$app.'-' . $clientID;
        custom_copy($src, $dst);
        if ($status) {
            $response = array(
                'status' => TRUE
            );
            header('Content-Type: application/json');
            echo json_encode($response,TRUE);
        }else{
            $response = array(
                'status' => FALSE
            );
            header('Content-Type: application/json');
            echo json_encode($response,TRUE);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
