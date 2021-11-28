<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('produk/_partials-heda.php')?>
</head>

<body>

  <!-- Begin Nav -->
  <?php $this->load->view('produk/_partials-nav.php')?>
  <!-- End Nav -->
        <?php if ($this->session->flashdata('message')): ?>
            <?=$this->session->flashdata('message');?>
        <?php endif;?>
  <!--Main layout-->
  <main class="mt-4 pt-4">
    <div class="container dark-grey-text mt-5">

      <!--Grid row-->
      <div class="row wow fadeIn">
        <div class="col-md-12 text-center">

          <h4 class="my-4 h2"><?=$produk['nama_produk']?></h4>

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->
      <div class="row d-flex justify-content-center wow fadeIn">

        <!--Grid column-->

        <!--Grid row-->
        <!--Grid column-->
        <div class="col-md-6 mb-4">

          <img src="<?=base_url('assets/images/produk/' . $produk['gambar_produk'])?>" height="420" width="420" class="img-fluid" alt="">
          <!--  -->
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 mb-4">

          <!--Content-->
          <div class="p-4">

            <div class="mb-3">
              <p class="lead font-weight-bold">Kategori
                <a href="<?=base_url('produk/cari/kategori/' . strtolower($produk['nama_cat']))?>">
                  <span class="badge red mr-1"><?=$produk['nama_cat']?></span>
                </a>
              </p>
              <p class="lead font-weight-bold">Tags
                <?php if (count($tags) > 1): ?>
                  <?php foreach ($tags as $tag): ?>
                    <a href="">
                      <span class="badge purple mr-1"><?=$tag['nama_tag']?></span>
                    </a>
                  <?php endforeach;?>
                <?php else: ?>
                  <a href="">
                    <span class="badge purple mr-1"><?=$tags['nama_tag']?></span>
                  </a>
                <?php endif;?>
              </p>
            </div>
            <p class="lead font-weight-bold">Ukuran
              <?php foreach ($ukuranNew as $uk): ?>
                <?='<span class="badge green mr-1">' . $uk . '</span>'?>
              <?php endforeach;?>
            </p>


            <p class="lead">
              <?php if ($produk['diskon'] != 0) {?>
                <span class="mr-1" style="font-size: 100%;">
                  <del>Rp <?=number_format($produk['harga_produk'], 0, ',', '.')?></del>
                </span>
                <span class="font-weight-bold blue-text" style="font-size: 100%;">
                  Rp <?=number_format($produk['harga_produk'] - $produk['harga_produk'] * $produk['diskon'] / 100, 0, ',', '.')?>
                </span>
              <?php } else {?>
                <h4 class="font-weight-bold blue-text">Rp <?=number_format($produk['harga_produk'], 0, ',', '.')?></h4>
              <?php }?>
            </p>

            <p class="lead font-weight-bold">Deskripsi Produk</p>

            <p><?=$produk['ket_produk']?></p>

            <h6> <b>
                <?php
                  if ($produk['stok'] != 0) {
                      echo 'Stok tersisa : ' . $produk['stok'];
                  }
                  ?>
              </b></h6>
            <form class="d-flex justify-content-left" action="<?=base_url('cart/tambahKeranjang')?>" method="POST">
            
              <!-- Default input -->
              <?php if ($produk['stok'] != 0) {?>
                  <input type="number" name="qty" placeholder="Jumlah" max="<?=$produk['stok']?>" aria-label="Search" class="form-control mr-3" style="width: 100px">
                  <select class="form-control mr-3" <?=($ukuranNew[0] == 'all size') ? 'readonly' : ''?> required name="ukuran" style="width:150px">
                    <?php if ($ukuranNew[0] == 'all size') {?>
                      <option value="all size" selected> All Size </option>'
                    <?php } else {?>
                      <option value="">Pilih Ukuran</option>
                      <?php foreach ($ukuranNew as $uk): ?>
                      <?php
                        if ($uk == '') {
                            continue;
                        } else {
                            echo '<option value="' . $uk . '"> ' . $uk . ' </option>';
                        }
                            ?>
                      <?php endforeach;?>
                      <?php }?>
                  </select>


                <input hidden type="text" name="produk_nama" value="<?=$produk['nama_produk']?>">
                <input hidden type="text" name="diskon" value="<?=$produk['diskon']?>">
                <input hidden type="text" name="produk_id" value="<?=decrypt_url($this->uri->segment('3'))?>">
                <input hidden type="text" name="produk_harga" value="<?=$produk['harga_produk']?>">
                <input hidden type="number" name="berat" value="<?=$produk['berat']?>">
                <input type="text" hidden name="gambar" value="<?=base_url('assets/images/produk/' . $produk['gambar_produk'])?>">
                <button type="submit" name="submit" class="btn btn-primary btn-md my-0">Tambahkan ke cart
                  <i class="fas fa-shopping-cart ml-1"></i>
                </button>
            </form>

          <?php } else {?>
            <a href="#" class="btn btn-danger btn-md my-0 p">Stok Barang Kosong</a>
          <?php }?>
          </div>
          <!--Content-->
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->

      <hr>
      <!--Grid row-->
      <div class="row d-flex justify-content-center wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 text-center">

          <h4 class="my-4 h4">Produk lainnya dari kategori yang sama</h4>

          <!-- <p>dfsdfd.</p> -->

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

      <!--Grid row-->
      <div class="row wow fadeIn">
        <!--Grid column-->
          <?php foreach ($produkLain as $items): ?>
          <div class="col-md-6">
            <div class="card m-3 blogBox moreBox" style="max-width: 520em;max-height:200em;display: none;">
              <a href="<?=base_url('produk/detail/' . encrypt_url($items['unik_produk']))?>">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="<?=base_url('assets/images/produk/' . $items['gambar_produk'])?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title text-muted"><?=$items['nama_produk']?></h5>
                    <p class="card-text ket_produk"><?=(strlen($items['ket_produk']) >= 85) ? substr($items['ket_produk'], 0, 85) . '...' : substr($items['ket_produk'], 0, 85);?></p>
                    <p class="card-text"><small class="text-muted font-weight-bold blue-text"><h4>Rp
                    <?=number_format($items['harga_produk'] - $items['harga_produk'] * $items['diskon'] / 100, 0, ',', '.')?></h4></small></p>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
          <?php endforeach;?>
          <?php if (count($produkLain) != 0) {?>
            <div class="col-md-12 text-center mb-5">
              <div id="loadMore" style="">
                <button type="button" class="btn btn-secondary btn-md my-0 p">Lainnya</button>
              </div>
            </div>
          <?php } else {?>
            <div class="col-md-12 text-center mb-5">
            <h6 class="my-4 h6 text-warning">Belum ada produk dengan kategori yang sama!</h6>
            </div>
          <?php }?>
        <!--Grid column
      </div>
      <!--Grid row-->

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <!-- <footer class="page-footer text-center font-small mt-5 wow fadeIn">



    <div class="footer footer-copyright py-3">
      © 2019 Copyright:
      <a href="<?= APP_CREATOR_LINK ?>" target="_blank"> rahmaap__ </a>
    </div>


  </footer> -->
  <!--/.Footer-->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
  <!-- Initializations -->
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();

    $( document ).ready(function () {
      $('.moreBox').slice(0, 2).show();
        if ($('.blogBox:hidden').length != 0) {
          $('#loadMore').show();
        }
        $('#loadMore').on('click', function (e) {
          e.preventDefault();
          $('.moreBox:hidden').slice(0, 2).slideDown();
          if ($('.moreBox:hidden').length == 0) {
            $('#loadMore').fadeOut('slow');
          }
      });
    });
  </script>
</body>

</html>
