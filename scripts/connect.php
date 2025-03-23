<?php
    $url = getenv('MYSQL_HOST');
    $user = getenv('MYSQL_USERNAME');
    $pass = getenv('MYSQL_PASSWORD');
    $conn = new mysqli($url, $user, $pass, 'clinic');
    //$today = date("Y-m-d");
    $today = date('Y-m-d H:i:s');
?>
