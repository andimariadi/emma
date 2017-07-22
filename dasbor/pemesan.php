<?php
include "kon_db.php";
?>
<div class="content_bottom">
<h2 align="center">Data Pemesan</h2>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
	<table align="center">
		<tr>
			<td align="left">NIK (KTP)*</td>
			<td><input name="enik"  required maxlength="16" type="text" value="" size="16"/></td>
			<td></td>
			<td align="left">Nama*</td>
			<td><input name="enama"  required maxlength="25" type="text" value="" size="25"/></td>
		</tr>
		<tr>
			<td align="left">Jenis Kelamin*</td>
			<td><table border="0">
					<tr>
						<td><input name="jkel" type="radio" <?php if (isset($jkel) && $jkel=="Pria") echo "checked";?>value="Pria" required/></td>
						<td>Pria</td>
						<td><input type="radio" name="jkel" <?php if (isset($jkel) && $jkel=="Wanita") echo "checked";?>value="Wanita"/></td>
						<td>Wanita</td>
				</table>
			</td>
			<td></td>
			<td align="left">Status*</td>
			<td><select name="sstatus" required>
				<option></option>
				<option>Kawin</option>
				<option>Belum Kawin</option>
				<option>Janda</option>
				<option>Duda</option>
			</select></td>
		</tr>
		<tr>
			<td align="left">Tempat Lahir*</td>
			<td><input name="etp" required maxlength="15" type="text" value="" size="15"/></td>
			<td></td>
			<td align="left">Pekerjaan*</td>
			<td><select name="skerja" required>
				<option></option>
				<option>Wiraswasta</option>
				<option>PNS</option>
				<option>TNI/Polri</option>
				<option>Swasta</option>
				<option>Pedagang</option>
				<option>Belum Bekerja</option>
				<option>Lain-lain</option>
			</select></td>
		</tr>
		<tr>
			<td align="left">Tanggal Lahir*</td>
			<td><input name="tgl"  required maxlength="10" type="text" value="" size="10" id="datepicker"/></td>
			<td></td>
			<td align="left">Telepon*</td>
			<td><textarea name="etelp" cols="40" required rows="4"/></textarea></td>
		</tr>
		<tr>
			<td align="left">Alamat*</td>
			<td><textarea name="ealt" cols="40" required rows="7"/></textarea></td>
			<td></td>
			<td align="left">Foto Bukti Transfer*</td>
			<td><input name="file" type="file" required value="" size="30" accept="image/*"/></td>
		</tr>
		<tr>
			<td align="left">Kode Kavling*</td>
			<td><select name="kd_kavling"  required>
			<option selected="selected"></option>
			<?php 
			include "kon_db.php";
			$query4=mysqli_query($koneksi, "select * from t_kavling where status='0' order by kd_kavling");
			while($row=mysqli_fetch_array($query4))
			{
			?><option value="<?php  echo $row['kd_kavling']; ?>"><?php  echo $row['kd_kavling']; ?></option><?php 
			}
			?>
			</select></td>
		</tr>
		<tr>
			<td align="left" >Transfer Via*</td>
			<td><select name="bank" required>
				<option></option>
				<option>BRI</option>
				<option>BCA</option>
				<option>Mandiri</option>
				<option>BNI</option>
			</select></td>
		</tr>	
		<tr>
			<td></td>
			<td><input name="pr" type="submit" value="Submit"/></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="4">
			<ol type="1" start="1">
				<strong>
				Bank BRI No. Rek 748378927424 an Xyz<br>
				Bank BCA No. Rek 918374892374 an Xyz<br>
				Bank BNI No. Rek 748378927424 an Xyz<br>
				Bank Mandiri No. Rek 748378927424 an Xyz</strong><br><br>
				<li>Setelah Anda tranfer pembayaran uang muka, Anda bisa langsung menghubungi kami. Atau langsung<br>
					mendatangi kantor kami. Alamtanya bisa dilihat di menu <a href="?page=kontak" alt="kontak green madina ii" color="red"><strong>hubungi kami.</strong></a></li>
				<li>Dengan Anda mengububungi kami atau langsung datang ke kantor. Anda  bisa mengetahui informasi<br>
					lebih lanjut tentang rumah yang akan dibeli maupun pembayarannya.</li>
				<li>Jika dalam tempo 1 minggu Anda tidak mengonfirmasi pemesanan kavling pada kami. Maka kami<br>
					anggap Anda tidak jadi. Dan uang muka Anda kami potong 20%.</li>
			</td>
		</tr>
	</table>
</form>
</div>
<?php
function ubahformatTgl($tanggal) {
	$pisah = explode('/',$tanggal);
    $urutan = array($pisah[2],$pisah[0],$pisah[1]);
    $satukan = implode('-',$urutan);
    return $satukan;
}
if (isset($_POST['pr'])) {
	$nik=$_POST['enik'];
	$nama=$_POST['enama'];
	$jkel=$_POST['jkel'];
	$tp=$_POST['etp'];
	$tgl=$_POST['tgl'];
	$ubahtgl = ubahformatTgl($tgl);
	$alt=$_POST['ealt'];
	$status=$_POST['sstatus'];
	$kerja=$_POST['skerja'];
	$telp=$_POST['etelp'];
	$kd_kavling=$_POST['kd_kavling'];
	$bank=$_POST['bank'];
	$nama_file = $_FILES['file']['name'];
	$dir_unggah = "dasbor/foto/";
	$i=1;
	$query1=mysqli_query($koneksi, "select * from t_pemesan order by id_pemesan desc limit 0,1");
	$sql=mysqli_fetch_array($query1);
	$kodeawal=substr($sql['id_pemesan'],2,2)+1;	
	if ($kodeawal<10){
		$ip='P0'.$kodeawal;
	}else{
		$ip='P'.$kodeawal;
	}
	$cek = move_uploaded_file ($_FILES['file']['tmp_name'],$dir_unggah.$nama_file);
	if ($cek) {
		echo "Foto Berhasil Diunggah ";
	} else {
		echo "Foto Gagal Diunggah ";
	}
	$query2= "insert into t_pemesan values('$ip','$kd_kavling','$nama','$nik','$jkel','$tp','$ubahtgl','$alt','$status','$kerja','$telp','$bank','$nama_file','0','0')";
	$sql = mysqli_query ($query2);
	if ($sql) {
		?><script language="javascript">
			alert("Data Pemesan Berhasil Disimpan");
			document.location="?page=pemesan";
			</script><?php
		}else{
			?><script language="javascript">
			alert("Data Pemesan Gagal Disimpan");
			document.location="?page=pemesan";
			</script><?php
		echo mysqli_error(); 
	}
}else{
		unset($_POST['pr']);
}
?>