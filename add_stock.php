<?php include 'con_db.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index_Stock</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<head>
	<title>CRUD: CReate, Update, Delete</title>
</head>
<body>

    <?php include 'nav_bar.php'?>
	<form method="post" action="add_stock_db.php" >
        <h2> ลงทะเบียนรายการสินค้าใหม่ </h2>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รับสินค้าจาก</span>
            </div>
            <input type="text" name="order_f" require>
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

                <?php $results = mysqli_query($conn,"SELECT * FROM unit"); ?>
                    <option displya>--เลือก--</option>
                    <?php while ($row = mysqli_fetch_array($results)) {
                        $row['id'] == $unit_id;
                        ?>
                    <option value="<?php $unit_id; ?>"> <?php echo $row['unit_name'];?> </option>
                    <?php } ?>
                

                </select>
		</div>
        

		<div class="btn btn-success">
			<button class="btn" type="submit" name="save" >เพิ่ม</button>
		</div>
        <table class="table">
	<thead class="thead-dark">
		<tr>
			
			<th>รับสินค้าจาก</th>
            <th>Code</th>
            <th>รายการ</th>
            <th>หน่วย</th>
            <th>แก้ไข</th>
            <th>ลบข้อมูล</th>
		
		</tr>
	</thead>
	<?php $results = mysqli_query($conn,"SELECT * FROM stock"); ?>
    <?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			
			<td><?php echo $row['order_f']; ?></td>
            <td><?php echo $row['code_stock']; ?></td>
            <td><?php echo $row['list_name']; ?></td>
          
            <td><?php echo $row['unit']; ?></td>
			<td>
				<a href="edit_stock.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
			</td>
			<td>
				<a href="del_stock.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
	</form>
    


</body>
</html>