<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="<?= base_url('assets/SBAdmin2/img/') ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url('assets/SBAdmin2/img/') ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <title><?= APP_NAME ?> - Error</title>
</head>

<body>
  <nav class="navbar navbar-light">
    <div class="container"> <a class="navbar-brand text-primary" href="<?= base_url('home') ?>">
        <i class="fa d-inline fa-lg fa-circle"></i>
        <b> <?= APP_NAME ?></b>
      </a> 
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <div class="alert alert-danger" role="alert">
              <b class="alert-link">Terjadi kesalahan</b> saat mengaktifkan ulang akun, token salah atau token sudah kadaluwarsa! Silahkan hubungi contact support.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
