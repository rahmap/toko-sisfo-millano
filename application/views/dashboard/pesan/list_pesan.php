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

<!--top-->


<div class="row">
    <div class="col-lg-12">
			<h3 class="page-header">List Pesan
			</h3>
        <div class="row">
            <div id="addUserToList"></div>
            <div id="importaddUserToList"></div>
            <div class="panel panel-green">
            <div class="panel-body mb-3">
            <div>
                    <a class="btn btn-sm btn-success" href="<?= base_url('dashboard/admin/data_rating') ?>"
                                             >Daftar Rating</a>
                                    </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="dataTables-datasegment">
                            <thead>
                                <tr>
                                    <th>ID</th>
																		<th>Nama Pesan</th>
                                    <th class="text-center">Nama Segmentasi</th>
                                    <th class="text-center">Tipe Pesan</th>
                                    <th class="text-center">Dijadwalkan</th>
                                    <th class="text-center">Status Pesan</th>
                                    <th class="text-center">Total Penerima</th>
                                    <th>Pesan Terkirim</th>
                                    <th>Pesan Dibuka</th>
                                    <th>Link Dikunjungi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPesan as $DP) { ?>
                                    <tr>
                                        <td><?= $DP['pesan_html_id'];?></td>
                                        <td><?= $DP['pesan_html_title'];?></td>
                                        <td class="text-center">
																					<?php if(empty($DP['segmentasi_nama'])): ?>
																						<?php if($DP['has_segment'] == 0): ?>
																							<span class="label label-default label-as-badge">Kirim Ke Semua</span>
																						<?php else: ?>
																							<span class="label label-danger label-as-badge">Dihapus</span>
																						<?php endif; ?>
																					<?php else: ?>
																						<strong><a href="<?= base_url('dashboard/segmentasi/lihat_penerima/'. $DP['segmentasi_id']) ?>">
																								<?= $DP['segmentasi_nama'];?>
																						</a></strong>
																					<?php endif; ?>
																				</td>
                                        <td class="text-center">
																					<?php if($DP['pesan_html_type'] == 0): ?>
																							<span class="label label-default label-as-badge">Manual</span>
																					<?php elseif($DP['pesan_html_type'] == 1): ?>
																							<span class="label label-primary label-as-badge">Template 1 Produk</span>
																					<?php else: ?>
																							<span class="label label-warning label-as-badge">Template 2 Produk</span>
																					<?php endif; ?>
																				</td>
                                        <td class="text-center"><?= empty($DP['pesan_dijadwalkan_pada'])?
																						'<span class="label label-info label-as-badge">Langsung</span>' : $DP['pesan_dijadwalkan_pada'] ?>
																				</td>
                                        <td class="text-center">
																					<?= ($DP['pesan_dijadwalkan_status'] == 0)?
																						'<span class="label label-default label-as-badge">Belum Dikirim</span>' :
																						'<span class="label label-success label-as-badge">Terkirim</span>' ?>
																				</td>
                                        <td class="text-center"><?= empty($DP['jmlPenerima'])?
																						'<span class="label label-default label-as-badge">Belum Diketahui</span>' :
																						$DP['jmlPenerima']?> </td>
                                        <td><?= $DP['sumDelivered'] + 0;?> %</td>
                                        <td><?= $DP['sumOpened'] + 0;?> %</td>
                                        <td><?= $DP['sumClicked'] + 0;?> %</td>
                                        <td class="text-center">
                                        	<a class="btn btn-sm btn-success" href="<?= base_url() . 'dashboard/pesan/detail/' . $DP['pesan_html_id'];?>">Lihat Detail</a>
                                        </td>
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
</div>



<!--bot-->
				</div>				</div>
		</div>
		<?php $this->load->view('admin/_partials/admin_footer'); ?>


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
		$(document).ready(function (){
			$('#dataTables-datasegment').dataTable()
		})
	</script>
  </body>
</html>
