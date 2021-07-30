<?php include 'con_db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
       <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js"></script>
   <!-- The core Firebase JS SDK is always required and must be listed first -->
   <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-firestore.js"></script>
</head>

<body>
    <?php include 'layout/nav.php'; ?>
    <div class="container">
        <form method="post" action="add_stock_db.php" >
        <h2> เพิ่มรายการลงคลังกลาง </h2>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รหัสบาร์โค้ด</span>
            </div>
            <input type="text" name="order_f" require>
        </div>

        <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">จำนวน</span>
            </div>
			<input type="text" name="code_stock" require>
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
        

		<div class="btn btn-success">
			<button class="btn" type="submit" name="save" >เพิ่ม</button>
		</div>
        <table class="table">
	
</table>
	</form>
    </div>

</body>
</html>