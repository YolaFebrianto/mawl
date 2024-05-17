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
<?= form_open_multipart('user/add'); ?>
	<div class="form-group">
		<label>Judul :</label>
		<input type="text" name="judul" class="form-control" required>	
	</div>
	<div class="form-group">
		<label>Season :</label>
		<select name="season" class="form-control" required>
			<option value="0" selected disabled>-- Pilih --</option>
			<option value="1">Winter</option>
			<option value="2">Spring</option>
			<option value="3">Summer</option>
			<option value="4">Fall</option>
		</select>
	</div>
	<div class="form-group">
		<label>Tahun :</label>
		<input type="number" name="tahun" class="form-control" min="1000" max="9999" value="<?=date('Y');?>" required>	
	</div>
	<div class="form-group">
		<label>Foto :</label>
		<textarea name="foto" class="form-control"></textarea>	
	</div>
	<div class="form-group">
		<label>Eps Dilihat :</label>
		<input type="number" name="last_view_eps" class="form-control" min="0" max="9999" value="0" required>	
	</div>
	<div class="form-group">
		<label>Eps Total :</label>
		<input type="number" name="total_eps" class="form-control" min="0" max="9999" value="0" required>	
	</div>
	<div class="form-group">
		<label>Platform :</label>
		<select name="platform" class="form-control" required="">
			<option value="Lainnya" selected disabled>-- Pilih --</option>
			<option value="Muse (Youtube)">Muse (Youtube)</option>
			<option value="Ani-One (Youtube)">Ani-One (Youtube)</option>
			<option value="iQIYI">iQIYI</option>
			<option value="Bilibili">Bilibili</option>
			<option value="Neonime">Neonime</option>
			<option value="Lainnya">Lainnya</option>
		</select>	
	</div>
	<div class="form-group">
		<label>Status :</label>
		<select name="status" class="form-control" required>
			<option value="0" <?= ($id_kategori==0)?'selected':'';?>>Schedule</option>
			<option value="1" <?= ($id_kategori==1)?'selected':'';?>>Ongoing</option>
			<option value="2" <?= ($id_kategori==2)?'selected':'';?>>Finished</option>
		</select>
	</div>
	<div class="form-group">
		<label>Hari :</label>
		<select name="hari" class="form-control" required>
			<option value="0">Tanpa Jadwal</option>
			<option value="1">Senin</option>
			<option value="2">Selasa</option>
			<option value="3">Rabu</option>
			<option value="4">Kamis</option>
			<option value="5">Jumat</option>
			<option value="6">Sabtu</option>
			<option value="7">Minggu</option>
		</select>
	</div>
    <div class="form-group">
        <label>Pukul</label>
		<input class="form-control input-sm" type="time" name="pukul" placeholder="Pukul" required id="pukul" onchange="cal()" />
	</div>
	<div class="form-group">
		<label>Catatan :</label>
		<textarea name="catatan" class="form-control"></textarea>
	</div>
	<input type="submit" name="tambah" value="Submit" class="btn btn-primary">
<?= form_close(); ?>