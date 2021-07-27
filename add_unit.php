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
	<form method="post" action="add_unit_db.php" >
        <h2> เพิ่มหน่วยสินค้า </h2>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">ชื่อหน่วย</span>
            </div>
            <input type="text" name="unit_name" require>
        </div>

		<div class="btn btn-success">
			<button class="btn" type="submit" name="save" >เพิ่ม</button>
		</div>
        <table class="table">
	<thead class="thead-dark">
		<tr>
			
			<th>ชื่อหน่วย</th>
            <th>ลบข้อมูล</th>
		
		</tr>
	</thead>
	<?php $results = mysqli_query($conn,"SELECT * FROM unit"); ?>
    <?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			
          
            <td><?php echo $row['unit_name']; ?></td>
			<td>
				<a href="del_unit.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
	</form>
    


</body>
</html>