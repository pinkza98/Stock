<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Multiple</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-dark">
		<a href="#" class="navbar-brand">Multiple Input</a>
	</nav>
	<div class="container">
		<div class="row mt-3">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">ร้านหอมกว่า Starbucks</h4>
						<form action="test2_1.php" method="post">
							<div class="form-group">
								<label for="">ชื่อผู้สั่ง</label>
								<input type="text" name="cFname" class="form-control">
							</div>
							<div class="form-group">
								<label for="">เบอร์มือถือ</label>
								<input type="text" name="cMobile" class="form-control">
							</div>
							<div class="form-group">
								<label for="">เครื่องดื่มที่ต้องการสั่ง</label>
								<ol>
									<li>
										<div class="d-flex mb-2">
											<input type="text" name="cOrder[]" class="form-control">
											<label class="pt-2 mx-2">จำนวน</label>
											<input type="text" name="nQuantity[]" class="form-control w-25">
											<button class="btn btn-success mx-2 btn-add">+</button>
											<button class="btn btn-danger btn-remove">-</button>
										</div>
									</li>
								</ol>
							</div>
							<button type="submit" class="btn btn-success">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
	<script src="js/script.js"></script>
</body>
<script>
    $(function(){

$("body").on("click", ".btn-add", function(e){
    e.preventDefault();
    let ol = $(this).closest("ol")
    let li = $(this).closest("li").clone()
    li.appendTo(ol)
    li.find("input").val("")
    li.find(".btn-remove").show()
    li.find("[name='cOrder[]']").focus()
})

$("body").on("click", ".btn-remove", function(e){
    e.preventDefault()
    $(this).closest("li").remove()
})

});

</script>
</html>