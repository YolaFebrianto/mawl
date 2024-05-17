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
				<div style="float:right;">
					<a href="" class="btn btn-sm btn-info" id="cancel" style="display:none;">
						<i class="fa fa-times"></i> Batal
					</a>
					<button class="btn btn-sm btn-primary" id="add">
						<i class="fa fa-plus"></i> Tambah
					</button>
					<?php if (!empty($title) && $title=='Semua Anime'): ?>
					<a href="<?=base_url('user/printPDF');?>" class="btn btn-sm btn-warning">
						<i class="fa fa-print"></i> PDF
					</a>
					<?php endif; ?> 
					<!-- <a href="<?php//base_url('user/printExcel');?>" class="btn btn-sm btn-success">
						<i class="fa fa-print"></i> Excel
					</a> -->
					<?php
						$month=date('m');
						$season=0;
						if ($month>=1 && $month <=3) {
						    $season=1;
						} else if ($month>=4 && $month <=6) {
						    $season=2;
						} else if ($month>=7 && $month <=9) {
						    $season=3;
						} else if ($month>=10 && $month <=12) {
						    $season=4;
						}
    					$statusError=0;
    					foreach($isi as $crud){
    					    if ($crud->tahun==date('Y') && $crud->season==$season && $crud->status==0) {
    					        $statusError++;
    					    }
    					}
    					if($statusError>0){
    				?>
    				<a href="<?=base_url('user/updateStatus');?>" class="btn btn-sm btn-default">
						<i class="fa fa-refresh"></i> Update All Status
					</a>
					<?php
    					}
					?>
				</div>
				<div style="clear:both"></div>
			</h1>
			<a href="<?php echo base_url('pildun/insert_form'); ?>">Insert Hasil Pertandingan <?php echo @$event_name['nama'].'-'.@$event_name['nama2'];?></a>
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
					<table class="table table-bordered table-striped" id="dtTable">
						<thead>
							<tr>
								<th>No.</th>
								<th width="200px">Judul</th>
								<th>Foto</th>
								<th>Season</th>
								<th>Tahun</th>
								<?php if($id_kategori<0): ?>
								<th>Status</th>
								<?php elseif($id_kategori==1): ?>
								<th>Eps Dilihat</th>
								<th>Total Eps</th>
								<?php else: ?>
								<th>Total Eps</th>
								<?php endif; ?>
								<th>Platform</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$uri_1 = $this->uri->segment(1);
								if ($uri_1 != null && $uri_1 > 0) {
									$no = $uri_1+1;
								} else {
									$no = 1;
								}
								foreach($isi as $crud):
								    $bgcolor = 'transparent';
								    $bgcolor2 = 'transparent';
								    if ($crud->tahun==date('Y') && $crud->season==$season && $crud->status==0) {
								        $bgcolor = 'yellow';
								    }
								    if ($crud->total_eps>13){
								        $bgcolor2 = 'gray';
								    }
								?>
							<tr>
								<td><?=$no++;?></td>
								<td><?=$crud->judul;?></td>
								<td>
									<img src="<?=$crud->foto;?>" alt="<?=$crud->foto;?>" style="max-width: 150px;max-height: 150px;">
								</td>
								<td><p style="background-color:<?=$bgcolor;?>;"><?php
									if ($crud->season==1) {
										echo "Winter";
									} else if ($crud->season==2) {
										echo "Spring";
									} else if ($crud->season==3) {
										echo "Summer";
									} else if ($crud->season==4) {
										echo "Fall";
									} else { echo "-"; }
								?></p></td>
								<td><p style="background-color:<?=$bgcolor;?>;"><?=$crud->tahun;?></p></td>
								<?php if($id_kategori<0): ?>
								<td><p style="background-color:<?=$bgcolor;?>;"><?php
									if ($crud->status==0) {
										echo "SCHEDULE";
									} else if ($crud->status==1) {
										echo "ONGOING";
									} else if ($crud->status==2) {
										echo "FINISHED";
									} else { echo "-"; }
								?></p></td>
								<?php elseif($id_kategori==1): ?>
								<td><span id="lastEps-<?=$crud->id;?>"><?=$crud->last_view_eps; ?></span>
								    <button class="btn btn-sm btn-default" onclick="nextEps(<?=$crud->id;?>)">
										<i class="fa fa-angle-double-right"></i>
									</button>
								</td>
								<td><p style="background-color:<?=$bgcolor2;?>;"><?=$crud->total_eps; ?></p></td>
								<?php else: ?>
								<td><?=$crud->total_eps; ?></td>
								<?php endif; ?>
								<td><?=$crud->platform;?></td>
								<td>
									<!-- <a href="<?php //base_url('user/view/'.$crud->id);?>" class="btn btn-default">
										<i class="fa fa-eye"></i>
									</a> -->
									<button class="btn btn-default" onclick="view(<?=$crud->id;?>)">
										<i class="fa fa-eye"></i>
									</button>
									<button class="btn btn-info" onclick="edit(<?=$crud->id;?>)">
										<i class="fa fa-edit"></i>
									</button>
									<a href="<?=base_url('user/delete/'.$crud->id);?>" class="btn btn-danger">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
							</tr>
							<?php 
								endforeach;
							?>
						</tbody>
					</table>
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
	<?php if ($no-1 <= 10) : ?>
	<script>
		$('#dtTable').DataTable({
			"paging": false,
			"lengthChange": true,
			"searching": true,
			"ordering": false,
			"info": true,
			"autoWidth": true,
		});
	</script>
	<?php else: ?>
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
	<?php endif; ?>
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