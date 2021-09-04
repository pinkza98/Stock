<?php
include 'config.php';
session_start();
include 'authcheckkasir.php';


$barang = $db->query("SELECT * FROM barang");
// print_r($_SESSION);
$barang->execute();

$sum = 0;
if (!empty($_SESSION['cart'])) {
	if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += ($value['harga'] * $value['qty']) - $value['diskon'];
    }
}
}else {
	$_SESSION['cart'] = [];
}

//================================================================================================================================
if (isset($_POST['kode_barang'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = 1;

    //menampilkan data barang
    $data =$db->query("SELECT * FROM barang WHERE kode_barang='$kode_barang'");
	$data->execute();
    $b = $data->fetch();

    //cek diskon barang
    $disbarang = $db->query("SELECT * FROM disbarang WHERE barang_id='$b[id_barang]'");
	$disbarang->execute();
    $disb= $disbarang->fetch(PDO::FETCH_ASSOC);

    //cek jika di keranjang sudah ada barang yang masuk
    $key = array_search($b['id_barang'], array_column($_SESSION['cart'], 'id'));
	// return var_dump($key);

    if ($key !== false) {
        // return var_dump($_SESSION['cart']);

        //jika ada data yang sesuai di keranjang akan ditambahkan jumlah nya
        $c_qty = $_SESSION['cart'][$key]['qty'];
        $_SESSION['cart'][$key]['qty'] = $c_qty + 1;

        //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
        if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] >= $disb['qty']) {

            //cek kelipatan jumlah barang dengan batas minimum order
            $mod = $_SESSION['cart'][$key]['qty'] % $disb['qty'];

            if ($mod == 0) {

                //Jika benar jumlah barang kelipatan batas minimum order
                $d = $_SESSION['cart'][$key]['qty'] / $disb['qty'];
            } else {

                //Simpan jumlah potongan yang didapat
                $d = ($_SESSION['cart'][$key]['qty'] - $mod) / $disb['qty'];
            }

            //Simpan diskon dengan jumlah kelipatan dikali potongan barang
            $_SESSION['cart'][$key]['diskon'] = $d * $disb['potongan'];
        }
    } else {
        // return var_dump($b);
        //Jika tidak ada yang sesuai akan menjadi barang baru dikeranjang
        $barang = [
            'id' => $b['id_barang'],
            'nama' => $b['nama'],
            'harga' => $b['harga'],
            'qty' => $qty,
            'diskon' => 0,
        ];

        $_SESSION['cart'][] = $barang;

        //merubah urutan tampil pada keranjang
        // krsort($_SESSION['cart']);
    }

    header('location:kasir.php');
}


if(isset($_POST['bayar'])){
	$bayar = preg_replace('/\D/', '', $_POST['bayar']);
// print_r(preg_replace('/\D/', '', $_POST['total']));

// print_r($_SESSION['cart']) ;

$tanggal_waktu = date('Y-m-d H:i:s');
$nomor = rand(111111,999999);
$total = $_POST['total'];
$nama = $_SESSION['nama'];
$kembali = $bayar - $total;

$insert_transaksi = $db->prepare("INSERT INTO transaksi (tanggal_waktu,nomor,total,nama,bayar,kembali) VALUES ('$tanggal_waktu','$nomor','$total','$nama','$bayar','$kembali')");

//insert ke tabel transaksi



//insert ke detail transaksi
foreach ($_SESSION['cart'] as $key => $value) {

	$id_barang = $value['id'];
	$harga = $value['harga'];
	$qty = $value['qty'];
	$tot = $harga*$qty;
	$disk = $value['diskon'];

	$insert_transaksi_detail = $db->prepare("INSERT INTO transaksi_detail (id_transaksi,id_barang,harga,qty,total,diskon) VALUES (LAST_INSERT_ID(),'$id_barang','$harga','$qty','$tot','$disk')");

	if($insert_transaksi->execute()){
		if($insert_transaksi_detail->execute()){
			$_SESSION['cart'] = [];
			header('location:kasir.php');
		}

	}
	// $sum += $value['harga']*$value['qty'];
}
//redirect ke halaman transaksi selesai

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Stock system</h1>
                <hr>
                <h2>สวัสดี <?=$_SESSION['nama']?></h2>
                <a href="logout.php">Logout</a> |
                <a href="keranjang_reset.php">Reset หน้านับสต๊อก</a> |
                <a href="riwayat.php">รายการที่บันทึก</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <form method="post">
                    <!-- action="keranjang_act.php" -->
                    <div class="form-group">
                        <input type="text" name="kode_barang" class="form-control" placeholder="รหัสบาร์โค้ด" autofocus>
                    </div>
                </form>
                <br>
                <form method="post">
                    <table class="table table-bordered">
                        <tr>
                            <th>ชื่อรายการ</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>จำนวน</th>
                            <th>รวมราคา</th>
                            <th>ลบ</th>
                        </tr>
                        <!-- //รับค่ามาจาก keranjang_act ในการส่งอาเรย์ไอเทม -->
                        <?php if (isset($_SESSION['cart'])){ ?>
                        <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                        <tr class="text-center">
                            <td>
                                <?=$value['nama']?>
                                <?php if ($value['diskon'] > 0): ?>
                                <br><small class="label label-danger">Diskon
                                    <?=number_format($value['diskon'])?></small>
                                <?php endif;?>
                            </td>
                            <td><?=number_format($value['harga'])?></td>
                            <td class="col-md-2">
                                <input type="number" name="qty[<?=$key?>]" value="<?=$value['qty']?>"
                                    class="form-control">
                            </td>
                            <td><?=number_format(($value['qty'] * $value['harga'])-$value['diskon'])?></td>
                            <td><a href="keranjang_hapus.php?id=<?=$value['id']?>" class="btn btn-danger"><i
                                        class="glyphicon glyphicon-remove"></i></a></td>
                        </tr>
                        <?php } ?>
                        <?php }?>
                    </table>
                    <button type="submit" class="btn btn-success">reset</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>ยอดรวม Rp. <?=number_format($sum)?></h3>
                <form method="POST">
                    <input type="hidden" name="total" value="<?=$sum?>">
                    <div class="form-group">
                        <label>รหัสหมายเหตุ</label>
                        <input type="text" id="bayar" name="bayar" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">ตกลง</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    //inisialisasi inputan
    var bayar = document.getElementById('bayar');

    bayar.addEventListener('keyup', function(e) {
        bayar.value = formatRupiah(this.value, 'Rp. ');
        // harga = cleanRupiah(dengan_rupiah.value);
        // calculate(harga,service.value);
    });

    //generate dari inputan angka menjadi format rupiah

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    //generate dari inputan rupiah menjadi angka

    function cleanRupiah(rupiah) {
        var clean = rupiah.replace(/\D/g, '');
        return clean;
        // console.log(clean);
    }
    </script>
</body>