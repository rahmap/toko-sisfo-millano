<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

	<div class="menu_section">
	<h3>General</h3>
	<ul class="nav side-menu">
		<li>
			<a href="<?= base_url('dashboard/master') ?>"><i class="fa fa-bars"></i> Dashboard </a>
		</li>
	</ul>
	</div>
	<?php if($this->session->level == 'Master'): ?>
	<div class="menu_section">
	<h3>Master</h3>
	<ul class="nav side-menu">
		<li><a><i class="fa fa-star-o"></i> Data Owner <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url('dashboard/master/tambah_owner') ?>">Tambah Owner</a></li>
				<li><a href="<?= base_url('dashboard/master/data_owner') ?>">List Owner</a></li>
			</ul>
		</li>
		<li><a><i class="fa fa-user"></i> Data Admin <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url('dashboard/master/tambah_admin') ?>">Tambah Admin</a></li>
				<li><a href="<?= base_url('dashboard/master/data_admin') ?>">List Admin</a></li>
			</ul>
		</li>
	</ul>
	</div>
	<?php endif; ?>
	<div class="menu_section">
	<h3>Akun</h3>
	<ul class="nav side-menu">
		<li><a href="<?= base_url('dashboard/master/pengaturan') ?>"><i class="fa fa-bug"></i> Pengaturan</span></a>
		</li>
	</ul>
	</div>

</div>
