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
        <?php if ($this->session->flashdata('message')) : ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data Tag Produk</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-8 col-sm-8 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Tambah Tag </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                    <form method="POST" action="">
                    
                      <label for="nama_tag">Nama Tag (Satu kalimat, tanpa spasi) :</label>
                      <input name="nama_tag" type="text" value="<?= set_value('nama_tag') ?>" class="form-control" required />
                      <?php echo form_error('nama_tag', '<div class="text-danger">', '</div>'); ?>
                      <br>
                          <label for="ket_tag">Keterangan Tag (Max 50 kata, Min 8 kata) :</label>
                          <input name="ket_tag" type="text" value="<?= set_value('ket_tag') ?>" class="form-control" required>
                          <?php echo form_error('ket_tag', '<div class="text-danger">', '</div>'); ?>
                          <br/>
                          <div class="col-md-12 text-center">
                            <button type="reset" class="btn btn-secondary">Batal</button>
                            <button type="submit" name="submit" class="btn btn-primary">Tambah Tag</button>
                          </div>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
              </div>


              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Data Tags <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Aktif</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Nonaktif</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                            <div class="x_content">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th class="text-center noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($tagAktif as $key) :  ?>
                                    <tr>
                                        <td><?= $key['id_tags'] ?></td>
                                        <td><?= $key['nama_tag'] ?></td>
                                        <td><?= $key['ket_tag'] ?></td>
                                        <td class="text-center">
                                            <li role="presentation" class="dropdown" style="list-style: none;">
                                                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                    Pilih
                                                    <span class="caret"></span>
                                                </a>
                                                <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnNonaktif" onclick="set_url('<?= site_url('dashboard/admin/deactive_tag/' . encrypt_url($key['id_tags']))  ?>')" data-ket="meng nonaktifkan" data-toggle="modal" data-target="#kt_modal_1">
                                                        Nonaktifkan Tag</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnHapus" onclick="set_url('<?= site_url('dashboard/admin/delete_tag/' . encrypt_url($key['id_tags']))  ?>')" data-ket="menghapus" data-toggle="modal" data-target="#kt_modal_1">
                                                        Hapus Tag</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnEdit" data-toggle="modal" data-target=".bs-example-modal-lg" 
                                                        data-toggle="modal"
                                                        data-id="<?= $key['id_tags'] ?>"
                                                        data-namaold="<?= $key['nama_tag'] ?>"
                                                        data-ketold="<?= $key['ket_tag'] ?>"
                                                        >
                                                        Edit Tag</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                            <div class="x_content">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th class="text-center noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($tagNonaktif as $key) :  ?>
                                    <tr>
                                        <td><?= $key['id_tags'] ?></td>
                                        <td><?= $key['nama_tag'] ?></td>
                                        <td><?= $key['ket_tag'] ?></td>
                                        <td class="text-center">
                                            <li role="presentation" class="dropdown" style="list-style: none;">
                                                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                    Pilih
                                                    <span class="caret"></span>
                                                </a>
                                                <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnAktif" onclick="set_url('<?= site_url('dashboard/admin/reactive_tag/' . encrypt_url($key['id_tags']))  ?>')" data-ket="mengaktifkan" data-toggle="modal" data-target="#kt_modal_1">
                                                        Aktifkan Tag</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnHapus1" onclick="set_url('<?= site_url('dashboard/admin/delete_tag/' . encrypt_url($key['id_tags']))  ?>')" data-ket="menghapus" data-toggle="modal" data-target="#kt_modal_1">
                                                        Hapus Tag</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnEdit1" data-toggle="modal" data-target=".bs-example-modal-lg" 
                                                        data-toggle="modal"
                                                        data-id="<?= $key['id_tags'] ?>"
                                                        data-namaold="<?= $key['nama_tag'] ?>"
                                                        data-ketold="<?= $key['ket_tag'] ?>"
                                                        >
                                                        Edit Tag</a>
                                                    </li>
                                                </ul>
                                            </li>
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
              <div class="clearfix"></div>
              </div>
            </div>
        </div>
        
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
                        <p id="ket_modal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a class="fixHapus"><button class="btn btn-danger" type="button">Setuju</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- Large modal -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit tag <span class="text-danger nama-target"></span></h4>
              </div>
              <div class="modal-body">
                <form method="POST" action="<?= base_url('dashboard/admin/updateTag') ?>">
                
                  <label for="nama_tag">Nama Tag (Satu kalimat, tanpa spasi) :</label>
                  <input name="id_tag_new" type="hidden" value="" class="form-control id_tag_new" />
                  <input name="nama_tag_new" type="text" value="" class="form-control nama_tag_new" required />
                  <br>
                  <label for="ket_tag">Keterangan Tag (Max 50 kata, Min 8 kata) :</label>
                  <textarea name="ket_tag_new" type="text" value="" class="form-control ket_tag_new" required></textarea>
                  <br/>
                  <div class="col-md-12 text-center">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary">Edit Tag</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Large modal -->
        <!-- footer content -->
        <?php $this->load->view('admin/_partials/admin_footer'); ?>
        <!-- /footer content -->
      </div>
	</div>
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
        function set_url(url) {
            $('.fixHapus').attr('href', url);
        }
        $(document).ready(function() {
            $('.btnAktif').on('click', function() {
                let ket = $(this).data('ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data tag ini?');
            });
            $('.btnHapus').on('click', function() {
                let ket = $(this).data('ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data tag ini?');
            });
            $('.btnHapus1').on('click', function() {
                let ket = $(this).data('ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data tag ini?');
            });
            $('.btnNonaktif').on('click', function() {
                let ket = $(this).data('ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data tag ini?');
            });
            $('.btnEdit').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('namaold');
                let ket = $(this).data('ketold');
                $('.id_tag_new').val(id);
                $('.nama_tag_new').val(nama);
                $('.ket_tag_new').val(ket);
                $('.nama-target').text(nama);
            });
            $('.btnEdit1').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('namaold');
                let ket = $(this).data('ketold');
                $('.id_tag_new').val(id);
                $('.nama_tag_new').val(nama);
                $('.ket_tag_new').val(ket);
                $('.nama-target').text(nama);
            });
        });
    </script>
  </body>
</html>
