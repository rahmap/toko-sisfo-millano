<!DOCTYPE html>
<html lang="en">
  <head>
	<?php $this->load->view('admin/_partials/admin_header') ?>
    <!-- Select2 -->
		<link href="<?= base_url('assets/gentelella/') ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
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
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Atur Sub Kategori</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5   form-group pull-right top_search">
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

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Atur Sub Kategori</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- start form for validation -->
                    <form method="POST" action="<?= base_url('dashboard/admin/addParentKategori/'.$this->uri->segment(4)) ?>">
                    
                    <label for="nama_tag">Parent Kategori (Satu kalimat, tanpa spasi) :</label>
                    <input readonly name="parent" type="text" value="<?= $parent['parent_kategori_nama'] ?>" class="form-control" required />
                    <?php echo form_error('parent', '<div class="text-danger">', '</div>'); ?>
                    <br>
                    <label for="nama_tag">Sub Kategori (Bisa banyak) :</label>
                    <select required multiple name="subKategori[]" class="form-control subKategori">
                      <option value=""></option>
                      <?php foreach ($kategori as $key) : ?>
                        <option value="<?= $key['id_cat'] ?>" <?= set_select('subKategori[]', $key['id_cat']); ?>><?= $key['nama_cat'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <br>
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
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- /page content -->

        <!-- footer content -->
        <?php $this->load->view('admin/_partials/admin_footer'); ?>
        <!-- /footer content -->
      </div>
	</div>
	<?php $this->load->view('admin/_partials/admin_js') ?>
    		<!-- Select2 -->
    <script src="<?= base_url('assets/gentelella/') ?>vendors/select2/dist/js/select2.full.min.js"></script>
    <script>
			$(document).ready(function() {
					$('.subKategori').select2({
					allowClear:true,
					placeholder: 'Pilih'
					});
			});
		</script>
  </body>
</html>
