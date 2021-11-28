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

        <!-- page content -->
        <div class="right_col" role="main"> <!-- Mulai Konten -->
					<div class="">
						<div class="row top_tiles">
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
							<div class="count"><?= $allCustomers ?></div>
							<h3>Total Pelanggan</h3>
							<p>Menampilkan seluruh pelanggan.</p>
							</div>
						</div>
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-comments-o"></i></div>
							<div class="count"><?= $bulanCustomers ?></div>
							<h3>Bulan Ini</h3>
							<p>Menampilkan jumlah pelanggan baru pada bulan ini.</p>
							</div>
						</div>
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
							<div class="count"><?= $hariCustomers ?></div>
							<h3>Hari Ini</h3>
							<p>Menampilkan jumlah pelanggan baru pada hari ini.</p>
							</div>
						</div>
						</div>
						<?php if ($this->session->flashdata('message')) : ?>
							<?= $this->session->flashdata('message'); ?>
						<?php endif; ?>
            <div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel">
										<div class="x_title">
											<h2>Data Pelanggan</h2>
											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
												</li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<p class="text-muted font-13 m-b-30">
											Menampilkan seluruh data pelanggan pada <?= APP_NAME ?>.
											</p>
											<table id="data-pelanggan" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-keytable_info" style="position: relative;">
												<thead>
													<tr>
														<th style="width:5%;">ID</th>
														<th>Name</th>
														<th>Email</th>
														<th>Rating</th>
														
														<th>Provinsi</th>
														<!--<th>Kabupaten</th>-->
														<th>Tannggal Lahir</th>
														<th class="text-center" style="width:8%;">Active</th>
														<th class="text-center">Waktu Mendaftar</th>
														<th class="text-center">Actions</th>
													</tr>
												</thead>

												<tbody>
												<?php
												foreach ($customers as $key) :  ?>
													<tr>
														<td><?= $key['id_user'] ?></td>
														<td><?= $key['nama'] ?></td>
														
														<td><?= $key['email'] ?></td>
														<td><?= $key['sumScore'] ?></td>
														<td><?= $key['provinsi'] ?></td>
														<!--<td><?= $key['kabupaten'] ?></td>-->
														<td><?= $key['birthDate'] ?></td>
														<td class="text-center"><?= ($key['is_active'] == 1)? '<span class="label label-info">Aktif</span>' : '<span class="label label-warning">Tidak Aktif</span>' ; ?></td>
														<td class="text-center"><?= date('d M Y h:i', $key['create_date']) ?></td>
														<td class="text-center">
														<a role="menuitem" tabindex="-1" href="#" onclick="set_url('<?= site_url('dashboard/admin/delete_customers/' . encrypt_url($key['id_user']))  ?>')" 
															id="btnHapus" data-toggle="modal" data-target="#kt_modal_1">Hapus Pelanggan</a>
														
														<?php if($key['is_active'] == 1): ?>
															|
														<a role="menuitem" tabindex="-1" href="#" onclick="set_url1('<?= site_url('dashboard/admin/nonaktif_customers/' . encrypt_url($key['id_user']))  ?>')" 
															id="btnNonaktif" data-toggle="modal" data-target="#kt_modal_2">Nonaktifkan Pelanggan</a>
														<?php else: ?>
															|
														<a role="menuitem" tabindex="-1" href="#" onclick="set_url2('<?= site_url('dashboard/admin/aktifkan_customers/' . encrypt_url($key['id_user']))  ?>')" 
															id="btnAktif" data-toggle="modal" data-target="#kt_modal_3">Kirim Email Pengaktifan</a>
														<?php endif; ?>
														</td>
													</tr>
												<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
						</div>
					</div>
        </div> <!-- Selesai Konten -->
        <!-- /page content -->
				<!--begin::Modal-->
				<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								</button>
							</div>
							<div class="modal-body">
								<p>Anda yakin ingin menghapus data Pelanggan ini?</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
								<a class="fixHapus"><button class="btn btn-danger" type="button">Hapus</button></a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								</button>
							</div>
							<div class="modal-body">
								<p>Anda yakin ingin mengnonaktifkan Pelanggan ini?</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
								<a class="fixNonaktif"><button class="btn btn-danger" type="button">Nonaktifkan</button></a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								</button>
							</div>
							<div class="modal-body">
								<p>Anda yakin ingin mengirim email pengaktifan Pelanggan ini?</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
								<a class="fixAktif"><button class="btn btn-danger" type="button">Kirim</button></a>
							</div>
						</div>
					</div>
				</div>
				<!--end::Modal-->
        <!-- footer content -->
        <?php $this->load->view('admin/_partials/admin_footer'); ?>
        <!-- /footer content -->
      </div>
	</div>
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
			$('#data-pelanggan').DataTable( {
				dom: 'Bfrtip',
				buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
									columns: [ 0, 1, 2, 4, 5, 6, 7 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
									columns: [ 0, 1, 2, 4, 5, 6, 7 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 4, 5, 6, 7 ]
                }
            },
        ]
			});
			function set_url(url) {
				$('.fixHapus').attr('href', url);
			}
			function set_url1(url) {
				$('.fixNonaktif').attr('href', url);
			}
			function set_url2(url) {
				$('.fixAktif').attr('href', url);
			}
		</script>
  </body>
</html>
