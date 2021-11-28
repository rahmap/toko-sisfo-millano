<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('produk/_partials-heda.php') ?>
</head>

<body>

  <!-- Begin Nav -->
  <?php $this->load->view('produk/_partials-nav.php') ?>
  <!-- End Nav -->
        <?php if ($this->session->flashdata('message')) : ?>
            <?= $this->session->flashdata('message'); ?>
        <?php endif; ?>
  <!--Main layout-->
  <main class="mt-4 pt-4">
    <div class="container dark-grey-text mt-5">

    <div class="card-body">
      <!-- Shopping cart table -->
      <?php if (count($this->cart->contents()) != 0) : ?>
        <div class="table table-responsive mb-0 table-bordered">
          <table class="table mb-0">
            <thead>
              <tr>
                <th scope="col" class="border-0 bg-light">
                  <div class="p-2 px-3 text-uppercase">Produk</div>
                </th>
                <th scope="col" class="border-0 bg-light">
                  <div class="py-2 text-uppercase">Harga</div>
                </th>
                <th scope="col" class="border-0 bg-light">
                  <div class="py-2 text-uppercase">Sub Total</div>
                </th>
                <th scope="col" class="border-0 bg-light text-center">
                  <div class="py-2 text-uppercase">Aksi</div>
                </th>
              </tr>
            </thead>
            <tbody id="detail_cart">
              <?php foreach ($this->cart->contents() as $items) : ?>
              <tr>
                  <th scope="row">
                    <div class="p-2">
                      <img src="<?= $items['gambar'] ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block"><?= $items['name'] ?> <b>(<?= $items['ukuran'] ?>)</b></a></h5><span class="text-muted font-weight-normal font-italic">Category: Fashion</span>
                      </div>
                    </div>
                  </th>
                  <td class="align-middle"><strong>Rp <?= number_format($items['price'], 0, ',', '.') ?> x (<strong><?= $items['qty'] ?></strong> item)</strong></td>
                  <td class="align-middle text-center"><strong>Rp <?= number_format($items['subtotal'], 0, ',', '.') ?></strong></td>
                  <td class="align-middle text-center"><a href="<?= base_url('cart/hapus_items/' . $items['rowid']) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>
                  </tr>
              <?php endforeach; ?>
              <tr>
                <td colspan="3" class="align-middle text-right"><span class="badge badge-info">
                    <h5>
                      Rp <?= number_format($this->cart->total(), 0, ',', '.') ?></h5>
                    </<span>
                </td>
                <td><a href="<?= base_url('produk/checkout') ?>"><button class="btn btn-primary btn-md float-right">Bayar</button></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      <?php else : ?>
        <h3 class="text-center">Keranjang Belanja Kosong!</h3>
      <?php endif; ?>
    </div>

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <!-- <footer class="page-footer text-center font-small mt-4 wow fadeIn">



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
</body>

</html>
