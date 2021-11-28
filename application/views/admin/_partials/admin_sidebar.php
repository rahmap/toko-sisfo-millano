<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

<?php if($this->session->level == 'Admin'): ?>
	<div class="menu_section">
	<h3>General</h3>
	<ul class="nav side-menu">
	<li><a href="<?= base_url('dashboard/admin') ?>"><i class="fa fa-bars"></i> Dashboard </a>
		<li><a><i class="fa fa-home"></i> Data Pelanggan <span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
			<li><a href="<?= base_url('dashboard/admin/data_customers') ?>">List Pelanggan</a></li>
		</ul>
		<li><a><i class="fa fa-edit"></i> Data Segmentasi <span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
			<li><a href="<?= base_url('dashboard/segmentasi/create_segment') ?>">Buat Segmen</a></li>
			<li><a href="<?= base_url('dashboard/segmentasi/get_list_segment') ?>">Daftar Segmen</a></li>
			<li><a href="<?= base_url('dashboard/pesan/get_list_pesan') ?>">Daftar Pesan</a></li>
		</ul>
		</li>
		</li>
		<li><a><i class="fa fa-edit"></i> Data Produk <span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
			<li><a href="<?= base_url('dashboard/admin/data_product') ?>">List Produk</a></li>
			<li><a href="<?= base_url('dashboard/admin/add_product') ?>">Tambah Produk</a></li>
			<li><a href="<?= base_url('dashboard/admin/add_tag') ?>">Data Tag Produk</a></li>
			<li><a href="<?= base_url('dashboard/admin/add_category') ?>">Data Kategori Produk</a></li>
		</ul>
		</li>
		<li><a><i class="fa fa-desktop"></i> Data Orders <span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
			<li><a href="<?= base_url('dashboard/admin/data_orders') ?>">List Orders</a></li>
			<li><a href="<?= base_url('dashboard/admin/orders_pengiriman') ?>">Orders (pengiriman)</a></li>
			<li><a href="<?= base_url('dashboard/admin/orders_done') ?>">Orders (sudah selesai)</a></li>
		</ul>
		</li>
	</ul>
	</div>
		<?php endif; ?>
<?php if($this->session->level == 'Owner'): ?>
	<div class="menu_section">
	<h3>Owner</h3>
	<ul class="nav side-menu">
		<li><a><i class="fa fa-edit"></i> Data Segmentasi <span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
			<li><a href="<?= base_url('dashboard/segmentasi/create_segment') ?>">Buat Segmen</a></li>
			<li><a href="<?= base_url('dashboard/segmentasi/get_list_segment') ?>">Daftar Segmen</a></li>
			<li><a href="<?= base_url('dashboard/pesan/get_list_pesan') ?>">Daftar Pesan</a></li>
		</ul>
		</li>
		<li><a><i class="fa fa-edit"></i> Data Admin <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url('dashboard/admin/data_admin') ?>">List Admin</a></li>
				<li><a href="<?= base_url('dashboard/admin/tambah_admin') ?>">Tambah Admin</a></li>
			</ul>
		</li>
		<li><a><i class="fa fa-edit"></i> Laporan <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url('dashboard/admin/laporan_penjualan') ?>">Penjualan</a></li>
				
			</ul>
		</li>
	</ul>
	</div>
<?php endif; ?>
	<div class="menu_section">
	<h3>Akun</h3>
	<ul class="nav side-menu">
		<li><a href="<?= base_url('dashboard/admin/pengaturan') ?>"><i class="fa fa-bug"></i> Pengaturan</span></a>
		</li>
	</ul>
	</div>

</div>