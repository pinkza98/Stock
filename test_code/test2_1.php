<?php
echo "
	<h4>สรุปรายการเครื่องดื่ม</h4>
	<p>ชื่อผู้สั่ง {$_REQUEST['cFname']}</p>
	<p>เบอร์โทร {$_REQUEST['cMobile']}</p>
	<p>เมนูที่สั่ง</p>
	<ol>
";
// insert into table order
// get order_id 201
foreach($_REQUEST['cOrder'] AS $key => $cOrder){
	// insert into table order_menu by order_id 201
	echo "<li> {$cOrder} จำนวน {$_REQUEST['nQuantity'][$key]} แก้ว</li>";
}
echo "</ol>";
?>