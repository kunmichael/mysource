@extends('layouts.main')
@section('content')
<?php
	function change_date($date){
		$exploded_date = explode('-',$date);
		$array = array($exploded_date[2],$exploded_date[1],$exploded_date[0]);
		$today_date = implode('-',$array);
		return $today_date;
	}
?>
	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<h1>Home</h1>
			<ol class="breadcrumb">
				<li><a href="/home"><i class="fa fa-home"></i> Home</a></li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Jadwal</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
							<table id="data_jadwal" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Nama Projek</th>
										<th>Subjek</th>
										<th>Nama Pembuat</th>
										<th>Tanggal</th>
										<th>Waktu</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								<?php $karyawan_object = new \App\Model\Karyawan(); ?>
									@foreach($jadwals as $row)
									<tr class="<?php echo ($row->Laporan_selesai == 0) ? 'danger': ''; ?>">
										<td>{{ $row->project->Nama_project }}</td>
										<td>{{ $row->Subjek }}</td>
										<td>{{ $row->Nama_pembuat }}</td>
										<td>{{ change_date($row->Tanggal_jadwal) }}</td>
										<td>{{ $row->Waktu_jadwal }}</td>
										<td>
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													Aksi <span class="caret"></span>
												</button>
												<ul class="dropdown-menu pull-right" role="menu">
														<li>
														@if($row->Laporan_selesai == 0 && $row->Jenis_laporan == "Instalasi")								
															<a href="instalation_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
														@elseif($row->Laporan_selesai == 0 && $row->Jenis_laporan == "Maintenance")
															<a href="maintenance_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
														@elseif($row->Laporan_selesai == 0 && $row->Jenis_laporan == "Troubleshoot")
															<a href="troubleshoot_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
														@else
															<a href="trainning_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>	
														@endif
														</li>
														<li>
														<a href="#detail_schedule" data-toggle='modal' onclick="detail_schedule({{ $row->Jadwal_ID }})"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail</a>
														</li>
														<li>
														<a href="#member_schedule" data-toggle='modal' onclick="detail_member({{ $row->Jadwal_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
														</li>
														@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
														<li>
														<a href="#edit_schedule" data-toggle='modal' onclick="edit_schedule({{ $row->Jadwal_ID }})"><i class="fa fa-edit"></i>Ubah</a>
														</li>
														<li>
														<a href="delete_schedule/{{ $row->Jadwal_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
														</li>
														@endif
												</ul>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- ./box-body -->
					</div><!-- /.box -->
				</div><!-- /.col -->
			</div><!-- /.row -->
			
			<div class="modal fade" id="detail_schedule" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Detail jadwal</h4>
				</div>
				<div class="modal-body">
					<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_detail_schedule')) !!}</center>
					<div id="response_detail_schedule"></div> <!--untuk menaruh hasil response-->
				</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			
			<div class="modal fade" id="edit_schedule" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ubah jadwal</h4>
				</div>
				<div class="modal-body">
					<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_edit_schedule')) !!}</center>
					<div id="response_edit_schedule"></div> <!--untuk menaruh hasil response-->
				</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</section>
		
		<div class="modal fade" id="member_schedule" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Member</h4>
			</div>
			<div class="modal-body">
				<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_member_schedule')) !!}</center>
				<div id="response_member_schedule"></div> <!--untuk menaruh hasil response-->
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<?php
			$error = Session::get('error_home');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_home');
			}
		?>
		
		<script>	
			$("#data_jadwal").dataTable({
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aaSorting": [],
			});
			
			function detail_schedule(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_detail_schedule').hide();
						$('#loading_detail_schedule').show();
					},
					complete: function() {
						$('#loading_detail_schedule').hide();
						$('#response_detail_schedule').show();
					},
					success: function() {
						$('#loading_detail_schedule').hide();
						$('#response_detail_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_detail_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_detail_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
			
			function edit_schedule(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_edit_schedule').hide();
						$('#loading_edit_schedule').show();
					},
					complete: function() {
						$('#loading_edit_schedule').hide();
						$('#response_edit_schedule').show();
					},
					success: function() {
						$('#loading_edit_schedule').hide();
						$('#response_edit_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_edit_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_edit_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
			
			function detail_member(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_member_schedule').hide();
						$('#loading_member_schedule').show();
					},
					complete: function() {
						$('#loading_member_schedule').hide();
						$('#response_member_schedule').show();
					},
					success: function() {
						$('#loading_member_schedule').hide();
						$('#response_member_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_member_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_detail_member_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
		</script>
	</div>
@stop

