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
                <h3>Data Kategori Produk</h3>
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
                    <h2>Form Tambah Parent Kategori </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                    <form method="POST" action="<?= base_url('dashboard/admin/addParent') ?>">
                    
                      <label for="nama_parent">Nama Kategori (Satu kalimat, tanpa spasi) :</label>
                      <input name="nama_parent" type="text" value="<?= set_value('nama_parent') ?>" class="form-control" required />
                      <?php echo form_error('nama_parent', '<div class="text-danger">', '</div>'); ?>
                      <br>
                      <div class="col-md-12 text-center">
                        <button type="reset" class="btn btn-secondary">Batal</button>
                        <button type="submit" name="submit" class="btn btn-primary">Tambah Parent Kategori</button>
                      </div>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
              </div>


              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Data Parent Kategori <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Sudah Ada Sub Kategori</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Semua Parent Kategori</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                            <div class="x_content">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Sub Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($parentKategori as $key) :  ?>
                                    <tr>
                                        <td><?= $key['parent_kategori_nama'] ?></td>
                                        <td><?= $key['sub_kategori'] ?></td>
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
                                        <th>Nama</th>
                                        <th class="text-center noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($parentKategoriOnly as $key) :  ?>
                                    <tr>
                                        <td><?= $key['parent_kategori_nama'] ?></td>
                                        <td class="text-center">
                                            <li role="presentation" class="dropdown" style="list-style: none;">
                                                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                    Pilih
                                                    <span class="caret"></span>
                                                </a>
                                                <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnHapusParent" onclick="set_url('<?= site_url('dashboard/admin/delete_categoryParent/' . encrypt_url($key['parent_kategori_id']))  ?>')" data-ket="menghapus" data-toggle="modal" data-target="#kt_modal_1">
                                                        Hapus Parent Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnEditParent" data-target=".modal-parente" 
                                                        data-toggle="modal"
                                                        data-id="<?= $key['parent_kategori_id'] ?>"
                                                        data-nama-parent="<?= $key['parent_kategori_nama'] ?>"
                                                        >
                                                        Edit Parent Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a href="<?= base_url('dashboard/admin/edit_parent_kategori/'.$key['parent_kategori_id']) ?>"
                                                        >
                                                        Atur Sub Kategori</a>
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
             
            <div class="">
              <div class="col-md-8 col-sm-8 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Tambah Kategori </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                    <form method="POST" action="">
                    
                      <label for="nama_tag">Nama Kategori (Satu kalimat, tanpa spasi) :</label>
                      <input name="nama_cat" type="text" value="<?= set_value('nama_cat') ?>" class="form-control" required />
                      <?php echo form_error('nama_cat', '<div class="text-danger">', '</div>'); ?>
                      <br>
                          <label for="ket_tag">Keterangan Kategori (Max 50 kata, Min 8 kata) :</label>
                          <textarea  name="ket_cat" type="text" value="<?= set_value('ket_cat') ?>" class="form-control" required></textarea>
                          <?php echo form_error('ket_cat', '<div class="text-danger">', '</div>'); ?>
                          <br/>
                          <div class="col-md-12 text-center">
                            <button type="reset" class="btn btn-secondary">Batal</button>
                            <button type="submit" name="submit" class="btn btn-primary">Tambah Kategori</button>
                          </div>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
              </div>


              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Data Kategori <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content33" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Aktif</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content44" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Nonaktif</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content33" aria-labelledby="home-tab">
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
                                foreach ($categoryAktif as $key) :  ?>
                                    <tr>
                                        <td><?= $key['id_cat'] ?></td>
                                        <td><?= $key['nama_cat'] ?></td>
                                        <td><?= $key['ket_cat'] ?></td>
                                        <td class="text-center">
                                            <li role="presentation" class="dropdown" style="list-style: none;">
                                                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                    Pilih
                                                    <span class="caret"></span>
                                                </a>
                                                <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnNonaktif" onclick="set_url('<?= site_url('dashboard/admin/deactive_category/' . encrypt_url($key['id_cat']))  ?>')" data-ket="meng nonaktifkan" data-toggle="modal" data-target="#kt_modal_1">
                                                        Nonaktifkan Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnHapus" onclick="set_url('<?= site_url('dashboard/admin/delete_category/' . encrypt_url($key['id_cat']))  ?>')" data-ket="menghapus" data-toggle="modal" data-target="#kt_modal_1">
                                                        Hapus Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnEdit" data-toggle="modal" data-target=".bs-example-modal-lg" 
                                                        data-toggle="modal"
                                                        data-id="<?= $key['id_cat'] ?>"
                                                        data-namaold="<?= $key['nama_cat'] ?>"
                                                        data-ketold="<?= $key['ket_cat'] ?>"
                                                        >
                                                        Edit Cat</a>
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
                        <div role="tabpanel" class="tab-pane fade" id="tab_content44" aria-labelledby="profile-tab">
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
                                foreach ($categoryNonaktif as $key) :  ?>
                                    <tr>
                                        <td><?= $key['id_cat'] ?></td>
                                        <td><?= $key['nama_cat'] ?></td>
                                        <td><?= $key['ket_cat'] ?></td>
                                        <td class="text-center">
                                            <li role="presentation" class="dropdown" style="list-style: none;">
                                                <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                    Pilih
                                                    <span class="caret"></span>
                                                </a>
                                                <ul id="menu6" class="dropdown-menu animated fadeInDown" role="menu">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnAktif" onclick="set_url('<?= site_url('dashboard/admin/reactive_category/' . encrypt_url($key['id_cat']))  ?>')" data-ket="mengaktifkan" data-toggle="modal" data-target="#kt_modal_1">
                                                        Aktifkan Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnHapus1" onclick="set_url('<?= site_url('dashboard/admin/delete_category/' . encrypt_url($key['id_cat']))  ?>')" data-ket="menghapus" data-toggle="modal" data-target="#kt_modal_1">
                                                        Hapus Kategori</a>
                                                    </li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="btnEdit1" data-toggle="modal" data-target=".bs-example-modal-lg" 
                                                        data-toggle="modal"
                                                        data-id="<?= $key['id_cat'] ?>"
                                                        data-namaold="<?= $key['nama_cat'] ?>"
                                                        data-ketold="<?= $key['ket_cat'] ?>"
                                                        >
                                                        Edit Cat</a>
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
    <!--end::Modal-->
    <!-- Large modal -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Kategori <span class="text-danger nama-target"></span></h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?= base_url('dashboard/admin/updateCat') ?>">
            
              <label for="nama_cat_new">Nama Kategori (Satu kalimat, tanpa spasi) :</label>
              <input name="id_cat_new" type="hidden" value="" class="form-control id_cat_new" />
              <input name="nama_cat_new" type="text" value="" class="form-control nama_cat_new" required />
              <br>
              <label for="ket_cat">Keterangan Kategori (Max 50 kata, Min 8 kata) :</label>
              <textarea name="ket_cat_new" type="text" value="" class="form-control ket_cat_new" required></textarea>
              <br/>
              <div class="col-md-12 text-center">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" name="submit" class="btn btn-primary">Edit Kategori</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-parente fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Parent Kategori <span class="text-danger nama-target"></span></h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="<?= base_url('dashboard/admin/updateCatParent') ?>">
            
              <label for="nama_cat_new">Nama Kategori (Satu kalimat, tanpa spasi) :</label>
              <input name="id_cat_new" type="hidden" value="" class="form-control id_cat_new" />
              <input name="nama_cat_new" type="text" value="" class="form-control nama_cat_new" required />
              <br>
              <div class="col-md-12 text-center">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" name="submit" class="btn btn-primary">Edit Parent Kategori</button>
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
            $('.btnAktif').click(function() {
                const ket = $(this).attr('data-ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data kategori ini?');
            });
            $('.btnHapus').click(function() {
                const ket = $(this).attr('data-ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data kategori ini?');
            });

            $('.btnHapusParent').click(function() {
                const ket = $(this).attr('data-ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data kategori ini?');
            });

            $('.btnHapus1').click(function() {
                const ket = $(this).attr('data-ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data kategori ini?');
            });
            $('.btnNonaktif').click(function() {
                const ket = $(this).attr('data-ket');
                $('#ket_modal').text('Anda yakin ingin ' + ket + ' data kategori ini?');
            });
            $('.btnEdit').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('namaold');
                let ket = $(this).data('ketold');
                $('.id_cat_new').val(id);
                $('.nama_cat_new').val(nama);
                $('.ket_cat_new').val(ket);
                $('.nama-target').text(nama);
            });
            $('.btnEditParent').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama-parent');
                $('.id_cat_new').val(id);
                $('.nama_cat_new').val(nama);
                $('.nama-target').text(nama);
            });
            $('.btnEdit1').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('namaold');
                let ket = $(this).data('ketold');
                $('.id_cat_new').val(id);
                $('.nama_cat_new').val(nama);
                $('.ket_cat_new').val(ket);
                $('.nama-target').text(nama);
            });
        });
    </script>
  </body>
</html>
