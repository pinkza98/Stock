<?php include 'con_db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>branch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
       
</head>

<body>
    <?php include 'layout/nav.php'; ?>
    <div class="container">
        <form method="post" action="branch_add_db.php">
            <h3>เพิ่มรายการสินค้าสาขา</h3>
            
            <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">หน่วย</span>
            </div>
                <select class="form-control" name="branch_id">

                
                </select>
		</div>
        <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รหัสบาร์โค้ด</span>
            </div>
			<input type="text" name="code_stock" require>
		</div>

        <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">ชื่อรายการ</span>
            </div>
			<input  type="text" name="list_name" require>
		</div>
        
        <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">หน่วย</span>
            </div>
                <select class="form-control" name="unit_id">

                
                </select>
		</div>
        <div class="input-group">
			<button class="btn" type="submit" name="save" >Save</button>
		</div>
        <table>
	<thead>
		<tr>
			<th>สาขา</th>
            <th>รหัส</th>
            <th>รายการ</th>
            <th>จำนวน</th>
            <th>ราคา</th>
            <th>ลบ</th>
		</tr>
	</thead>
	
</table>
        </form>
    </div>

</body>
</html>