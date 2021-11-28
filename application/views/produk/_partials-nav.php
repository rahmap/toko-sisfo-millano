  <!-- Navbar -->
  <style>
    .dropdown-menu {
      max-width: 750px !important;
      height: auto;

      /* height: 400px !important; */
    }
  </style>
  <style>
  .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: red;
    color: white;
    text-align: center;
  }
  </style>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container">

      <!-- Brand -->
      <a class="navbar-brand waves-effect" href="<?= base_url('home') ?>">
        <strong class="blue-text">Home</strong>
      </a>

      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left -->
        <ul class="navbar-nav mr-auto">

          <li class="nav-item">
            <div class="dropdown">
              <a href="<?= base_url('keranjang') ?>" target="_blank" class="nav-link waves-effect">
                <i class="fas fa-shopping-cart"></i>
                <span class="clearfix d-none d-sm-inline-block"> Keranjang </span>
                <span class="badge red z-depth-1 mr-1"> <?= count($this->cart->contents()); ?> </span>
              </a>
          </li>
        </ul>

        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <?php
          if (!$this->session->has_userdata('email')) {
            echo
              '<li class="nav-item mr-2">'; ?>
            <a href="<?= base_url('auth/register') ?>" class="nav-link border border-light rounded waves-effect">
              <i></i>Register
            </a>
          <?= '</li>';
          } ?>
          <?php
          if ($this->session->has_userdata('email')) {
            echo
              '<li class="nav-item mr-2">'; ?>
            <a href="
              <?= ($this->session->level == 'Member') ?  base_url('dashboard/customers') : base_url('dashboard/admin')
                ?>" class="nav-link border border-light rounded waves-effect" target="_blank">
              <i></i>Dashboard
            </a>
          <?= '</li>';
          } ?>
          <?php
          if ($this->session->has_userdata('email')) {
            echo
              '<li class="nav-item ">'; ?>
            <a href=" <?= base_url('auth/logout') ?> " class="nav-link border border-light rounded waves-effect">
              <i></i>Logout
            </a>
          <?= '</li>';
          } else {
            echo '<li class="nav-item ">'; ?>
            <a href="<?= base_url('auth/login') ?>" class="nav-link border border-light rounded waves-effect">
              <i></i>Login
            </a>
          <?= '</li>';
          }

          ?>

        </ul>

      </div>

    </div>
  </nav>
  <!-- Navbar -->