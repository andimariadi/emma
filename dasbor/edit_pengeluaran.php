<?php
if (!isset($_SESSION['masuk'])) {
include "periksa.php";}
include "kon_db.php";
if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
?>
<div class ="entry">
<h1 align="center">Edit Pengeluaran</h1>
<br />
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<?php
$sqli = mysqli_query($koneksi, "SELECT * FROM `t_pengeluaran` WHERE `id_table`='$id'");
foreach ($sqli as $values): ?>

	<table align="center">
		<tr>
			<td align="left">Kode Pegawai</td>
			<td><select name="kd_pgwai">
			<?php
			$sql = mysqli_query($koneksi, "SELECT * FROM `t_pegawai` ORDER BY `id_pegawai` ASC");
			foreach ($sql as $value) {
				if ($value['id_pegawai'] == $values['id_pegawai']) {
					echo '<option value="' . $value['id_pegawai'] . '" selected> ' . $value['id_pegawai'] . ' / ' . $value['nama'] . '</option>';
				} else {
					echo '<option value="' . $value['id_pegawai'] . '"> ' . $value['id_pegawai'] . ' / ' . $value['nama'] . '</option>';
				}
				
			}
			?></select>
			</td>
		</tr>
		<tr>
			<td align="left">Keterangan</td>
			<td><textarea rows="3" cols="40" name="ket" placeholder="Keterangan belanja"><?php echo $values['keterangan'];?></textarea></td>
		</tr>
		<tr>
			<td align="left">Jumlah</td>
			<td>Rp. <input name="jumlah" type="number" align="right" value="<?php echo $values['jumlah'];?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="pr" type="submit" value="Submit"/></td>
		</tr>
	</table>
<?php endforeach;?>
</form>
</div>
<?php

if (isset($_POST['pr'])) {
	$kd=$_POST['kd_pgwai'];
	$ket=$_POST['ket'];
	$jumlah=$_POST['jumlah'];
	$query1= "UPDATE `t_pengeluaran` SET `kode_pegawai`='$kd',`keterangan`='$ket',`jumlah`='$jumlah' WHERE `id_table`='$id'";
	$sql= mysqli_query($koneksi, $query1);
	if ($sql) {
		?><script language="javascript">
			alert("Data Berhasil Diedit");
			document.location="coba_tampil.php?page=pengeluaran";
			</script><?php
	}else{
		?><script language="javascript">
			alert("Data Gagal Edit Data");
			document.location="coba_tampil.php?page=pengeluaran";
			</script><?php
		echo mysqli_error();
	}		
}else{
		unset($_POST['pr']);
}
} else {
	?><script language="javascript">
			alert("Periksa id yang dihapus");
			document.location="coba_tampil.php?page=pengeluaran";
			</script><?php
}
?>