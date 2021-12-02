<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$noTiket             = "";
$nik                 = "";
$idGTIN              = "";
$dosis               = "";
$tglPemberian        = "";
$tglDosisLanjutan    = "";
$idFaskes            = "";
$idNakes             = "";
$sukses              = "";
$error               = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   $noTiket        = $_GET['noTiket'];
   $sql1       = "DELETE FROM vaksinasi WHERE noTiket = '$noTiket'";
   $q1         = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil hapus data";
       $noTiket             = "";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $noTiket          = $_GET['noTiket'];
   $sql1             = "select * from vaksinasi where noTiket = '$noTiket'";
   $q1               = mysqli_query($koneksi, $sql1);
   $r1               = mysqli_fetch_array($q1);
   $noTiket          = $r1['noTiket'];
   $nik              = $r1['nik'];
   $idGTIN           = $r1['idGTIN'];
   $dosis            = $r1['dosis'];
   $tglPemberian     = $r1['tglPemberian'];
   $tglDosisLanjutan = $r1['tglDosisLanjutan'];
   $idFaskes         = $r1['idFaskes'];
   $idNakes          = $r1['idNakes'];

   if ($noTiket == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $noTiket             = $_POST['noTiket'];
   $nik                 = $_POST['nik'];
   $idGTIN              = $_POST['idGTIN'];
   $dosis               = $_POST['dosis'];
   $tglPemberian        = $_POST['tglPemberian'];
   $tglDosisLanjutan    = $_POST['tglDosisLanjutan'];
   $idFaskes            = $_POST['idFaskes'];
   $idNakes             = $_POST['idNakes'];

   if ($noTiket && $nik && $idGTIN && $dosis && $tglPemberian && $tglDosisLanjutan && $idFaskes && $idNakes) {
      if ($op == 'edit') { //Update
         $sql1    = "UPDATE vaksinasi SET noTiket = '$noTiket', nik = '$nik', idGTIN ='$idGTIN', dosis = '$dosis', tglPemberian = '$tglPemberian', tglDosisLanjutan = '$tglDosisLanjutan', idFaskes = '$idFaskes', idNakes ='$idNakes' WHERE noTiket = '$noTiket' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "INSERT INTO vaksinasi (noTiket,nik,idGTIN,dosis,tglPemberian,tglDosisLanjutan,idFaskes,idNakes) VALUES ('$noTiket','$nik','$idGTIN','$dosis','$tglPemberian','$tglDosisLanjutan','$idFaskes','$idNakes')";
         $sql2   = "UPDATE stokvaksin SET stok = stok-1 WHERE idGTIN = '$idGTIN' AND idKabupaten = (SELECT idKabupaten FROM stokvaksin WHERE idGTIN = $idGTIN ) ";

         $q1     = mysqli_query($koneksi, $sql1);
         
         //$sq2    = mysqli_query($koneksi, $sql2);

         if ($q1 ) {
             $sukses     = "Berhasil memasukkan data baru";
             $q2         = mysqli_query($koneksi, $sql2);

         } else {
            
             $error      = "Data gagal dimasukan";
         }
     }
 } else {
     $error = "Silahkan lengkapi data terlebih dahulu";
 }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>DATA VAKSINASI</title>
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
            Peserta Vaksinasi
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
                  <label for="noTiket" class="col-sm-2 col-form-label">No Tiket</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="noTiket" name="noTiket" value="<?php echo $noTiket ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="idGTIN" class="col-sm-2 col-form-label">ID GTIN</label>
                  <div class="col-sm-10">
                     <select name="idGTIN" name="namaVaksin" id%="idGTIN" id="namaVaksin" class="form-control" required>
                        <option value="">- Pilih ID GTIN (Vaksin) -</option>
                        <?php
                        $sql_idGTIN = mysqli_query($koneksi, "SELECT idGTIN,namaVaksin FROM vaksin") or die (mysqli_error($koneksi));
                        while($idGTIN = mysqli_fetch_array($sql_idGTIN)) {
                           echo '<option value ="'.$idGTIN ['idGTIN']. '" > '.$idGTIN['idGTIN'].' - '.$idGTIN ['namaVaksin']. '</option>';
                        } ?>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="dosis" class="col-sm-2 col-form-label">Dosis Ke</label>
                  <div class="col-sm-10">
                     <select class="form-control" id="dosis" name="dosis">
                        <option value="">- Pilih Dosis -</option>
                        <option value="1" <?php if ($dosis == "1") echo "selected" ?>>1</option>
                        <option value="2" <?php if ($dosis == "2") echo "selected" ?>>2</option>
                        <option value="3" <?php if ($dosis == "3") echo "selected" ?>>3</option>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="tglPemberian" class="col-sm-2 col-form-label">Tgl Pemberian</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" id="tglPemberian" name="tglPemberian" value="<?php echo $tglPemberian ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="tglDosisLanjutan" class="col-sm-2 col-form-label">Tgl Dosis Lanjutan</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" id="tglDosisLanjutan" name="tglDosisLanjutan" value="<?php echo $tglDosisLanjutan ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="idFaskes" class="col-sm-2 col-form-label">ID Faskes</label>
                  <div class="col-sm-10">
                     <select name="idFaskes" name="namaFaskes" id%="idFaskes" id="namaFaskes" class="form-control" required>
                        <option value="">- Pilih Faskes -</option>
                        <?php
                        $sql_idFaskes = mysqli_query($koneksi, "SELECT idFaskes, namaFaskes FROM faskes") or die (mysqli_error($koneksi));
                        while($idFaskes = mysqli_fetch_array($sql_idFaskes)) {
                           echo '<option value ="'.$idFaskes ['idFaskes']. '" > '.$idFaskes['idFaskes'].' - '.$idFaskes['namaFaskes']. '</option>';
                        } ?>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="idNakes" class="col-sm-2 col-form-label">ID Nakes</label>
                  <div class="col-sm-10">
                     <select name="idNakes" name="namaNakes" id%="idNakes" id="namaNakes" class="form-control" required>
                        <option value="">- Pilih Nakes -</option>
                        <?php
                        $sql_idNakes = mysqli_query($koneksi, "SELECT idNakes,namaNakes FROM nakes") or die (mysqli_error($koneksi));
                        while($idNakes = mysqli_fetch_array($sql_idNakes)) {
                           echo '<option value ="'.$idNakes ['idNakes']. '" > '.$idNakes['idNakes'].' - '.$idNakes ['namaNakes']. '</option>';
                        } ?>
                     </select>
                  </div>
               </div>
               <div class="col-12">
                  <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" </div>
               </div>
            </form>
         </div>
      </div>

      <!-- Untuk Mengeluarkan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Data Vaksinasi
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">No Tiket</th>
                     <th scope="col">NIK</th>
                     <th scope="col">ID GTIN</th>
                     <th scope="col">Dosis Ke</th>
                     <th scope="col">Tgl Pemberian</th>
                     <th scope="col">Tgl Dosis Lanjutan</th>
                     <th scope="col">ID Faskes</th>
                     <th scope="col">ID Nakes</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from vaksinasi";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $noTiket          = $r2['noTiket'];
                     $nik              = $r2['nik'];
                     $idGTIN           = $r2['idGTIN'];
                     $dosis            = $r2['dosis'];
                     $tglPemberian     = $r2['tglPemberian'];
                     $tglDosisLanjutan = $r2['tglDosisLanjutan'];
                     $idFaskes         = $r2['idFaskes'];
                     $idNakes          = $r2['idNakes'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $noTiket ?></td>
                        <td scopr="row"><?php echo $nik ?></td>
                        <td scopr="row"><?php echo $idGTIN ?></td>
                        <td scopr="row"><?php echo $dosis ?></td>
                        <td scopr="row"><?php echo $tglPemberian ?></td>
                        <td scopr="row"><?php echo $tglDosisLanjutan ?></td>
                        <td scopr="row"><?php echo $idFaskes ?></td>
                        <td scopr="row"><?php echo $idNakes ?></td>
                        <td scope="row">
                           <a href="vaksinasi.php?op=edit&noTiket=<?php echo $noTiket ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="vaksinasi.php?op=delete&noTiket=<?php echo $noTiket?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
                           <a href="view.php?op=edit&noTiket=<?php echo $noTiket ?>"><button type="button" class="btn btn-primary">View</button>
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