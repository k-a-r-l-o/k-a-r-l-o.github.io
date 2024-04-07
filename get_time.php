<?php
    date_default_timezone_set('Asia/Manila');
    $time = date("h:i:s A");
    $date = date("F j, Y");
    echo json_encode(array("time" => $time, "date" => $date));
    ?>