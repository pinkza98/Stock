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

                <?php $results = mysqli_query($conn,"SELECT * FROM branch"); ?>
                    <option displya>--เลือก--</option>
                    <?php while ($row = mysqli_fetch_array($results)) {
                        $row['id'] == $branch_id;
                        ?>
                    <option value="<?php echo $branch_id; ?>"> <?php echo $row['branch_name'];?> </option>
                    <?php } ?>
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

                <?php $results = mysqli_query($conn,"SELECT * FROM unit"); ?>
                    <option displya>--เลือก--</option>
                    <?php while ($row = mysqli_fetch_array($results)) {
                        $row['id'] == $unit_id;
                        ?>
                    <option value="<?php echo $unit_id; ?>"> <?php echo $row['unit_name'];?> </option>
                    <?php } ?>
                </select>
		</div>
        <div class="input-group">
			<button class="btn" type="submit" name="save" >Save</button>
		</div>
        <table>
	<thead>
		<tr>
			<th>ชื่อสาขา</th>
            <th>รหัสบาร์โค้ด</th>
            <th>ชื่อรายการ</th>
            <th>จำนวน</th>
            <th>ราคา/หน่วย</th>
            <th>ลบ</th>
		</tr>
	</thead>
	<?php $results = mysqli_query($conn, "SELECT * FROM branch_stock"); ?>
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['branch_name']; ?></td>
            <td><?php echo $row['code_item']; ?></td>
            <td><?php echo $row['item_name']; ?></td>
            <td><?php echo $row['inventories']."/".$row['unit_name']; ?></td>
            <td><?php echo $row['price']."/".$row['unit_name']; ?></td>
			<td>
				<a href="branch_stock_del.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
        </form>
    </div>

</body>
</html>