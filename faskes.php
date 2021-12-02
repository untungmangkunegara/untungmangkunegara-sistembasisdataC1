<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$namaFaskes             = "";
$alamatFaskes           = "";
$kabupaten              = "";
$sukses                 = "";
$error                  = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   
   $namaFaskes       = $_GET['namaFaskes'];
   $sql1             = "delete from faskes where namaFaskes = '$namaFaskes'";
   $q1               = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil hapus data";
       $namaFaskes             = "";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $namaFaskes             = $_GET['namaFaskes'];
   $sql1                   = "select * from faskes where namaFaskes = '$namaFaskes'";
   $q1                     = mysqli_query($koneksi, $sql1);
   $r1                     = mysqli_fetch_array($q1);
   $namaFaskes             = $r1['namaFaskes'];
   $alamatFaskes           = $r1['alamatFaskes'];
   $kabupaten              = $r1['kabupaten'];

   if ($namaFaskes == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $namaFaskes          = $_POST['namaFaskes'];
   $alamatFaskes        = $_POST['alamatFaskes'];
   $kabupaten           = $_POST['kabupaten'];

   if ($namaFaskes && $alamatFaskes && $kabupaten) {
      if ($op == 'edit') { //Update
         $sql1    = "update faskes set namaFaskes = '$namaFaskes', alamatFaskes = '$alamatFaskes', kabupaten ='$kabupaten' where namaFaskes = '$namaFaskes' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into faskes(namaFaskes,alamatFaskes,kabupaten) values ('$namaFaskes','$alamatFaskes','$kabupaten')";
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
   <title>FORM FASILLITAS KESEHATAN</title>
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
            Data Faskes
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
                  <label for="namaFaskes" class="col-sm-2 col-form-label">Fasilitas Kesehatan</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="namaFaskes" name="namaFaskes" value="<?php echo $namaFaskes ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="alamatFaskes" class="col-sm-2 col-form-label">Alamat Faskes</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="alamatFaskes" name="alamatFaskes" value="<?php echo $alamatFaskes ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="<?php echo $kabupaten ?>">
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
            Data Faskes
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">Fasilitas Kesehatan</th>
                     <th scope="col">Alamat Faskes</th>
                     <th scope="col">Kabupaten</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from faskes";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $namaFaskes       = $r2['namaFaskes'];
                     $alamatFaskes     = $r2['alamatFaskes'];
                     $kabupaten        = $r2['kabupaten'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $namaFaskes ?></td>
                        <td scopr="row"><?php echo $alamatFaskes ?></td>
                        <td scopr="row"><?php echo $kabupaten ?></td>
                        <td scope="row">
                           <a href="faskes.php?op=edit&namaFaskes=<?php echo $namaFaskes ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="faskes.php?op=delete&namaFaskes=<?php echo $namaFaskes?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
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