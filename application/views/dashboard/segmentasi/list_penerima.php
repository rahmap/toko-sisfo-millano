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

<!--top-->

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">List Penerima
        </h3>
        <div class="row">
            <div id="addUserToList"></div>
            <div id="importaddUserToList"></div>
            <div class="panel panel-green">
                <div class="panel-body">
							<div class="text-primary" style="margin-bottom:20px;">
								<h2>Segmentasi : <strong><?= $segmentasi['segmentasi_nama'] ?></strong></h2>
							</div>
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-keytable_info" style="position: relative;">
                            <thead>
                                <tr>
                                    <th>Nama user</th>
                                    <th>Email</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th class="text-center">Umur</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPenerima as $DP) { ?>
                                    <tr>
                                        <td><?= $DP['nama'];?></td>
                                        <td><?= $DP['email'];?></td>
                                        <td><?= $DP['provinsi'];?></td>
                                        <td><?= $DP['kabupaten'];?></td>
                                        <td class="text-center"><?= $DP['user_age'];?></td>
                                        <td class="text-center"><?= ($DP['gender'] == 'wanita')?
																						'<span class="badge bg-purple">Wanita</span>' :
																						'<span class="badge bg-red">Pria</span>'; ?></td>
                                        <td class="text-center"><?= $DP['sumScore'] + 0 ?></td>
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
