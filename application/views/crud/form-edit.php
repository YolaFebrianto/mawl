<script>
function cal() {
    var txtFirstNumberValue = document.getElementById('pukul').value;

    var result = fromTime(txtFirstNumberValue);

    if (!isNaN(result)) {
        document.getElementById('pukul').value = toTime(result);
    }
}

function fromTime(time) {
    var timeArray = time.split(':');
    var hours = parseInt(timeArray[0]);
    var minutes = parseInt(timeArray[1]);

    return (hours * 60) + minutes;
}

function toTime(number) {
    var hours = Math.floor(number / 60);
    if(hours<10) {
        hours = "0"+hours;
    }
    var minutes = number % 60;

    return hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
}
</script>
<?= form_open_multipart('user/edit'); ?>
	<input type="hidden" name="id" value="<?=$edit['id'];?>">
	<div class="form-group">
		<label>Judul :</label>
		<input type="text" name="judul" class="form-control" value="<?=$edit['judul'];?>" required>	
	</div>
	<div class="form-group">
		<label>Season :</label>
		<select name="season" class="form-control" required>
			<option value="0" <?= ($edit['season']==0)?'selected':''; ?> disabled>-- Pilih --</option>
			<option value="1" <?= ($edit['season']==1)?'selected':''; ?>>Winter</option>
			<option value="2" <?= ($edit['season']==2)?'selected':''; ?>>Spring</option>
			<option value="3" <?= ($edit['season']==3)?'selected':''; ?>>Summer</option>
			<option value="4" <?= ($edit['season']==4)?'selected':''; ?>>Fall</option>
		</select>
	</div>
	<div class="form-group">
		<label>Tahun :</label>
		<input type="number" name="tahun" class="form-control" min="1000" max="9999" value="<?=$edit['tahun'];?>" required>	
	</div>
	<div class="form-group">
		<?php if (!empty($edit['foto'])) { ?>
		<a href="<?=$edit['foto'];?>" target="_blank">
			<img src="<?=$edit['foto'];?>" style="max-width: 150px;max-height: 150px;" class="img-thumbnail">
		</a>
		<?php } ?>
	</div>
	<div class="form-group">
		<label>Foto :</label>
		<textarea name="foto" class="form-control"><?=$edit['foto'];?></textarea>	
	</div>
	<div class="form-group">
		<label>Eps Dilihat :</label>
		<input type="number" name="last_view_eps" class="form-control" min="0" max="9999" value="<?=$edit['last_view_eps'];?>" required>	
	</div>
	<div class="form-group">
		<label>Eps Total :</label>
		<input type="number" name="total_eps" class="form-control" min="0" max="9999" value="<?=$edit['total_eps'];?>" required>	
	</div>
	<div class="form-group">
		<label>Platform :</label>
		<select name="platform" class="form-control" required="">
			<option value="Lainnya" selected disabled>-- Pilih --</option>
			<option value="Muse (Youtube)" <?= ($edit['platform']=='Muse (Youtube)')?'selected':''; ?>>Muse (Youtube)</option>
			<option value="Ani-One (Youtube)" <?= ($edit['platform']=='Ani-One (Youtube)')?'selected':''; ?>>Ani-One (Youtube)</option>
			<option value="iQIYI" <?= ($edit['platform']=='iQIYI')?'selected':''; ?>>iQIYI</option>
			<option value="Bilibili" <?= ($edit['platform']=='Bilibili')?'selected':''; ?>>Bilibili</option>
			<option value="Neonime" <?= ($edit['platform']=='Neonime')?'selected':''; ?>>Neonime</option>
			<option value="Lainnya" <?= ($edit['platform']=='Lainnya')?'selected':''; ?>>Lainnya</option>
		</select>	
	</div>
	<div class="form-group">
		<label>Status :</label>
		<select name="status" class="form-control" required>
			<option value="" selected disabled>-- Pilih --</option>
			<option value="0" <?= ($edit['status']==0)?'selected':''; ?>>Schedule</option>
			<option value="1" <?= ($edit['status']==1)?'selected':''; ?>>Ongoing</option>
			<option value="2" <?= ($edit['status']==2)?'selected':''; ?>>Finished</option>
		</select>
	</div>
	<div class="form-group">
		<label>Hari :</label>
		<select name="hari" class="form-control" required>
			<option value="0" <?= ($edit['hari']==0)?'selected':''; ?>>Tanpa Jadwal</option>
			<option value="1" <?= ($edit['hari']==1)?'selected':''; ?>>Senin</option>
			<option value="2" <?= ($edit['hari']==2)?'selected':''; ?>>Selasa</option>
			<option value="3" <?= ($edit['hari']==3)?'selected':''; ?>>Rabu</option>
			<option value="4" <?= ($edit['hari']==4)?'selected':''; ?>>Kamis</option>
			<option value="5" <?= ($edit['hari']==5)?'selected':''; ?>>Jumat</option>
			<option value="6" <?= ($edit['hari']==6)?'selected':''; ?>>Sabtu</option>
			<option value="7" <?= ($edit['hari']==7)?'selected':''; ?>>Minggu</option>
		</select>
	</div>
    <div class="form-group">
        <label>Pukul</label>
		<input class="form-control input-sm" type="time" name="pukul" placeholder="Pukul" required id="pukul" onchange="cal()" value="<?=$edit['pukul'];?>" />
	</div>
	<div class="form-group">
		<label>Catatan :</label>
		<textarea name="catatan" class="form-control" required><?=$edit['catatan'];?></textarea>
	</div>	
	<input type="submit" name="update" value="Submit" class="btn btn-primary">
<?= form_close(); ?>