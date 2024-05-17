<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MyAnimeWatchList</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?=base_url();?>template/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url();?>template/bootstrap/css/font-awesome.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url();?>template/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=base_url();?>template/dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
	<header class="main-header">
		<!-- Logo -->
		<a href="<?php echo base_url(); ?>" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b><?php echo @$event_name['nama3']; ?></b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b><?php echo @$event_name['nama']; ?></b></span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li>
						<a href="#"><?php echo @$event_name['nama2']; ?></a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?=base_url();?>template/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>ALL MATCHES</p>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li <?php echo($this->uri->segment(1)=='pildun'&&($this->uri->segment(2)=='index' OR $this->uri->segment(2)==''))?'class="active"':'';?>>
					<a href="<?php echo base_url('pildun/index'); ?>">
						<i class="fa fa-calendar"></i> <span>ALL MATCHES</span>
					</a>
				</li>
				<li <?php echo($this->uri->segment(1)=='pildun'&&$this->uri->segment(2)=='grup')?'class="active"':'';?>>
					<a href="<?php echo base_url('pildun/grup'); ?>">
						<i class="fa fa-folder"></i> <span>GROUP STAGES</span>
					</a>
				</li>
				<li <?php echo($this->uri->segment(1)=='pildun'&&$this->uri->segment(2)=='rekap')?'class="active"':'';?>>
					<a href="<?php echo base_url('pildun/rekap'); ?>">
						<i class="fa fa-list"></i> <span>GENERAL RANK.</span>
					</a>
				</li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>
	<div class="content-wrapper">
		<!-- <section class="content"> -->
		<section class="content-header">
			<h1>
				<?php echo @$event_name['nama'].' '.@$event_name['nama2']; ?> (INSERT MATCH RESULT)
				<div style="float:right;">
					<!-- <a href="<?php//base_url('user/printExcel');?>" class="btn btn-sm btn-success">
						<i class="fa fa-print"></i> Excel
					</a> -->
				</div>
				<div style="clear:both"></div>
			</h1>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-body" style="overflow-x:scroll;">
					<h4>INSERT MATCH RESULT FORM</h4>
					<?= form_open('pildun/insert'); ?>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Negara1 :</label>
									<select name="negara1" class="form-control" required>
										<?php foreach ($alln as $k => $v) : ?>
										<option value="<?php echo $v->kode; ?>"><?php echo $v->negara; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Skor1 :</label>
									<input type="number" min="0" name="skor1" class="form-control" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Skor2 :</label>
									<input type="number" min="0" name="skor2" class="form-control" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Negara2 :</label>
									<select name="negara2" class="form-control" required>
										<?php foreach ($alln as $k => $v) : ?>
										<option value="<?php echo $v->kode; ?>"><?php echo $v->negara; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Babak :</label>
									<input type="text" name="babak" class="form-control" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tanggal :</label>
									<input type="date" name="tanggal" class="form-control" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Keterangan :</label>
									<textarea name="keterangan" class="form-control">-</textarea>
								</div>
							</div>
						</div>
						<input type="submit" name="tambah" value="Insert" class="btn btn-primary">
					<?= form_close(); ?>
				</div>
			</div>
		</section>
		<!-- </section> -->
	</div>

	<!-- jQuery 2.2.3 -->
	<script src="<?=base_url();?>template/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?=base_url();?>template/bootstrap/js/bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="<?=base_url();?>template/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?=base_url();?>template/plugins/fastclick/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="<?=base_url();?>template/dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?=base_url();?>template/dist/js/demo.js"></script>
	<!-- DataTables -->
	<script src="<?=base_url();?>template/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=base_url();?>template/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script>
		$('#dtTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": false,
			"info": true,
			"autoWidth": true,
		});
	</script>
	<script type="text/javascript">
		$('#add').on('click',function(){
			$.ajax({
				'url': "<?=base_url().'user/form-add'; ?>",
				'method': 'post',
				'data': 'id_kategori=<?=$id_kategori;?>',
				'success': function(data){
					$('.box-body').html(data);
					$('#add').css('display','none');
					$('#cancel').css('display','inline-block');
				}
			});
		});
		function edit(id){
			$.ajax({
				'url': "<?=base_url().'user/form-edit'; ?>",
				'method': 'post',
				'data': 'id='+id,
				'success': function(data){
					$('.box-body').html(data);
					$('#add').css('display','none');
					$('#cancel').css('display','inline-block');
				}
			});
		}
		function nextEps(id){
			$.ajax({
				'url': "<?=base_url('user/nextEps');?>",
				'method': 'post',
				'data': 'id='+id,
				'success': function(data){
					$('#lastEps-'+id).html(data);
				}
			});
		}
		function view(id){
			$.ajax({
				'url': "<?=base_url().'user/view'; ?>",
				'method': 'post',
				'data': 'id='+id,
				'success': function(data){
					$('.box-body').html(data);
					$('#cancel').html('<i class="fa fa-times"></i> Kembali');
					$('#cancel').css('display','inline-block');
				}
			});
		}
		$('#navbar-search-input').on('keyup',function(){
			$.ajax({
				'url': "<?=base_url().'user/cari'; ?>",
				'method': 'post',
				'data': 'cari='+$(this).val(),
				'success': function(data){
					$('tbody').html(data);
					$('center').css('display','none');
				}
			});
		});
	</script>
</body>
</html>