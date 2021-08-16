<?php 

function date_to_num($time) {
date_default_timezone_set('Asia/Bangkok');
$date=date_create();
date_timestamp_set($date,"getdate()");
echo date_format($date,"U = Y-m-d");
return $date;
}
function sting_to_num($time) {
$strValue = "008";
echo intval($strValue); // 8
}
// function datediff ( $start, $end ) {

//     $datediff = strtotime(dateform($end)) - strtotime(dateform($start));
//     return floor($datediff / (60 * 60 * 24));
//  }
 
 function dateform($date){
 
    $d = explode('/',$date);
    return $d[2].'-'.$d[1].'-'.$d[0];
    //  echo datediff("22/09/2015" , "29/09/2015");  // Result = 7
 }
 echo '<h4> + วันที่ PHP </h4>';


 function DateDiff($strDate1,$strDate2)
 {
            return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
 }
 function TimeDiff($strTime1,$strTime2)
 {
            return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
 }
 function DateTimeDiff($strDateTime1,$strDateTime2)
 {
            return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
 }
// $strStartDate =date('Y-m-d');
// $strNewDate = date ("Y-m-d", strtotime("+10 day", strtotime($strStartDate)));
// echo 'วันที่ '.$strStartDate;
// echo '<br>';
// echo ' + 10 วัน = '.$strNewDate;
// //-------------//
// echo '<hr>';
// echo '<b> Workshop คำนวณวันหมดอายุสินค้า </b><br>';
// $prdImptDate =date('Y-m-d'); //วันที่รับสินค้าเข้าคลัง
// //คำนวณวันหมดอายุ
// $calExpireDate = date ("Y-m-d", strtotime("+30 day", strtotime($prdImptDate)));
// //echo ออกมาดู
// echo 'สินค้ารับเข้าวันที่ '.$prdImptDate;
// echo '<br>';
// echo 'สินค้าจะหมดอายุอีก 30 วัน <br>';
// echo 'สินค้าหมดอายุวันที่ '.$calExpireDate;
// //devbanban.com
?>
