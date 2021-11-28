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
<div class="">


<!--top-->
<div class="row">
<iframe name="dummy" id="dummy" style="display: none;"></iframe>
    <div class="col-lg-12">
        <h3 class="page-header">List Segment
            <a href="<?= base_url('dashboard/segmentasi/create_segment') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Segment</a>
        </h3>
        <div class="row">
            <div id="addUserToList"></div>
            <div id="importaddUserToList"></div>
            <div class="panel panel-green">
                <div class="panel-body mb-3">
									<div>
                    <a class="btn btn-sm btn-success" href=""
											 data-toggle="modal" data-target="#modalKirimAll">Kirim Ke Semua</a>
									</div>
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-keytable_info" style="position: relative;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Segmen</th>
                                    <th>Pilihan Segment</th>
                                    <th>Kategori Segmen</th>
                                    <th>Rumus Segmen</th>
                                    <th>Keterangan Segment</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($segmentasi as $segment): ?>
                                    <tr class="">
                                        <td><?= $segment['segmentasi_id'];?></td>
                                        <td><?= $segment['segmentasi_nama'];?></td>
                                        <td class="text-center"><?= ($segment['segmentasi_match'] == 'OR')? '<span class="badge bg-blue">OR</span>' : '<span class="badge bg-green">SEMUA</span>' ; ?></td>
                                        <td><?= $segment['segmentasi_kategori'];?></td>
                                        <td><?= $segment['segmentasi_rumus'];?></td>
                                        <td><?= $segment['segmentasi_keterangan'];?></td>
                                        <td class="text-center">
<!--																					--><?//= base_url() .'dashboard/segmentasi/kirim_pesan/'.$segment['segmentasi_id'];?>
																					<a class="btn btn-sm btn-primary btnKirimPesan" data-toggle="modal" data-target="#exampleModal" data-segmentasi="<?= $segment['segmentasi_id'] ?>"
																						 href="">Kirim Pesan</a>
																					<a class="btn btn-sm btn-info"
																						 href="<?= base_url() .'dashboard/segmentasi/lihat_penerima/'.$segment['segmentasi_id'];?>">Lihat Penerima</a>
																					<a class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Apakah anda yakin?')"
																						 href="<?= base_url() .'dashboard/segmentasi/delete_segment?id='.$segment['segmentasi_id']; ?>">
																						<i class="fa fa-trash"> Hapus Segmen</i></a>
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
</div>
</div>
</div>

	<?php $this->load->view('admin/_partials/admin_footer'); ?>

</div>
				</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Buat Pesan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-offset-3 text-center">
							<form action="">
							<div class="form-group row">
								<label class="control-label col-md-4 col-sm-2 col-xs-10">Pilih Template Pesan</label>
								<div class="col-md-8 col-sm-10 col-xs-10">
									<select class="form-control" id="jenisTemplate">
										<option value="produk0" selected data-href="<?= base_url('dashboard/segmentasi/kirim_pesan_manual/') ?>"
														data-img="#">Buat Manual</option>
										<option value="produk1" data-href="<?= base_url('dashboard/segmentasi/kirim_pesan_template/1/') ?>"
														data-img="<?= base_url('assets/email/example_product_1.PNG') ?>">Produk 1 Kolom</option>
										<option value="produk2" data-href="<?= base_url('dashboard/segmentasi/kirim_pesan_template/2/') ?>"
														data-img="<?= base_url('assets/email/example_product_2.JPG') ?>">Produk 2 Kolom</option>
													
									</select>
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-offset-3 text-center">
							<img class="img-fluid img-responsive center" id="imgExample" style="margin-top: 10px;" src="" alt="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<a href="" id="aHrefBuat">
						<button type="button" class="btn btn-primary" id="btnBuat">Buat Sekarang!</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalKirimAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Buat Pesan Ke Semua Pengguna</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-offset-3 text-center">
							<form action="">
							<div class="form-group row">
								<label class="control-label col-md-4 col-sm-2 col-xs-10">Pilih Template Pesan</label>
								<div class="col-md-8 col-sm-10 col-xs-10">
									<select class="form-control" id="jenisTemplateAll">
										<option value="produk0" selected data-href="<?= base_url('dashboard/segmentasi/all_kirim_pesan_manual') ?>"
														data-img="#">Buat Manual</option>
										<option value="produk1" data-href="<?= base_url('dashboard/segmentasi/all_kirim_pesan_template/1') ?>"
														data-img="<?= base_url('assets/email/example_product_1.PNG') ?>">Produk 1 Kolom</option>
										<option value="produk2" data-href="<?= base_url('dashboard/segmentasi/all_kirim_pesan_template/2') ?>"
														data-img="<?= base_url('assets/email/example_product_2.JPG') ?>">Produk 2 Kolom</option>
									
									</select>
								</div>
							</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-offset-3 text-center">
							<img class="img-fluid img-responsive center" id="imgExampleAll" style="margin-top: 10px;" src="" alt="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<a href="<?= base_url('dashboard/segmentasi/all_kirim_pesan_manual') ?>" id="aHrefBuatAll">
						<button type="button" class="btn btn-primary" id="btnBuat">Buat Sekarang!</button>
					</a>
				</div>
			</div>
		</div>
	</div>


<!--bot-->

	<?php $this->load->view('admin/_partials/admin_js') ?>
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
	<script>
		$(document).ready(function (){
			$idTabel = $('#data')
			$idTabel.DataTable();
			let id_segmentasi;
			$idTabel.on('click','.btnKirimPesan', function(){
				id_segmentasi = $(this).data('segmentasi');
				$('#aHrefBuat').attr('href', "<?= base_url('dashboard/segmentasi/kirim_pesan_manual/') ?>" + id_segmentasi)
			})
			$('#exampleModal').on('shown.bs.modal', function () {
				$('#jenisTemplate option:eq(0)').prop('selected', true);
			})
			$('#jenisTemplate').change(function(){
				$('#imgExample').attr('src', $(this).find(':selected').data('img'))
				$('#aHrefBuat').attr('href', $(this).find(':selected').data('href') + id_segmentasi)
			})
			$('#jenisTemplateAll').change(function(){
				$('#imgExampleAll').attr('src', $(this).find(':selected').data('img'))
				$('#aHrefBuatAll').attr('href', $(this).find(':selected').data('href'))
			})
		})
	</script>
  </body>
</html>
