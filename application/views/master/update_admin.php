<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('master/_partials/master_header') ?>
	<!-- Datatables -->
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
	<div class="main_container">
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="<?= base_url('home') ?>" class="site_title"><i class="fa fa-shopping-basket"></i> <span> <?= APP_NAME ?></span></a>
				</div>

				<div class="clearfix"></div>

				<!-- menu profile quick info & nama toko -->
				<?php $this->load->view('master/_partials/master_pp') ?>
				<!-- /menu profile quick info & nama toko -->

				<br/>

				<!-- sidebar menu -->
				<?php $this->load->view('master/_partials/master_sidebar') ?>
				<!-- /sidebar menu -->

			</div>
		</div>
		<!-- top navigation -->
		<?php $this->load->view('master/_partials/master_topnav') ?>
		<!-- /top navigation -->

		<!-- page content -->
		<?php if ($this->session->flashdata('message')) : ?>
			<?= $this->session->flashdata('message'); ?>
		<?php endif; ?>
		<div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3>Data Admin Toko</h3>
					</div>

					<div class="title_right">
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Form Update Admin </h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<?php if ($this->session->flashdata('messageForm')) : ?>
								<?= $this->session->flashdata('messageForm'); ?>
							<?php endif; ?>
							<div class="x_content">

								<!-- start form for validation -->
								<form method="POST" action="<?= base_url('dashboard/master/actionUpdateAdmin/'.$admin['id_user']) ?>">

									<div class="row">
										<div class='col-sm-6'>
											<label for="OldPassword">Nama Admin  :</label>
											<div class="form-group">
												<div class='input-group date' id='myDatepicker'>
													<input name="nama" required minlength="5"
																 value="<?= $admin['nama'] ?>" type="text" class="form-control" />
													<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
												</div>
												<?php echo form_error('nama', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>

										<div class='col-sm-6'>
											<label for="OldPassword">Email Admin  :</label>
											<div class="form-group">
												<div class='input-group date' id='myDatepicker2'>
													<input type="email" readonly name="email" value="<?= $admin['email'] ?>" class="form-control" />
													<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
												</div>
											</div>
										</div>

										<div class='col-sm-6'>
											<label for="OldPassword">Password :</label>
											<div class="form-group">
												<div class='input-group date' id='myDatepicker2'>
													<input type="text" minlength="8" placeholder="Kosongkan jika tidak ingin di ganti"
																 name="PasswordBaru" class="form-control <?php if(form_error('username')){echo 'has-error';} ?>" />
													<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
												</div>
												<?php echo form_error('PasswordBaru', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>

										<div class='col-sm-6'>
											<label for="OldPassword">Password Konfirmasi :</label>
											<div class="form-group">
												<div class='input-group date' id='myDatepicker2'>
													<input type="text" minlength="8" placeholder="Kosongkan jika tidak ingin di ganti"
																 name="fixPasswordBaru" class="form-control <?php if(form_error('username')){echo 'has-error';} ?>" />
													<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
												</div>
												<?php echo form_error('fixPasswordBaru', '<div class="text-danger">', '</div>'); ?>
											</div>
										</div>
										<div class="col-md-12 text-center">
											<button type="submit" name="submit" class="btn btn-primary">Update Data Admin</button>
										</div>
									</div>
								</form>
								<!-- end form for validations -->
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<!-- /page content -->
		<!-- footer content -->
		<?php $this->load->view('master/_partials/master_footer'); ?>
		<!-- /footer content -->
	</div>
</div>
<?php $this->load->view('master/_partials/master_js') ?>
<!-- Datatables -->
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/jszip/dist/jszip.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url('assets/gentelella/') ?>vendors/pdfmake/build/vfs_fonts.js"></script>
</body>
</html>
