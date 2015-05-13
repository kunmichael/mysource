<!-- Sidebar -->
<aside class="main-sidebar">
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li><a href="/public/home"><span><i class="fa fa-home"></i> Home</span></a></li>
			<li class="treeview">
				<a href="#"><span><i class="fa fa-plus-square-o"></i> Absen</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="/public/absent"><span class="glyphicon glyphicon-modal-window"></span> Absen</a></li>
					@if(Session::get('user_login_data')->Jabatan_ID == "1" || Session::get('user_login_data')->Jabatan_ID == "4" || Session::get('user_login_data')->Jabatan_ID == "5")
					<li><a href="/public/data_absent"><i class="fa fa-bar-chart-o"></i> Data Absen</a></li>
					<li><a href="/public/rekap_absent"><i class="fa fa-bar-chart-o"></i> Rekap Absen</a></li>
					@endif
				</ul>
            </li>
			@if(Session::get('user_login_data')->Jabatan_ID == "1" || Session::get('user_login_data')->Jabatan_ID == "3" || Session::get('user_login_data')->Jabatan_ID == "4")
			<li class="treeview">
				<a href="#"><span><i class="fa fa-calendar"></i> Jadwal</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					@if(Session::get('user_login_data')->Jabatan_ID == "1" || Session::get('user_login_data')->Jabatan_ID == "3" || Session::get('user_login_data')->Jabatan_ID == "4")
					<li><a href="/public/schedule"><i class="fa fa-calendar"></i> Jadwal</a></li>
					@endif
				</ul>
            </li>
			@endif
			<li class="treeview">
				<a href="#"><span><span class="glyphicon glyphicon-book"></span> Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="/public/instalation"><span class="glyphicon glyphicon-hdd"></span> Laporan Instalasi</a></li>
					<li><a href="/public/maintenance"><span class="glyphicon glyphicon-hdd"></span> Laporan Maintenance</a></li>
					<li><a href="/public/trainning"><span class="glyphicon glyphicon-hdd"></span> Laporan Trainning</a></li>
					<li><a href="/public/troubleshoot"><span class="glyphicon glyphicon-hdd"></span> Laporan Troubleshoot</a></li>
				</ul>
            </li>
			<li class="treeview">
				<a href="#"><span><i class="fa fa-file"></i> Berkas</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="/public/file_pdf"><i class="fa fa-file"></i> PDF</a></li>
					<li><a href="/public/file_images"><i class="fa fa-picture-o"></i> Gambar</a></li>
				</ul>
            </li>
		</ul>
		<!-- END of sidebar-menu -->
	</section>
</aside>
<!--End of Sidebar-->
