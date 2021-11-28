<?php $this->load->view("auth/auth_header") ?>
<?php $this->load->view("auth/auth_nav") ?>
<style>
  .bg-login-image {
    background-image: url(<?= base_url('assets/SBAdmin2/img/loginbaru.jpg') ?>);
  }
</style>
<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                  <?= $this->session->flashdata('message') ?>
                  <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                </div>
                <form class="user" action="<?= base_url('auth/login') ?>" method="POST">
                
                  <div class="form-group">
                    <input type="email" required name="email" class="form-control form-control-user" value="<?= set_value('email') ?>" id="email" placeholder="Email Address...">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <input type="password" required name="password" class="form-control form-control-user" id="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                    Login
                  </button>
                  <hr>
                </form>
                <!-- <div class="text-center">
                  <a class="small" href="forgot-password.html">Lupa Kata Sandi?</a>
                </div> -->
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth/register') ?>">Buat Akun Baru!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<?php $this->load->view("auth/auth_footer") ?>