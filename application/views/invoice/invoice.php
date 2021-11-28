<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('admin/_partials/admin_header') ?>
</head>

<body class="nav-md">
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
        }
    </style>

    <!-- /top navigation -->

    <!-- page content -->
    <br>
    <div class="right_col" role="main">
        <!-- Mulai Konten -->
        <div class="">
            <div class="col-md-8 col-md-offset-2">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Invoice</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                          <i class="fa fa-money"></i> Invoice. 
                                      </h1>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <!-- /.col -->
                                <div class="col-sm-6 invoice-col">
                                    <address>
                                          <strong><?= ucwords($inv['nama_penerima']) ?></strong>
                                          <br><?= ucwords($inv['alamat_pengiriman']) ?>
                                          <br><?= $inv['kode_pos'] ?>, <?= strtoupper($inv['kurir']) ?> - <?= $inv['service'] ?>
                                          <br>Phone: <?= $inv['no_penerima'] ?>
                                          <br>Email: <?= $inv['email'] ?>
                                      </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6 invoice-col">
                                    <b>Info Pemesanan</b>
                                    <br>
                                    <br>
                                    <b>ID Pemesanan :</b> <span class="text-info"><?= $inv['id_orders'] ?></span>
                                    <br>
                                    <b>Payment Due :</b> <?= date('d/m/Y H:i',$inv['tanggal_order'] + 86400) ?><br>
                                    <?php
                                    $status;
                                        if($inv['status_order'] == 'pending')
                                            $status = 'warning';
                                        else if($inv['status_order'] == 'expire')
                                            $status = 'danger';
                                        else if($inv['status_order'] == 'settlement' OR $inv['status_order'] == 'Selesai')
                                        $status = 'success';
                                    ?>
                                    <b>Status :</b> <span class="label label-<?= $status ?>"><?= $inv['status_order'] ?></span>

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Harga/item (setelah diskon)</th>
                                                <th>Jumlah</th>
                                                <th>Diskon/item</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i = 0; $i < count($nama_produk_all); $i++){
                                                    echo '
                                                    <tbody>
                                                      <tr>
                                                        <td>'.$nama_produk_all[$i].' ('.$ukuran_produk_all[$i].')</td>
                                                        <td>Rp '.number_format($harga_produk_all[$i], 0, ',', '.').'</td>
                                                        <td>'.$qty_produk_all[$i].' item</td>
                                                        <td>'.$diskon_produk_all[$i].'%</td>
                                                        <td>Rp '.number_format($harga_produk_all[$i] * $qty_produk_all[$i], 0, ',', '.').'</td>
                                                      </tr>
                                                    </tbody>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">
                                    <p class="lead">Metode Pembayaran :</p>
                                    <?php $bank = explode('-', $inv['bank'])   ?>
                                    <img height="42" width="130" src="<?= base_url('assets/images/bank/'.strtolower($bank[0]).'.png') ?>" >
                                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        <?= (isset($bank[1]))? ucwords($bank[1]).' : <b>'.$bank[2].'</b><br>' : ''; ?>
                                        Virtual Akun : <b><?= $inv['va_number'] ?></b>
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">Info Biaya</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td>Rp <?= number_format($inv['total_harga_barang'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pengiriman :</th>
                                                    <td>Rp <?= number_format($inv['total_ongkir'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total:</th>
                                                    <td>Rp <?= number_format($inv['gross_amount'], 0, ',', '.') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row">
                                <div class="col text-center">
                                    <button class="btn btn-success pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Selesai Konten -->
    <!-- /page content -->

    <?php $this->load->view('admin/_partials/admin_js') ?>
</body>

</html>