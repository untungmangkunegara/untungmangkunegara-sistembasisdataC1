<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$idGTIN         = "";
$namaVaksin     = "";
$nomorBatch     = "";
$tglExpire      = "";
$serialNo       = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   $idGTIN        = $_GET['idGTIN'];
   $sql1       = "delete from vaksin where idGTIN = '$idGTIN'";
   $q1         = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil hapus data";
       $idGTIN         = "";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $idGTIN           = $_GET['idGTIN'];
   $sql1             = "select * from vaksin where idGTIN = '$idGTIN'";
   $q1               = mysqli_query($koneksi, $sql1);
   $r1               = mysqli_fetch_array($q1);
   $idGTIN           = $r1['idGTIN'];
   $namaVaksin       = $r1['namaVaksin'];
   $nomorBatch       = $r1['nomorBatch'];
   $tglExpire        = $r1['tglExpire'];
   $serialNo         = $r1['serialNo'];

   if ($idGTIN == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $idGTIN            = $_POST['idGTIN'];
   $namaVaksin        = $_POST['namaVaksin'];
   $nomorBatch        = $_POST['nomorBatch'];
   $tglExpire         = $_POST['tglExpire'];
   $serialNo          = $_POST['serialNo'];

   if ($idGTIN && $namaVaksin && $nomorBatch && $tglExpire && $serialNo) {
      if ($op == 'edit') { //Update
         $sql1    = "update vaksin set idGTIN = '$idGTIN', namaVaksin = '$namaVaksin', nomorBatch ='$nomorBatch', tglExpire = '$tglExpire', serialNo = '$serialNo' where idGTIN = '$idGTIN' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into vaksin (idGTIN,namaVaksin,nomorBatch,tglExpire,serialNo) values ('$idGTIN','$namaVaksin','$nomorBatch','$tglExpire','$serialNo')";
         $q1     = mysqli_query($koneksi, $sql1);
         if ($q1) {
             $sukses     = "Berhasil memasukkan data baru";
         } else {
             $error      = "Gagal memasukkan data";
         }
     }
 } else {
     $error = "Silakan masukkan semua data";
 }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FORM VAKSIN</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <style>
      .mx-auto {
         width: 800px
      }

      .card {
         margin-top: 30px;
      }
   </style>
</head>

<body>
   <div class="mx-auto">
   <a href=homescreen.php><button type="button" class="btn btn-primary">Home</button></a>
      <!-- Untuk Memasukan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Jenis Vaksin
         </div>
         <div class="card-body">
            <?php
            if ($error) {
            ?>
               <div class="alert alert-danger" role="alert">
                  <?php echo $error ?>
               </div>
            <?php
            }
            ?>
            <?php
            if ($sukses) {
            ?>
               <div class="alert alert-success" role="alert">
                  <?php echo $sukses ?>
               </div>
            <?php
            }
            ?>
            <form action="" method="POST">
               <div class="mb-3 row">
                  <label for="idGTIN" class="col-sm-2 col-form-label">ID GTIN</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="idGTIN" name="idGTIN" value="<?php echo $idGTIN ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="namaVaksin" class="col-sm-2 col-form-label">Nama Vaksin</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="namaVaksin" name="namaVaksin" value="<?php echo $namaVaksin ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="nomorBatch" class="col-sm-2 col-form-label">Nomor Batch</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="nomorBatch" name="nomorBatch" value="<?php echo $nomorBatch ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="tglExpire" class="col-sm-2 col-form-label">Tanggal Expire</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" id="tglExpire" name="tglExpire" value="<?php echo $tglExpire ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="serialNo" class="col-sm-2 col-form-label">Nomor Serial</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="serialNo" name="serialNo" value="<?php echo $serialNo ?>">
                  </div>
               </div>
               <div class="col-12">
                  <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" </div>
            </form>
         </div>
      </div>

      <!-- Untuk Mengeluarkan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Data Vaksin
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">ID GTIN</th>
                     <th scope="col">Nama Vaksin</th>
                     <th scope="col">Nomor Batch</th>
                     <th scope="col">Tanggal Expire</th>
                     <th scope="col">Nomer Serial</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from vaksin";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $idGTIN         = $r2['idGTIN'];
                     $namaVaksin     = $r2['namaVaksin'];
                     $nomorBatch     = $r2['nomorBatch'];
                     $tglExpire      = $r2['tglExpire'];
                     $serialNo       = $r2['serialNo'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $idGTIN ?></td>
                        <td scopr="row"><?php echo $namaVaksin ?></td>
                        <td scopr="row"><?php echo $nomorBatch ?></td>
                        <td scopr="row"><?php echo $tglExpire ?></td>
                        <td scopr="row"><?php echo $serialNo ?></td>
                        <td scope="row">
                           <a href="vaksin.php?op=edit&idGTIN=<?php echo $idGTIN ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="vaksin.php?op=delete&idGTIN=<?php echo $idGTIN?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                     </tr>
                  <?php
                  }

                  ?>
               </tbody>
               </thead>
            </table>

         </div>
      </div>
   </div>
</body>

</html>