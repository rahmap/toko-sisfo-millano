<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('admin/_partials/admin_header') ?>
	<!-- Datatables -->
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/gentelella/') ?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

	<!-- jQuery -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="<?= base_url('assets/gentelella/') ?>vendors/DateJS/build/date.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/moment/min/moment.min.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- include summernote css/js -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

</head>

<body class="nav-md">
<?php if ($this->session->flashdata('message')) : ?>
	<?= $this->session->flashdata('message'); ?>
<?php endif; ?>
<div class="container body">
	<div class="main_container">
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="<?= base_url('home') ?>" class="site_title"><i class="fa fa-shopping-basket"></i> <span> <?= APP_NAME ?></span></a>
				</div>

				<div class="clearfix"></div>

				<!-- menu profile quick info & nama toko -->
				<?php $this->load->view('admin/_partials/admin_pp') ?>
				<!-- /menu profile quick info & nama toko -->

				<br/>

				<!-- sidebar menu -->
				<?php $this->load->view('admin/_partials/admin_sidebar') ?>
				<!-- /sidebar menu -->

			</div>
		</div>
		<!-- top navigation -->
		<?php $this->load->view('admin/_partials/admin_topnav') ?>
		<!-- /top navigation -->

		<div class="right_col" role="main"> <!-- Mulai Konten -->

			<!--top-->


			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="panel panel-green">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-sm-offset-3 text-center">
										<div class="panel panel-default">
											<img class="img-responsive" src="<?= base_url('assets/email/example_product_2.JPG') ?>" alt="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Kirim Pesan Ke Semua Pelanggan</h3>
					<div class="row">
						<div class="panel panel-green">

							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-default">
											<form role="form" method="POST" accept-charset="UTF-8"
														action="<?= base_url('dashboard/pesan/all_kirim_pesan_template2/'.$this->uri->segment(5)) ?>">
												<div class="panel-body">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Judul Kecil</label>
																<input type="text" name="judulKecil" required maxlength="20" class="form-control">
															</div>
															<div class="form-group">
																<label>Judul Besar</label>
																<input type="text" name="judulBesar" maxlength="30" required class="form-control">
															</div>
															<div class="form-group">
																<label>Url Gambar 1</label>
																<input type="url" name="urlGambar" required class="form-control">
															</div>
															<div class="form-group">
																<label>Url Gambar 2</label>
																<input type="url" name="urlGambar1" required class="form-control">
															</div>
															<div class="form-group">
																<label>Judul Produk 1</label>
																<input type="text" name="judulProduk" maxlength="50" required class="form-control">
															</div>
															<div class="form-group">
																<label>Judul Produk 2</label>
																<input type="text" name="judulProduk1" maxlength="50" required class="form-control">
															</div>
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Tanggal</label>
																		<input type="date" disabled name="jadwalTanggal" id="jadwalTanggal" required class="form-control">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Jam</label>
																		<input type="time" disabled name="jadwalJam" id="jadwalJam" required class="form-control">
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Keterangan Produk 1</label>
																<input type="text" name="keteranganProduk" minlength="20" maxlength="300" required class="form-control">
															</div>
															<div class="form-group">
																<label>Keterangan Produk 2</label>
																<input type="text" name="keteranganProduk1" minlength="20" maxlength="300" required class="form-control">
															</div>
															<div class="form-group">
																<label>Url Produk 1</label>
																<input type="url" name="urlProduk" required class="form-control">
															</div>
															<div class="form-group">
																<label>Url Produk 2</label>
																<input type="url" name="urlProduk1" required class="form-control">
															</div>
															<div class="form-group">
																<label>Penjadwalan</label>
																<select class="form-control" required name="jadwal" id="jadwal">
																	<option value="sekarang" selected>Sekarang</option>
																	<option value="jadwal">Terjadwal</option>
																</select>
															</div>
															<div class="form-group">
																<label>Judul Email</label>
																<input type="text" maxlength="50" minlength="5" name="judulEmail" required class="form-control">
															</div>
														</div>
													</div>
												</div>

												<div class="panel-footer">
													<button type="reset" class="btn btn-default">Reset</button>
													<button type="submit" class="btn btn-success pull-right" value="Simpan">Kirim Pesan</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div></div>



	<!--bot-->
	<?php $this->load->view('admin/_partials/admin_footer'); ?>




	<!-- FastClick -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/nprogress/nprogress.js"></script>
	<!-- Chart.js -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Chart.js/dist/Chart.min.js"></script>
	<!-- jQuery Sparklines -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
	<!-- Flot -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Flot/jquery.flot.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Flot/jquery.flot.pie.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Flot/jquery.flot.time.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Flot/jquery.flot.stack.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/Flot/jquery.flot.resize.js"></script>
	<!-- Flot plugins -->
	<script src="<?= base_url('assets/gentelella/') ?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	<script src="<?= base_url('assets/gentelella/') ?>vendors/flot.curvedlines/curvedLines.js"></script>

	<script type="text/javascript">
		var site_url = "<?= base_url() ?>";
	</script>
	<!-- Custom Theme Scripts -->
	<script src="<?= base_url('assets/gentelella/') ?>build/js/custom.js"></script>

	<script>
		$(document).ready(function() {
			$('#jadwal').change(function (){
				if($(this).val() === 'sekarang'){
					$('#jadwalJam').prop('disabled', true)
					$('#jadwalTanggal').prop('disabled', true)
				} else {
					$('#jadwalJam').prop('disabled', false)
					$('#jadwalTanggal').prop('disabled', false)
				}
			})
		});
	</script>

</body>
</html>

