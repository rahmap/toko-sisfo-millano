<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('produk/_partials-heda.php') ?>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="<?= base_url() ?>assets/SBAdmin2/select2/dist/css/select2.min.css">
  <script src="<?= base_url() ?>assets/SBAdmin2/select2/dist/js/select2.min.js"></script>   
  <script src="<?= base_url() ?>assets/SBAdmin2/select2/dist/js/i18n/id.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>

<body>
<style>
footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: red;
  color: white;
  text-align: center;
}
</style>
  <!-- Begin Nav -->
  <?php $this->load->view('produk/_partials-nav.php') ?>
  <!-- End Nav -->

  <!--Main layout-->
  <main class="mt-5 pt-4">
    <div class="container wow fadeIn">

      <!-- Heading -->
      <h2 class="my-5 h2 text-center">Checkout form</h2>

      <!--Grid row-->
      <div class="row">

        <!--Grid column-->
        <div class="col-md-8 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Detail Pengiriman</span>
          </h4>
          <!--Card-->
          <div class="card">

              <!--Card content-->
              <form class="card-body" id="ongkir" method="POST">
              
              <input type="hidden" class="form-control" value="" id="estimasi" name="estimasi" required="">
              <input type="hidden" class="form-control" value="" id="total_ongkir" name="total_ongkir" required="">
              <input type="hidden" class="form-control" value="" id="totalBayar" name="totalBayar" required="">
              <div class="form-group">
                <label class="control-label col-sm-3">Kota Tujuan</label>
                <div class="col-sm-12">          
                  <select class="form-control" id="kota_tujuan" name="kota_tujuan" required style="width:100%!important">
                    <option></option>
                  </select>
                </div>
                <?= form_error('kota_tujuan', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Kurir</label>
                <div class="col-sm-12">          
                  <select class="form-control" id="kurir" name="kurir" required>
                    <option value="jne">JNE</option>
                    <option value="tiki">TIKI</option>
                    <option value="pos">POS INDONESIA</option>
                  </select>
                </div>
                <?= form_error('kurir', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
              <div class="row">
                <div class='col-sm-6'>
                  <div class="form-group">
                    <label class="control-label col-sm-12">Berat (Kg)</label>
                    <div class="col-sm-12">          
                      <input type="text" class="form-control" id="berat" name="berat" required value='<?= $berat ?>' readonly>
                    </div>
                  </div>
                  <?= form_error('berat', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class='col-sm-6'>
                  <div class="form-group">
                    <label class="control-label col-sm-12">Service</label>
                    <div class="col-sm-12" id="response_ongkir">          
                      <select class="form-control serviceRO" name="service" disabled="true" required>
                        <option value="pilih"></option>
                      </select>
                    </div>
                    <?= form_error('service', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                </div>
                <div class='col-sm-6'>
                  <div class="form-group">
                    <label class="control-label col-sm-12">Nama Penerima</label>
                    <div class="col-sm-12">          
                      <input type="text" class="form-control" id="penerima" minlength="7" name="penerima" required>
                    </div>
                    <?= form_error('penerima', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                </div>
                <div class='col-sm-6'>
                  <div class="form-group">
                    <label class="control-label col-sm-12">Telefon Penerima</label>
                    <div class="col-sm-12">          
                      <input type="number" placeholder="Contoh : 08983423423" minlength="8" class="form-control" id="nohp" name="nohp" required>
                    </div>
                    <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Kode Pos</label>
                <div class="col-sm-12">          
                  <input type="text" class="form-control" id="kode_pos" name="kode_pos" required>
                </div>
                <?= form_error('kode_pos', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-12">Alamat Lengkap Pengiriman</label>
                <div class="col-sm-12">          
                  <textarea name="alamat" id="alamat" required class="form-control" minlength="10" placeholder="Contoh : Jl. Cinta Boulevard No.3 RT/RW 07/02 Bintaro, Pesanggrahan, Jaksel, 55551"></textarea>
                </div>
                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="form-group">
                    <div data-toggle="infoBtnOngkir" title="Centang Data Sudah Lengkap dulu!">
                      <button type="submit" id="cekOngkir" disabled class="btn btn-primary">Cek Ongkir</button>
                    </div>
                    <div class="form-check mt-2">
                      <input class="form-check-input" name="dataLengkap" type="checkbox" value="" id="dataLengkap">
                      <label class="form-check-label text-success" for="dataLengkap">
                        Data Sudah Lengkap
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- <div class="col-md-7" id="response_ongkir"> -->
          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->
        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!-- Heading -->
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Keranjang Belanja</span>
            <span class="badge badge-secondary badge-pill"><?= count($this->cart->contents()) ?></span>
          </h4>

          <!-- Cart -->
          <ul class="list-group mb-3 z-depth-1">
          <?php foreach($this->cart->contents() as $cart): ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h4 class="my-0 text-info"><?= $cart['name'] ?></h4>
                <span class="badge blue ml-0">Jumlah <?= $cart['qty'] ?></span> 
                <span class="badge green ml-2"><?= $cart['ukuran'] ?></span> 
              </div>
              <span class="text-muted">Rp <?= number_format($cart['subtotal'], 0, ',', '.') ?></span>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between lh-condensed" id="cartOngkir">
              <div class="text-primary">
                <h6 class="my-0" id="ROkurir"><strong>Biaya Kirim</strong></h6>
                <small id="ROest"></small>
              </div>
              <span  class="text-primary" id="ROcost"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (IDR)</span>
              <strong id="totalFinal"></strong>
            </li>

            <!-- <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Promo code</h6>
                <small>EXAMPLECODE</small>
              </div>
              <span class="text-success">-$5</span>
            </li> -->

          </ul>
          <!-- Cart -->

          <!-- Promo code -->
          <!-- <form class="card p-2">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Promo code" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-md waves-effect m-0" type="button">Redeem</button>
              </div>
            </div>
          </form> -->
          
          <form action="<?= base_url('payment/checkout') ?>"id="payment-form"  method="post" class="p-2">
          
            <div class="d-flex justify-content-center" data-toggle="infoBtnBayar" 
              title="Silahkan isi data pengiriman dahulu, lalu klik button Cek untuk melanjutkan pembayaran">
              <button class="btn btn-secondary btn-md waves-effect m-0" id="btnBayar" 
              disabled style="width:100%" name="submit" type="submit">Lanjutkan Pembayaran</button>
            </div>
          </form>
          <!-- Promo code -->

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

    </div>
  </main>
  <!--Main layout-->

  <!-- JQuery -->
 
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
  <!-- Select2 -->
  <script type="text/javascript">
    var site_url = "<?= base_url() ?>"; //dikirm ke Ongkir.js
  </script>
  <script src="<?= base_url('assets/js/') ?>Ongkir.js"></script>
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();


    
  </script>
</body>

</html>