<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="<?= base_url('assets/SBAdmin2/img/') ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url('assets/SBAdmin2/img/') ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <title><?= $title ?></title>
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
          <div class="card text-center">
            <div class="card-header"> Konfirmasi Pengaktifan Akun</div>
            <div class="card-body">
              <h5 class="card-title">Anda akan mengkonfirmasi pengaktifan akun <br>
              dengan Email <b style="color: #6D8EE8"><?= $email ?></b> dan Nama Akun <b style="color: #EB51B8"><?= $nama ?></b></h5>
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal_konfirmasi">Konfirmasi</a>
            </div>
            <div class="card-footer text-muted"><?= APP_NAME ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="modal_konfirmasi">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Peringatan!</h5> <button type="button" class="close" data-dismiss="modal"> <span>×</span> </button>
        </div>
        <div class="modal-body">
          <p contenteditable="true">Anda akan mengaktifkan ulang akun anda.</p>
        </div>
        <div class="modal-footer"> <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button> 
        <a href="<?= base_url('aktifkan_akun/prosses/'.$token) ?>"><button type="button" class="btn btn-secondary">Setuju</button></a> </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
