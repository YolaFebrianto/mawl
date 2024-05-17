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
			<span class="logo-mini"><b>OST</b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>Anime OST</b></span>
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
						<a href="#">Anime OST</a>
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
				<li>
					<a href="<?php echo base_url('welcome/index'); ?>">
						<i class="fa fa-calendar"></i> <span>NARUTO OST LISTS</span>
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
				NARUTO OST LISTS
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
					<div class="row">
						<div class="col-md-12">
							<h3>NARUTO OST LISTS</h3>
							<table class="table table-striped" id="dtTable">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Artis</th>
										<th>Urutan</th>
										<th>Jenis</th>
										<th>Anime</th>
										<th>URL + Lirik</th>
										<th>URL ORI</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($allm as $k => $v) { ?>
									<tr>
										<td width="50px"><?php echo $k+1; ?></td>
										<td width="110px"><?php echo $v->judul; ?></td>
										<td width="110px"><?php echo $v->artis; ?></td>
										<td width="5px"><?php echo $v->urutan; ?></td>
										<td width="15px"><?php echo $v->jenis; ?></td>
										<td width="110px"><?php echo $v->anime; ?></td>
										<td width="20px">
									    <?php
									        if(!empty($v->url)){
									            echo '<a href="'.$v->url.'">Link</a>';
									        }
									    ?>
										</td>
										<td width="20px">
									    <?php
									        if(!empty($v->url2)){
									            echo '<a href="'.$v->url2.'">Link</a>';
									        }
									    ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
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
		$('#dtTable').DataTable();
	</script>
	<script type="text/javascript">
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