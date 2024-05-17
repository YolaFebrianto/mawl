<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Schedule MAWL</title>
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
			<span class="logo-mini"><b>MAWL</b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>MyAnime</b>WatchList</span>
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
						<a href="#"><?php echo @$user['username'];?></a>
					</li>
					<li>
						<a href="<?=base_url('user/logout');?>"><span class="fa fa-sign-out"></span> Logout</a>
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
					<p><?php echo @$user['username']; ?></p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li>
					<a href="<?php echo base_url('user/index'); ?>">
						<i class="fa fa-dashboard"></i> <span>HOME</span>
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('user/jadwal'); ?>">
						<i class="fa fa-calendar"></i> <span>RELEASE DAY</span>
					</a>
				</li>
				<li class="header">KATEGORI</li>
				<li <?php echo($this->uri->segment(2)=='kategori'&&$this->uri->segment(2)=='1')?'class="active"':'';?>>
					<a href="<?php echo base_url('user/kategori/1'); ?>">
						<i class="fa fa-spinner"></i> <span>ONGOING</span>
					</a>
				</li>
				<li <?php echo($this->uri->segment(2)=='kategori'&&$this->uri->segment(2)=='0')?'class="active"':'';?>>
					<a href="<?php echo base_url('user/kategori/0'); ?>">
						<i class="fa fa-calendar"></i> <span>SCHEDULE</span>
					</a>
				</li>
				<li <?php echo($this->uri->segment(2)=='kategori'&&$this->uri->segment(2)=='2')?'class="active"':'';?>>
					<a href="<?php echo base_url('user/kategori/2'); ?>">
						<i class="fa fa-check-circle"></i> <span>FINISHED</span>
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
				<?php
					if (!empty($title)) {
						echo $title;
					} else {
						echo "MyAnimeWatchList (".@$user['username'].")";
					}
				?>
				<div style="clear:both"></div>
			</h1>
		</section>

		<section class="content">
			<div class="box box-primary">
				<div class="box-body" style="overflow-x:scroll;">
					<?php if($this->session->flashdata('info') != null): ?>
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-info"></i> Alert!</h4>
						<?=$this->session->flashdata('info');?>
					</div>
					<?php endif; ?>	
					<?php if($this->session->flashdata('danger') != null): ?>
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						<?=$this->session->flashdata('danger');?>
					</div>
					<?php endif; ?>
					<?php
						$hariList = ['Tanpa Jadwal','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
					?>
					<div class="row">
						<?php for ($i=0; $i < count($hariList); $i++) { ?>
						<div class="col-md-6 col-sm-12">
							<h4><?php echo $hariList[$i]; ?></h4>
							<?php if(count($jadwal) > 0): ?>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="50px">Jam</th>
										<th>Anime</th>
										<th>Platform</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ($jadwal as $sk => $sv) {
										if ($sv->hari==$i) {
									?>
									<tr>
										<td width="50px"><?php echo $sv->pukul; ?></td>
										<td><?php echo $sv->judul; ?></td>
										<td><?php echo $sv->platform; ?></td>
									</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
							<?php else: ?>
							<p>Kosong</p>
							<?php endif; ?>
						</div>
						<?php } ?>
					</div>
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