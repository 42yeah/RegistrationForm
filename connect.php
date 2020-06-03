<?php

$link = mysqli_connect("127.0.0.1", "root", "feck", "playground");
mysqli_set_charset($link, "UTF-8");

function query($cmd) {
    global $link;
    $result = mysqli_query($link, $cmd);
    if (!$result) {
        return mysqli_error($link);
    }
    return $result;
}

$results = query("SHOW TABLES");
$res = mysqli_fetch_row($results);
print_r($res);

