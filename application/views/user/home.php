<!DOCTYPE html>
<html lang="en">
  <head>
	<?php $this->load->view('user/_partials/user_header') ?>
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
				<?php $this->load->view('user/_partials/user_pp') ?>
            <!-- /menu profile quick info & nama toko -->

            <br/>

            <!-- sidebar menu -->
			<?php $this->load->view('user/_partials/user_sidebar') ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
		<?php $this->load->view('user/_partials/user_topnav') ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main"> <!-- Mulai Konten -->
					<div class="">
						<div class="row top_tiles">
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
							<div class="count"><?= $countPemesanan['total_order'] ?></div>
							<h3>Pemesanan Selesai</h3>
							<p>Jumlah pesanan yang sudah selesai.</p>
							</div>
						</div>
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-comments-o"></i></div>
							<div class="count"><?= ($countItem['total_item'] == NULL)? 0 : $countItem['total_item']; ?></div>
							<h3>Produk Dibeli</h3>
							<p>Jumlah produk yang berhasil dibeli.</p>
							</div>
						</div>
						<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="tile-stats">
							<div class="icon"><i class="fa fa-check-square-o"></i></div>
							<div class="count">Rp <?= number_format($countBelanja['total_beli'], 0, ',', '.') ?></div>
							<h3>Uang Dibelanjakan</h3>
							<p>Total uang yang sudah dibelanjakan.</p>
							</div>
						</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Grafik Pembelian</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<canvas id="chartPemesanan"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Grafik Uang Dikeluarkan</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<canvas id="chartPendapatan"></canvas>
								</div>
							</div>
						</div>

					</div>
        </div> <!-- Selesai Konten -->
        <!-- /page content -->

        <!-- footer content -->
        <?php $this->load->view('user/_partials/user_footer'); ?>
        <!-- /footer content -->
      </div>
	</div>
	<?php $this->load->view('user/_partials/user_js') ?>
	<script src="<?= base_url('assets/js/') ?>homeAdmin.js"></script>
	<script>
	$(document).ready(function(){
		if ($('#chartPemesanan').length ){ 
			  
			var ctx = document.getElementById("chartPemesanan");
			var mybarChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [	"<?php echo $dataChartPesan[9]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[8]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[7]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[6]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[5]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[4]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[3]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[2]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[1]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPesan[0]['tanggal_selesai'] ?>"],
				datasets: [{
				label: 'Item Dibeli',
				backgroundColor: "#FFC957",
				data: [		"<?php echo $dataChartPesan[9]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[8]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[7]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[6]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[5]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[4]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[3]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[2]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[1]['jumlah_beli'] ?>",
									"<?php echo $dataChartPesan[0]['jumlah_beli'] ?>"]
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							stepSize: 1,
							beginAtZero: true
						}
					}]
				}
			}
			});
		} //Batas Pemesanan

		if ($('#chartPendapatan').length ){ 
			
			var ctx = document.getElementById("chartPendapatan");
			var mybarChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [	"<?php echo $dataChartPenjualan[9]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[8]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[7]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[6]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[5]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[4]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[3]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[2]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[1]['tanggal_selesai'] ?>",
									"<?php echo $dataChartPenjualan[0]['tanggal_selesai'] ?>"],
				datasets: [{
				label: 'Uang Dibelanjakan',
				backgroundColor: "#FF6F57",
				data: [		"<?php echo $dataChartPenjualan[9]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[8]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[7]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[6]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[5]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[4]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[3]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[2]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[1]['jumlah_pendapatan'] ?>",
									"<?php echo $dataChartPenjualan[0]['jumlah_pendapatan'] ?>"]
				}]
			},
			options: {
				scales: {
				yAxes: [{
						ticks: {
							stepSize: 100000,
							beginAtZero: true,
							callback: function(value, index, values) {
								if(parseInt(value) >= 1000){
									return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								} else {
									return 'Rp ' + value;
								}
							}
						}
					}]
				},
				tooltips: {
						callbacks: {
							label: function(tooltipItem, chart){
									var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
									return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel, 0);
							}
						}
					}
				}
			});
		}  //Batas Penjualan
	});
	
	</script>
  </body>
</html>
