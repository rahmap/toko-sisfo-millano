<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Prosses Pengaktifan Akun</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body>
<?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
<?php else: ?>
<?php redirect('home') ?>
<?php endif; ?>
</body>
</html>