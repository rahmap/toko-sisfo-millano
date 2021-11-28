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
    <div class="col-md-6">
        <h3 class="page-header">Demografi Data User (Provinsi)
        </h3>
        <div class="row">
            <div class="chart-responsive">
                <canvas id="barChart" style="height:230px"></canvas>
            </div>
        </div>      
    </div>
    <div class="col-md-6">
        <h3 class="page-header">Demografi Data User (Kabupaten)
        </h3>
        <div class="row">
            <div class="chart-responsive">
                <canvas id="barChartkab" style="height:230px"></canvas>
            </div>
        </div>      
    </div>
    <div class="col-md-6">
        <h3 class="page-header">Demografi Data User (Umur)
        </h3>
        <div class="row">
            <div class="chart-responsive">
                <canvas id="barChartAge" style="height:230px"></canvas>
            </div>
        </div>      
    </div>
    <div class="col-md-6">
        <h3 class="page-header">Demografi Data User (Gender)
        </h3>
        <div class="row">
            <div class="col-md-8 chart-responsive">
                <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <div class="col-md-4">
                <ul class="chart-legend clearfix">
                    <li style="color:#00c0ef;"><i class="fa fa-circle-o"></i> Laki-laki (<?php echo $userman->gender; ?>)</li>
                    <li style="color:#f39c12;"><i class="fa fa-circle-o text-green"></i> Perempuan (<?php echo $userwoman->gender; ?>)</li>
                </ul>
            </div>
        </div>      
    </div>
</div>
<br>
<br>
<?php
foreach ($userr as $data) {
    $countrangeumur[] = $data->range_umur;
}

foreach ($userr as $data) {
    $countumur[] = $data->jumlah;
}

foreach ($userprovinsi as $data) {
    $countprovinsi[] = $data->provinsi;
}

foreach ($userprovinsi as $data) {
    $countuserprovinsi[] = (float) $data->jumlahprovinsi;
}
foreach ($userkabupaten as $data) {
    $countkabupaten[] = $data->kabupaten;
}

foreach ($userkabupaten as $data) {
    $countuserkabupaten[] = (float) $data->jumlahkabupaten;
}
?>
<script type="text/javascript">
    $(function () {
       var areaChartDataAge = {
        labels: <?php echo json_encode($countrangeumur); ?>,
        datasets: [
        {
            label: 'Umur',
            fillColor: 'rgb(0, 166, 90)',
            strokeColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#cc0052',
            pointHighlightFill: '#cc0052',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: <?php echo json_encode($countumur); ?>
        }
        ]
    }
    var barChartCanvasAge = $("#barChartAge").get(0).getContext("2d");
    var barChartAge = new Chart(barChartCanvasAge);
    var barChartDataAge = areaChartDataAge;
    barChartDataAge.datasets[0].fillColor = "#cc0052";
    barChartDataAge.datasets[0].strokeColor = "#cc0052";
    barChartDataAge.datasets[0].pointColor = "#cc0052";
    var barChartOptionsAge = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true,
        maintainAspectRatio: true
    };
    barChartOptionsAge.datasetFill = false;
    barChartAge.Bar(barChartDataAge, barChartOptionsAge);
    
    
    var areaChartData = {
        labels: <?php echo json_encode($countprovinsi); ?>,
        datasets: [
        {
            label: 'Country',
            fillColor: 'rgb(0, 166, 90)',
            strokeColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#00a65a',
            pointHighlightFill: '#00a65a',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: <?php echo json_encode($countuserprovinsi); ?>
        }
        ]
    }
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[0].fillColor = "#00a65a";
    barChartData.datasets[0].strokeColor = "#00a65a";
    barChartData.datasets[0].pointColor = "#00a65a";
    var barChartOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true,
        maintainAspectRatio: true
    };
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

    var areaChartDatakab = {
        labels: <?php echo json_encode($countkabupaten); ?>,
        datasets: [
        {
            label: 'Country',
            fillColor: 'rgb(0, 166, 90)',
            strokeColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#00a65a',
            pointHighlightFill: '#00a65a',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: <?php echo json_encode($countuserkabupaten); ?>
        }
        ]
    }
    var barChartCanvaskab = $("#barChartkab").get(0).getContext("2d");
    var barChartkab = new Chart(barChartCanvaskab);
    var barChartDatakab = areaChartDatakab;
    barChartDatakab.datasets[0].fillColor = "#994d00";
    barChartDatakab.datasets[0].strokeColor = "#994d00";
    barChartDatakab.datasets[0].pointColor = "#994d00";
    var barChartOptionskab = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true,
        maintainAspectRatio: true
    };
    barChartOptionskab.datasetFill = false;
    barChartkab.Bar(barChartDatakab, barChartOptionskab);



    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart = new Chart(pieChartCanvas)
    var PieData = [
    {
        value: <?php echo $userwoman->gender; ?>,
        color: '#f39c12',
        highlight: '#f39c12',
        label: 'Perempuan'
    },
    {
        value: <?php echo $userman->gender; ?>,
        color: '#00c0ef',
        highlight: '#00c0ef',
        label: 'Laki-laki'
    }
    ]
    var pieOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: '#fff',
        segmentStrokeWidth: 2,
        percentageInnerCutout: 50,
        animationSteps: 100,
        animationEasing: 'easeOutBounce',
        animateRotate: true,
        animateScale: false,
        responsive: true,
        maintainAspectRatio: true,
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    pieChart.Doughnut(PieData, pieOptions);

});



</script>


<!--bot-->


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
  </body>
</html>
