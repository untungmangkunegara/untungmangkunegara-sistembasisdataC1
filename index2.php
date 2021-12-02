<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$nik              = "";
$namaResipien     = "";
$nomerHPResipien  = "";
$tglLahir         = "";
$alamat           = "";
$sukses           = "";
$error            = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   $nik        = $_GET['nik'];
   $sql1       = "delete from resipien where nik = '$nik'";
   $q1         = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil hapus data";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $nik              = $_GET['nik'];
   $sql1             = "select * from resipien where nik = '$nik'";
   $q1               = mysqli_query($koneksi, $sql1);
   $r1               = mysqli_fetch_array($q1);
   $nik              = $r1['nik'];
   $namaResipien     = $r1['namaResipien'];
   $nomerHPResipien  = $r1['nomerHPResipien'];
   $tglLahir         = $r1['tglLahir'];
   $alamat           = $r1['alamat'];

   if ($nik == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $nik                 = $_POST['nik'];
   $namaResipien        = $_POST['namaResipien'];
   $nomerHPResipien     = $_POST['nomerHPResipien'];
   $tglLahir            = $_POST['tglLahir'];
   $alamat              = $_POST['alamat'];

   if ($nik && $namaResipien && $nomerHPResipien && $tglLahir && $alamat) {
      if ($op == 'edit') { //Update
         $sql1    = "update resipien set nik = '$nik', namaResipien = '$namaResipien', nomerHPResipien ='$nomerHPResipien', tglLahir = '$tglLahir', alamat = '$alamat' where nik = '$nik' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into resipien(nik,namaResipien,nomerHPResipien,tglLahir,alamat) values ('$nik','$namaResipien','$nomerHPResipien','$tglLahir','$alamat')";
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
   <title>FORM TABEL RESIPIEN</title>
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
            Identitas Diri
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
                  <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="namaResipien" class="col-sm-2 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="namaResipien" name="namaResipien" value="<?php echo $namaResipien ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="nomerHPResipien" class="col-sm-2 col-form-label">Nomor HP</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="nomerHPResipien" name="nomerHPResipien" value="<?php echo $nomerHPResipien ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" id="tglLahir" name="tglLahir" value="<?php echo $tglLahir ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
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
            Data Pasien
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">NIK</th>
                     <th scope="col">NAMA LENGKAP</th>
                     <th scope="col">NOMER HP</th>
                     <th scope="col">TANGGAL LAHIR</th>
                     <th scope="col">ALAMAT</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from resipien";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $nik              = $r2['nik'];
                     $namaResipien     = $r2['namaResipien'];
                     $nomerHPResipien  = $r2['nomerHPResipien'];
                     $tglLahir         = $r2['tglLahir'];
                     $alamat           = $r2['alamat'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $nik ?></td>
                        <td scopr="row"><?php echo $namaResipien ?></td>
                        <td scopr="row"><?php echo $nomerHPResipien ?></td>
                        <td scopr="row"><?php echo $tglLahir ?></td>
                        <td scopr="row"><?php echo $alamat ?></td>
                        <td scope="row">
                           <a href="index2.php?op=edit&nik=<?php echo $nik ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="index2.php?op=delete&nik=<?php echo $nik?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
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