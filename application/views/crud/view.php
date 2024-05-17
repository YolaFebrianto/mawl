<h1>Detail #<?=@$data['id'];?></h1>
<?php if (!empty($data['foto'])) { ?>
	<td>
		<a href="<?php echo $data['foto']; ?>" target="_blank">
			<img src="<?=$data['foto'];?>" style="max-height:150px;max-width:150px;" class="img-thumbnail">
		</a>
	</td>
<?php } ?>
<table class="table table-bordered table-striped">
<?php
	$kolomJudul = array('Judul','Season','Tahun','Status','Eps Dilihat','Eps Total','Platform','Catatan','Hari Rilis','Jam Rilis','User ID','Created At','Updated At');

	// SEASON / MUSIM
	if ($data['season']==1) {
		$season = "Winter";
	} else if ($data['season']==2) {
		$season = "Spring";
	} else if ($data['season']==3) {
		$season = "Summer";
	} else if ($data['season']==4) {
		$season = "Fall";
	} else { $season = "-"; }
	// STATUS
	if ($data['status']==0) {
		$status = "SCHEDULE";
	} else if ($data['status']==1) {
		$status = "ONGOING";
	} else if ($data['status']==2) {
		$status = "FINISHED";
	} else { $status = "-"; }
	// USER ID
	$username='';
	if (!empty($data['user_id'])) {
		$user = $this->db->get_where('tbluser',['id'=>$data['user_id']])->row_array();
		$username = @$user['username'];
	}
	$hariArray = ['Tanpa Jadwal','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
	$kolomData = array($data['judul'],$season,$data['tahun'],$status,$data['last_view_eps'],$data['total_eps'],$data['platform'],$data['catatan'],$hariArray[$data['hari']],$data['pukul'],$username,$data['created_at'],$data['updated_at']);
	for ($i=0; $i < count($kolomJudul); $i++) {
?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $kolomJudul[$i]; ?></td>
		<td>: <?php echo @$kolomData[$i]; ?></td>
	</tr>
<?php
	}
?>
</table>