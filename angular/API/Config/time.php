<?php

//    $date1 = new DateTime(date("l:m:YH:i:s"));
//    print_r($date1);

$date1 = new DateTime(date("l-m-Y H:i:s"));
$date2 = new DateTime(date("l-m-Y H:i:s"));
$diff = $date2->diff($date1);
print_r($diff->m);
?>