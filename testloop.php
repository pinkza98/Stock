<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
$arr_simple_data = array(
    array("id"=>1,"title"=>"รายการทดสอบ 1","title"=>"รายการทดสอบ 2","status"=>0),
    array("id"=>2,"title"=>"รายการทดสอบ 2","status"=>0),
    array("id"=>3,"title"=>"รายการทดสอบ 3","status"=>0),
    array("id"=>4,"title"=>"รายการทดสอบ 4","status"=>0),
    array("id"=>5,"title"=>"รายการทดสอบ 5","status"=>0),
);
?>
    <div class="container mb-2">
        <div class="row bg-light py-3">
            <div class="col text-center">
                Content Test
            </div>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">หัวข้อ</th>
                        <th scope="col" class="text-center">สถานะ</th>
                        <th scope="col" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
    foreach($arr_simple_data as $row){
  ?>
                    <tr class="">
                        <th scope="row" class="text-center" width="40"><?=$row['id']?></th>
                        <td class="text-nowrap" onClick="$('#item-<?=$row['id']?>').toggleClass('d-none d-table-row')">
                            <?=$row['title']?>
                        </td>
                        <td class="text-nowrap text-center" width="50">
                            <div class="btn-group-toggle btn-status-check" data-toggle="buttons">
                                <label class="btn btn-sm <?=($row['status']==1)?"btn-success":"btn-light"?>">
                                    <input type="checkbox" <?=($row['status']==1)?"checked":""?>
                                        value="<?=$row['id']?>"> ใช้งาน
                                </label>
                            </div>
                        </td>
                        <td class="text-nowrap text-center" width="40">
                            <a href="?d_item_id=<?=$row['id']?>" title="อนุมัติ"
                                class="btn btn-sm btn-success btn-confirm">อนุมัติ</a>
                            <a href="?d_item_id=<?=$row['id']?>" title="ไม่อนุมัติ"
                                class="btn btn-sm btn-danger btn-confirm">ไม่อนุมัติ</a>
                        </td>
                    </tr>
                    <tr class="d-none" id="item-<?=$row['id']?>">
                        <td colspan="4" class="bg-light">
                            <?=$row['title']?>
                        </td>
                    </tr>
                    <?php
    }
?>
                </tbody>
            </table>
        </div>

    </div>


    <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/bootstrap@4.1.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(function() {

        $(".btn-status-check").on("click", function() {
            var obj = $(this);
            var checkStatus = obj.find(":checkbox").prop("checked");
            var dataID = obj.find(":checkbox").val();
            var checkVal = (checkStatus) ? 0 :
            1; // สลับจากค่าเดิม ถ้าเดิมถูกเลือก แสดง่ว่าเป็น 1 ต้องสลับเป็น 0
            setTimeout(function() {
                if (checkStatus) { // ถ้าเดิมมีการเลือกไว้อยู่แล้ว หรือในที่นี้มีสถานะเป็น 1
                    // สถานะจะสลับเป็น 0 หรือถุกติ้กออก
                    obj.find("label").addClass("btn-light").removeClass("btn-success active");
                    obj.find("label :checkbox").prop("checked", false);
                } else { // ถ้าเดิมยังไม่ถูกเลือก
                    // สถานะจะสลับเป็น 1 หรือถุกติ้กเลือก
                    obj.find("label").addClass("btn-success").removeClass("btn-light active");
                    obj.find("label :checkbox").prop("checked", true);
                }
                console.log(dataID); // ค่า id ของรายการที่เราจะอัพเดท  
                console.log(checkVal); // ค่าการกำหนดสถานะใหม่ 1 หรือ 0
            }, 5);

        });

        $(".btn-confirm").on("click", function() {
            var obj = $(this); // อ้างอิงปุ่ม
            obj.parents("tr").toggleClass("table-danger"); // เปลี่ยนสีพื้นหลังแถวที่จะลบ
            // ถ้ามีการกำหนด title ใช้ข้อความใน title มาข้นแจ้ง ถ้าไม่มีใช้ค่าที่กำหนด "ลบรายการข้อมูล"
            var alertMsg = (obj.attr("title") != undefined) ? obj.attr("title") : "ลบรายการข้อมูล";
            setTimeout(function() { // หน่วงเวลาเพื่อให้ การกำหนดสีพืนหลังแถวทำงานได้
                if (!confirm("ยืนยันการทำรายการ " + alertMsg + " ?")) {
                    obj.parents("tr").toggleClass(
                    "table-danger"); // ไม่ยืนยันการลบ เปลี่ยนสีพื้นหลังกลับ
                } else {
                    window.location = obj.attr("href"); // ถ้ายืนยันการลบ ก็ให้ลิ้งค์ทำงาน
                }
            }, 100); // หน่วงเวลา 100 มิลลิวินาที
            return false; // ไม่ให้ลิ้งค์ทำงานปกติ ให้เข้าไปในเงื่อนไข confirm แทน
        });

    });
    </script>
</body>

</html>
<!-- <script>
$(".your-click-event").on("click", function() {
    $(".custom-view").css({
        "display": "table-cell"
    });
})
</script> -->