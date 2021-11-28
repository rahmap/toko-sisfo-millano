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
        <!-- PNotify -->
    <link href="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_content">

               

                </div>
              </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Penjualan </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table id="datatable-penjualan" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center">Tanggal</th>
                          <th class="text-center" style="width: 15%">Penjualan</th>
                          <th>Total Pendapatan</th>
                        </tr>
                      </thead>


                      <tbody id="data-lap-penjualan">
                        <?php foreach($laporan as $item): ?>
                        <tr>
                          <td class="text-center"><?= $item['tanggal_selesai'] ?></td>
                          <td class="text-center"><?= $item['jumlah_perhari'] ?></td>
                          <td>Rp <?= number_format($item['pendapatan'], 0, ',', '.')  ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
					</div>
        </div> <!-- Selesai Konten -->
        <!-- /page content -->

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
    <!-- PNotify -->
    <script src="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?= base_url('assets/gentelella/') ?>vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?= base_url('assets/gentelella/') ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?= base_url('assets/gentelella/') ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
      
      $(document).ready(function() {
        init_daterangepicker(); // laporan Penjualan
        let from_date, to_date

        $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
          from_date = picker.startDate.format('MMMM D, YYYY');
          to_date = picker.endDate.format('MMMM D, YYYY');
        });

        $('.btnSemua').click(function(){
          from_date = null;
          to_date = null;
          $.ajax({  
            url: "<?= base_url() ?>" + 'dashboard/admin/setRangePenjualan',  
            method:'POST',  
            data: {
              from_date: from_date,
              to_date: to_date
            },  
            success:function(data)  
            {  
              $('#datatable-penjualan').DataTable().destroy();
              $('#data-lap-penjualan').html(data);  
              $('#datatable-penjualan').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                  'excel', 'pdf', 'print','csv'
                ]
              });
            }
          })
        })

        $('.btnSemua').click(function(){
          $('#ketDateRange').text('Menampilkan semua data penjualan.');
        })  

        $('.ui-pnotify').remove();
        $('#datatable-penjualan').DataTable( {
          dom: 'Bfrtip',
          buttons: [
            'excel', 'pdf', 'print','csv'
          ]
        });
      });
    </script>
  </body>
</html>
