<?php

function custom_copy($src, $dst)
{

    $dir = opendir($src);

    @mkdir($dst);

    while ($file = readdir($dir)) {

        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                custom_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }

    closedir($dir);
}

$dir = __DIR__;

$requestMethod = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'POST':
        $clientID = $_GET["clientID"];
        $src = $dir . '/alin-file';
        $dst = $dir . '/alin-file-' . $clientID;
        $copy = custom_copy($src, $dst);
        if ($copy) {
            $response = array(
                'status' => TRUE
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $response = array(
                'status' => FALSE
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
