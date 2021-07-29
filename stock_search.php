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
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);

	$strKeyword = null;

	if(isset($_POST["txtKeyword"]))
	{
		$strKeyword = $_POST["txtKeyword"];
	}
?>
<?php include 'layout/nav.php'?>
    <form name="frmSearch" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">    
    <table width="599" border="1">
        <tr>
            <th>บาร์โค้ด
            <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $strKeyword;?>">
            <div class="btn btn-success">
			<button class="btn" type="submit" velue="Search" >ค้นหา</button>
		</div></th>
        </tr>
    </table>

		
    
        <br> 
      
        <hr>  
        <?php 
         $sql2=" SELECT  * FROM center_stock INNER  JOIN stock ON  center_stock.code_item = stock.code_item LIKE '".$strKeyword."%'";
         $query2 = mysqli_query($conn,$sql2);
         while($result2=mysqli_fetch_array($query2,MYSQLI_ASSOC)){
        ?>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รหัสบาร์โค้ด : <?php echo $result2['code_item']?></span>
            </div>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รายการ : <?php echo $result2['stock.list_name'] ?></span>
            </div>
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">ส่วนกลาง : <?php echo $result2['inventories'] ?></span>
               <?php } ?>
                
            </div>
        </div>
        <table class="table">
	<thead class="thead-dark">
		<tr>
			
			<th>สาขา</th>
            <th>คงเหลือ</th>
            <th>หน่วย</th>
        
		</tr>
	</thead>
   

    <?php 
    $sql = "SELECT * FROM branch_stock WHERE code_item LIKE '%".$strKeyword."%' ORDER BY inventories DESC";
    $query = mysqli_query($conn,$sql);
    while($result=mysqli_fetch_array($query,MYSQLI_ASSOC))
    {?>
		<tr>
			
			<td><?php echo$result['name_branch']?></td>
            <td><?php echo$result['inventories']?></td>
            <td><?php echo $result['unit']?></td>
			
		</tr>
      <?php } ?>
	
</table>

	</form>
</body>
</html>