<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
//$idKabupaten         = "";
$namaKabupaten       = "";
$sukses              = "";
$error               = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   $idKabupaten    = $_GET['idKabupaten'];
   $sql1          = "delete from kabupaten where idKabupaten = '$idKabupaten'";
   $q1            = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses    = "Berhasil hapus data";
       //$idKabupaten   = "";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $idKabupaten         = $_GET['idKabupaten'];
   $sql1                = "select * from kabupaten where idKabupaten = '$idKabupaten'";
   $q1                  = mysqli_query($koneksi, $sql1);
   $r1                  = mysqli_fetch_array($q1);
   //$idKabupaten         = $r1['idKabupaten'];
   $namaKabupaten       = $r1['namaKabupaten'];

   if ($idKabupaten == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   //$idKabupaten          = $_POST['idKabupaten'];
   $namaKabupaten        = $_POST['namaKabupaten'];

   if ($namaKabupaten ) {
      if ($op == 'edit') { //Update
         $sql1    = "update kabupaten set namaKabupaten = '$namaKabupaten' where idKabupaten = '$idKabupaten' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into kabupaten (namaKabupaten) values ('$namaKabupaten')";
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
   <title>FORM KABUPATEN</title>
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
            Informasi Kabupaten
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
            <form action="" method="POST"> <!--
               <div class="mb-3 row">
                  <label for="idKabupaten" class="col-sm-2 col-form-label">ID Kabupaten</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="idKabupaten" name="idKabupaten" value="<?php echo $idKabupaten ?>">
                  </div>
               </div>   -->
               <div class="mb-3 row">
                  <label for="namaKabupaten" class="col-sm-2 col-form-label">Nama Kabupaten</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="namaKabupaten" name="namaKabupaten" value="<?php echo $namaKabupaten ?>">
                  </div>
               </div>
               <div class="col-12">
                  <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" 
               </div>
            </form>
         </div>
      </div>

      <!-- Untuk Mengeluarkan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Data Kabupaten
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">ID Kabupaten</th>
                     <th scope="col">Nama Kabupaten</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from kabupaten";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $idKabupaten       = $r2['idKabupaten'];
                     $namaKabupaten     = $r2['namaKabupaten'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $idKabupaten ?></td>
                        <td scopr="row"><?php echo $namaKabupaten ?></td>
                        <td scope="row">
                           <a href="kabupaten.php?op=edit&idKabupaten=<?php echo $idKabupaten ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="kabupaten.php?op=delete&idKabupaten=<?php echo $idKabupaten?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
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