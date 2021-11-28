<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

	<div class="menu_section">
		<h3>General</h3>
		<ul class="nav side-menu">
			<li><a href="<?= base_url('dashboard/customers') ?>"><i class="fa fa-bars"></i> Dashboard</a>
			<li><a><i class="fa fa-edit"></i> Data Pemesanan <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url('dashboard/customers/data_orders') ?>">List Pemesanan</a></li>
				<li><a href="<?= base_url('dashboard/customers/data_pengiriman') ?>">List Pemesanan (pengiriman)</a></li>
			</ul>
			</li>
		</ul>
	</div>

	<div class="menu_section">
	<h3>Akun</h3>
	<ul class="nav side-menu">
		<li><a href="<?= base_url('dashboard/customers/pengaturan') ?>"><i class="fa fa-bug"></i> Pengaturan</span></a>
		</li>
	</ul>
	</div>

</div>