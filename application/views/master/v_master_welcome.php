<!DOCTYPE html>
<html lang="en">
  <head>
	<?php $this->load->view('master/_partials/master_header') ?>
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
        <div class="right_col" role="main"> <!-- Mulai Konten -->
					<div class="">
						<h1 style="margin-top: 100px !important;" class="text-center">Selamat Datang <?= $this->session->nama ?></h1>
					</div>
        </div> <!-- Selesai Konten -->
        <!-- /page content -->

        <!-- footer content -->
        <?php $this->load->view('master/_partials/master_footer'); ?>
        <!-- /footer content -->
      </div>
	</div>
	<?php $this->load->view('master/_partials/master_js') ?>

  </body>
</html>
