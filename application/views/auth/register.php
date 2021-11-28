<?php $this->load->view("auth/auth_header") ?>

<?php $this->load->view("auth/auth_nav") ?>
<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-12">
          <div class="p-5">
            <div class="text-center">
            <?= $this->session->flashdata('message') ?>
              <h1 class="h4 text-gray-900 mb-4">Buat Akun baru!</h1>
            </div>
            <form class="user" action="<?= base_url('auth/register') ?>" method="POST">
            
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="exampleInputEmail1">Nama Depan</label>
                  <input type="text" name="fname" class="form-control form-control-user" value="<?= set_value('fname') ?>" id="fname" placeholder="">
                  <?= form_error('fname', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="col-sm-6">
                <label for="exampleInputEmail1">Nama Belakang</label>
                  <input type="text" name="lname" value="<?= set_value('lname') ?>" class="form-control form-control-user" id="lname" placeholder="">
                  <?= form_error('lname', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
              </div>
              <div class="form-group">
              <label for="exampleInputEmail1"><b></b>Alamat Email</label>
                <input type="email" name="email" value="<?= set_value('email') ?>" class="form-control form-control-user" id="email" placeholder="">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="exampleInputEmail1">Provinsi</label>
                  <select class="form-control" id="provinsi" name="provinsi">
                    <?php foreach ($provinsi->rajaongkir->results as $prov): ?>
                      <option data-id_prov="<?= $prov->province_id ?>" value="<?= $prov->province ?>"><?= $prov->province ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="col-sm-4">
                  <label for="exampleInputEmail1">Kabupaten</label>
                  <select class="form-control" id="kabupaten" name="kabupaten">
                      <option> - </option>
                    </select>
                    <?= form_error('kabupaten', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
				<div class="col-sm-4">
                  <label for="gender">Jenis Kelamin</label>
                  <select class="form-control" id="gender" name="gender">
                      <option value="pria"> Pria </option>
					  <option value="wanita"> Wanita </option>
                    </select>
                </div>
                <div class="col-sm-12">
                    <label for="exampleInputEmail1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" class="form-control form-control-user" id="tanggal_lahir" placeholder="">
                    <?= form_error('tanggal_lahir', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="exampleInputEmail1">Password</label>
                  <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="">
                  <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="col-sm-6">
                <label for="exampleInputEmail1">Ulangi Password</label>
                  <input type="password" name="password1" class="form-control form-control-user" id="password1" placeholder="">
                  <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                    Daftarkan Akun
                  </button>
                </div>
              </div>
            </form>
            <hr>
            <!-- <div class="text-center">
              <a class="small" href="forgot-password.html">Lupa Kata Sandi?</a>
            </div> -->
            <div class="text-center">
              <a class="small" href="<?= base_url('auth/login') ?>">Sudah Punya Akun? Login!</a>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<?php $this->load->view("auth/auth_footer") ?>
<script>
$(document).ready( function() {
  const kabupaten = $('#kabupaten');
  const provinsi = $('#provinsi');
  const BASE_URL = "<?php echo base_url() ?>";

  $(provinsi).on('change', function () {
    onLoadRajaongkir()
  })

  onLoadRajaongkir()

  function onLoadRajaongkir(){
    $.ajax({
      url: BASE_URL + 'auth/getKabupaten/'+ provinsi.find(':selected').data('id_prov'),
      dataType : "json",
      success: function(result) {

        $(kabupaten).children('option').remove();
        $(kabupaten).attr('readonly', false);
        let res = JSON.parse(result)
        $(kabupaten).append(res.rajaongkir.results.map(function (sObj) {
          return '<option value="' +
              sObj.city_name + '">' +
              sObj.city_name + '</option>'
        }));
      },
      error: function(err){
        console.log(err);
      }
    })
  }


});

</script>
