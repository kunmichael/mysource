<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Head ( .CSS ) -->
	@include('includes.head')
	<!--END of Head-->
	
	<!--Script-->
	@include('includes.js')
	<!--END of Script-->
</head>
<body class="skin-black">
<!-- Wrapper -->
<div class="wrapper">

	<!-- Main Header -->
	<header class="main-header">
		<!-- Logo -->
		<a href="home" class="logo"><b>Miland Group</b></a>
		
		<!-- Header Navbar -->
		@include('includes.header')
		<!--END of Header Navbar-->
	</header>
	<!-- End of Main Header -->

	<!-- Sidebar -->
	@include('includes.sidebar')
	<!--End of Sidebar-->

	<!-- Content -->
	@yield('content')
	<!-- END of Content -->

    <!-- Sidebar -->
	@include('includes.footer')
	<!--End of Sidebar-->

</div> 
<!-- End of wrapper -->
</body>
</html>

