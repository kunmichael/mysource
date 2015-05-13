<?php 
	$header_jadwal_object = new \App\Model\Header_jadwal(); 
	$schedule_count = $header_jadwal_object::where('Laporan_selesai','=','0')->count();
	$schedule_data = $header_jadwal_object::where('Laporan_selesai','=','0')->orderBy('Tanggal_jadwal', 'ASC')->take(5)->get();
?>
<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	<span class="sr-only">Toggle navigation</span>
  </a>
  
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
	<ul class="nav navbar-nav">
	@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 2 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
	<!-- Notification Menu -->
	<li class="dropdown notifications-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  <i class="fa fa-bell-o"></i>
		  <span class="label label-warning">{{ $schedule_count != 0 ? $schedule_count : '' }}</span>
		</a>
		@if($schedule_count != 0)
		<ul class="dropdown-menu">
		  <li class="header"><b>{{$schedule_count}} Schedule didn't have reports</b></li>
		  <li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
				@foreach($schedule_data as $row)
					<li>
						<a href="#">
						  <i class="fa fa-code-fork text-aqua"></i> {{$row->Subjek}}
						</a>
					</li>
				@endforeach
			</ul>
		  </li>
		  <li class="footer"><a href="/public/schedule">View all</a></li>
		</ul>
		@endif
	</li>
	@endif
	
	<!-- User Account Menu -->
	<li class="dropdown user user-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="hidden-xs">{{Session::get('user_login_data')->Nama_karyawan}}</span>
			<i class="caret"></i>
		</a>
		<ul class="dropdown-menu">
			<li class="user-header">
				@if (Session::get('user_login_data')->Jenis_kelamin == 'Pria')
					<img src="/public/img/icon/male.png" class="img-circle" alt="User Image" />
				@else
					<img src="/public/img/icon/female.png" class="img-circle" alt="User Image" />
				@endif
				
				<p>
					{{Session::get('user_login_data')->Nama_karyawan}}
				</p>
				<p>
				{{Session::get('user_login_data')->jabatan->Nama_jabatan}}
				</p>
			</li>
			<li class="user-footer">
				<div class="pull-left">
					<a href="/public/profile" class="btn btn-default btn-flat">Profile</a>
				</div>
				<div class="pull-right">
					<a href="/public/signout" class="btn btn-default btn-flat">Sign out</a>
				</div>
			</li>
		</ul>
	</li>
	<!-- End of user account -->
	</ul>
  </div>
</nav>
<!--END of Header Navbar-->