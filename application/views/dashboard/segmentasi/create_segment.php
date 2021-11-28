<!DOCTYPE html>
<html lang="en">
  <head>
	<?php $this->load->view('admin/_partials/admin_header') ?>
	    <!-- Datatables -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </head>

  <body class="nav-md">
	<?php if ($this->session->flashdata('message')) : ?>
		<?= $this->session->flashdata('message'); ?>
	<?php endif; ?>
	<style>
		.panel-body:hover {
			background-color: #FFFFFF !important;
		}
	</style>
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

            <div class="panel panel-green">
                <div class="panel-heading">
                    <h2>Tambah Segment</h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <form role="form" id="formSegmentasi" method="POST" action="<?= base_url('dashboard/Segmentasi/create_segment_save'); ?>">
                                    <div class="panel-body">
																			<div class="x_content">
																				<div class="form-group">
																					<label>Nama Segmentasi</label>
																					<input class="form-control" name="namaSegmentasi" minlength="3" maxlength="50" id="nama" type="text" required="">
																				</div>
																				<div class="form-group">
																					<label>Keterangan Segmentasi</label>
																					<input class="form-control" name="keteranganSegmentasi" minlength="5" maxlength="300" id="keterangan" type="text" required="">
																				</div>

																				<div class="form-group">
																					<label  hidden="hidden">Match</label>
																					<select style="visibility:hidden;" class="form-control" name="match" id="match" required="">
																					
																						<option value="AND">SEMUA (AND)</option>
																				
																					</select>
																				</div>
																				<hr>
																				<div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
																					<div class="panel">
																						<a class="panel-heading" role="tab" id="headingOne1" data-toggle="" data-parent="#accordion1" href="javascript:(0)" aria-expanded="false" aria-controls="collapseOne">
																							<h4 class="panel-title">Segment Umur</h4>
																						</a>
																						<div id="collapseOne1" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne" style="">
																							<div class="panel-body">

																								<div class="form-group">
																									<label>Operasi</label>
																									<select class="form-control" name="operasiUmur" id="operasiUmur">
																										<option value="" selected="">Semua Operasi</option>
																										<option value="=">Sama dengan</option>
																										<option value="!=">Tidak sama dengan</option>
																										<option value=">">Lebih besar</option>
																										<option value="<">Kurang Dari</option>
																										<!--<option value=">=">is greater than equal</option>
																										<option value="<=">is less than equal</option>-->
																									</select>
																								</div>
																								<div class="form-group">
																									<label>Parameter</label>
																									<select class="form-control" name="parameterUmur" disabled id="parameterUmur">
																											<option disabled value="" selected="">Semua Umur</option>
																										<?php foreach ($user_age as $age): ?>
																											<option value="<?= $age['user_age'] ?>"><?= $age['user_age'] ?></option>
																										<?php endforeach; ?>
																									</select>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="panel">
																						<a class="panel-heading" role="tab" id="headingTwo1" data-toggle="" data-parent="#accordion1" href="javascript:(0)" aria-expanded="false" aria-controls="collapseTwo">
																							<h4 class="panel-title">Segment Provinsi</h4>
																						</a>
																						<div id="collapseTwo1" class="panel-collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
																							<div class="panel-body">
																								<div class="form-group">
																									<label>Operasi</label>
																									<select class="form-control" name="operasiProvinsi" id="operasiProvinsi">
																										<option value="" selected="">Semua Operasi</option>
																										<option value="=">Sama dengan</option>
																										<option value="!=">Tidak sama dengan</option>
																									</select>
																								</div>
																								<div class="form-group">
																									<label>Parameter</label>
																									<select class="form-control" name="parameterProvinsi" disabled id="parameterProvinsi">
																										<option selected="" value="" disabled>Semua Provinsi</option>
																										<?php foreach ($user_prov as $prov): ?>
																											<option value="<?= $prov['provinsi'] ?>"><?= $prov['provinsi'] ?></option>
																										<?php endforeach; ?>
																									</select>
																								</div>
																							</div>
																						</div>
																					</div>

																					<div class="panel">
																						<a class="panel-heading" role="tab" id="headingThree1" data-toggle="" data-parent="#accordion1" href="javascript:(0)" aria-expanded="false" aria-controls="collapseThree">
																							<h4 class="panel-title">Segment Jenis Kelamin</h4>
																						</a>
																						<div id="collapseJenkel" class="panel-collapse" role="tabpanel" aria-labelledby="headingThree" style="">
																							<div class="panel-body">
																								<div class="form-group">
																									<label>Operasi</label>
																									<select class="form-control" name="operasiGender" id="operasiGender">
																										<option value="" selected="">Semua Operasi</option>
																										<option value="=">Sama dengan</option>
																										<option value="!=">Tidak sama dengan</option>
																									</select>
																								</div>
																								<div class="form-group">
																									<label>Parameter</label>
																									<select class="form-control" name="parameterGender" disabled id="parameterGender">
																										<option value="" disabled selected="">Semua Gender</option>
																										<?php foreach ($user_gender as $gender): ?>
																											<option value="<?= $gender['gender'] ?>"><?= ucwords($gender['gender']) ?></option>
																										<?php endforeach; ?>
																									</select>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="panel">
																						<a class="panel-heading" role="tab" id="headingThree1" data-toggle="" data-parent="#accordion1" href="javascript:(0)" aria-expanded="false" aria-controls="collapseThree">
																							<h4 class="panel-title">Segment Rating</h4>
																						</a>
																						<div id="collapseRating" class="panel-collapse" role="tabpanel" aria-labelledby="headingThree" style="">
																							<div class="panel-body">
																								<div class="form-group">
																									<label>Operasi</label>
																									<select class="form-control" name="operasiRating" id="operasiRating">
																										<option value="" selected="">Semua Operasi</option>
																											<option value="=">Sama dengan</option>
																										<option value="!=">Tidak sama dengan</option>
																										<option value=">">Lebih besar</option>
																										<option value="<">Kurang Dari</option>
																									<!--	<option value=">=">is greater than equal</option>
																										<option value="<=">is less than equal</option>-->
																									</select>
																								</div>
																								<div class="form-group">
																									<label>Parameter</label>
																									<select class="form-control" name="parameterRating" disabled id="parameterRating">
																										<option value="" disabled selected>Semua Rating</option>
																											<option value="1">1</option>
																											<option value="2">2</option>
																											<option value="3">3</option>
																									</select>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
                                    </div>
                                    <div class="panel-footer">
																			<button type="reset" class="btn btn-default">Reset</button>
																			<button type="submit" class="btn btn-success pull-right" value="Simpan">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
	<script>
		window.addEventListener( 'pageshow', function ( event ) {
			let historyTraversal = event.persisted ||
				( typeof window.performance != 'undefined' &&
					window.performance.navigation.type === 2 );
			if ( historyTraversal ) {
				// Handle page restore.
				window.location.reload();
			}
		});
	$(document).ready(function (){
		let parameterUmur = $('#parameterUmur')
		let parameterProvinsi = $('#parameterProvinsi')
		let parameterKabupaten = $('#parameterKabupaten')
		let parameterGender = $('#parameterGender')
		let parameterRating = $('#parameterRating')

		$('#operasiUmur').change(function (){
			if(!$(this).val()){
				$('#parameterUmur option:eq(0)').prop('selected', true);
				parameterUmur.prop('disabled', true)
				parameterUmur.removeAttr('required')
			} else {
				parameterUmur.prop('disabled', false)
				parameterUmur.prop('required', true)
			}
		})
		$('#operasiProvinsi').change(function (){
			if(!$(this).val()){
				$('#parameterProvinsi option:eq(0)').prop('selected', true);
				parameterProvinsi.prop('disabled', true)
				parameterProvinsi.removeAttr('required')
			} else {
				parameterProvinsi.prop('disabled', false)
				parameterProvinsi.prop('required', true)
			}
		})
		$('#operasiKabupaten').change(function (){
			if(!$(this).val()){
				parameterKabupaten.prop('disabled', true)
				$('#parameterKabupaten option:eq(0)').prop('selected', true);
				parameterKabupaten.removeAttr('required')
			} else {
				parameterKabupaten.prop('disabled', false)
				parameterKabupaten.prop('required', true)
			}
		})
		$('#operasiGender').change(function (){
			if(!$(this).val()){
				$('#parameterGender option:eq(0)').prop('selected', true);
				parameterGender.prop('disabled', true)
				parameterGender.removeAttr('required')
			} else {
				parameterGender.prop('disabled', false)
				parameterGender.prop('required', true)
			}
		})
		$('#operasiRating').change(function (){
			if(!$(this).val()){
				$('#parameterRating option:eq(0)').prop('selected', true);
				parameterRating.prop('disabled', true)
				parameterRating.removeAttr('required')
			} else {
				parameterRating.prop('disabled', false)
				parameterUmur.prop('required', true)
			}
		})
	})
	</script>
  </body>
</html>
