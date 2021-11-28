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

					<div class="page-title">
						<div class="title_left">
							<h3>Detail Pesan : <strong><?= $pesan['pesan_html_title'] ?></strong></h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" hidden placeholder="Search for...">
									<span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
								</div>
							</div>
						</div>
					</div>
						<div class="">
							<div class="row top_tiles">
								<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="tile-stats">
										<div class="icon"><i class="fa fa-users"></i></div>
										<div class="count"><?= (empty($statistikPesan['jmlPenerima']) OR ($statistikPesan['jmlPenerima'] == '0.0000'))
												? 0 : $statistikPesan['jmlPenerima'] ?></div>
										<h3>Total Penerima</h3>
										<p>Jumlah penerima pesan.</p>
									</div>
								</div>
								<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="tile-stats">
<!--										<div class="icon"><i class="fa fa-comments-o"></i></div>-->
										<div class="count"><?= (empty($statistikPesan['sumDelivered']) OR ($statistikPesan['sumDelivered'] == '0.0000'))
												? 0 : $statistikPesan['sumDelivered'] ?> %</div>
										<h3>Total Terkirim</h3>
										<p>Jumlah pesan terkirim.</p>
									</div>
								</div>
								<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="tile-stats">
<!--										<div class="icon"><i class="fa fa-percent"></i></div>-->
										<div class="count"><?= (empty($statistikPesan['sumOpened']) OR ($statistikPesan['sumOpened'] == '0.0000'))
												? 0 : $statistikPesan['sumOpened'] ?> %</div>
										<h3>Total Dibuka</h3>
										<p>Jumlah pesan dibuka.</p>
									</div>
								</div>
								<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="tile-stats">
<!--										<div class="icon"><i class="fa fa-check-square-o"></i></div>-->
										<div class="count"><?= (empty($statistikPesan['sumClicked']) OR ($statistikPesan['sumClicked'] == '0.0000'))
												? 0 : $statistikPesan['sumClicked'] ?> %</div>
										<h3>Total Dikunjungi</h3>
										<p>Jumlah link dikunjungi.</p>
									</div>
								</div>
							</div>

						</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div id="addUserToList"></div>
            <div id="importaddUserToList"></div>
            <div class="panel panel-green">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-keytable_info" style="position: relative;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama User</th>
                                    <th>Email User</th>
                                    <th class="text-center">Pesan Terkirim</th>
                                    <th class="text-center">Pesan Dibuka</th>
                                    <th class="text-center">Link Dikunjungi</th>
                                    <th class="text-center">Pesan Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPesan as $DP) { ?>
                                    <tr>
                                        <td><?= $DP['pesan_data_user_id'];?></td>
                                        <td><?= $DP['nama'];?></td>
                                        <td><?= $DP['email'];?></td>
                                        <td class="text-center"><?= $DP['pesan_delivered'];?></td>
                                        <td class="text-center"><?= $DP['pesan_opened'];?></td>
                                        <td class="text-center"><?= $DP['pesan_clicked'];?></td>
                                        <td class="text-center"><?= $DP['pesan_data_user_created_at'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
					<!--end::Modal-->
					<!-- footer content -->
			</div>				</div>
			</div>
					<?php $this->load->view('admin/_partials/admin_footer'); ?>
					<!-- /footer content -->



<!--bot-->



	<?php $this->load->view('admin/_partials/admin_js') ?>
	<!-- Datatables -->
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	<script>
$('#data').DataTable();
</script>
  </body>
</html>
