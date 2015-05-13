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
	
	<?php
		$error = Session::get('error_troubleshoot');
		if(!empty($error)){
	?>
		<script>
			alert('{{$error}}');
		</script>
	<?php
		Session::forget('error_troubleshoot');
		}
	?>

	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Data troubleshoot</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Data Troubleshoot</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab">ALL <small class="label pull-right bg-blue" style="margin-left:5px;">{{$count_all_troubleshoots}}</small></a></li>
									<li><a href="#tab_2" data-toggle="tab">Approve <small class="label pull-right bg-green" style="margin-left:5px;">{{$count_approve_troubleshoots}}</small></a></li>
									<li><a href="#tab_3" data-toggle="tab">Need Approval <small class="label pull-right bg-red" style="margin-left:5px;">{{$count_need_approval_troubleshoots}}</small></a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<table id="all_troubleshoots" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Subjek</th>
													<th>Nama projek</th>
													<th>Tanggal Pekerjaan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$karyawan_object = new \App\Model\Karyawan(); 
													$project_object = new \App\Model\Project(); 
												?>
												@foreach($all_troubleshoots as $row)
												<tr class="<?php echo ($row->Approval == 0) ? 'danger': ''; ?>">
													<td>{{$karyawan_object::find($row->Karyawan_ID)->Nama_karyawan}}</td>
													<td>{{$row->Subject}}</td>
													<td>{{$project_object::find($row->Project_ID)->Nama_project}}</td>
													<td>{{change_date($row->Tanggal_pekerjaan)}}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																<?php $karyawan_object = new \App\Model\Karyawan();?>
																<li>
																	<a href="detail_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Laporan</a>
																</li>
																<li>
																	<a href="#detail_member" data-toggle='modal' onclick="detail_member({{ $row->Report_troubleshoot_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																</li>
																@if($row->Approval == 0)
																	<li>
																	<a href="approve_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-check"></i>Approve</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0 )
																	<li>
																	<a href="update_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-edit" style="color:green;"></i>Ubah</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 ) && $row->Approval == 1)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
															</ul>
														</div>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_2">
										<table id="approve_troubleshoots" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Subjek</th>
													<th>Nama projek</th>
													<th>Tanggal Pekerjaan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$karyawan_object = new \App\Model\Karyawan(); 
													$project_object = new \App\Model\Project(); 
												?>
												@foreach($approve_troubleshoots as $row)
												<tr>
													<td>{{$karyawan_object::find($row->Karyawan_ID)->Nama_karyawan}}</td>
													<td>{{$row->Subject}}</td>
													<td>{{$project_object::find($row->Project_ID)->Nama_project}}</td>
													<td>{{change_date($row->Tanggal_pekerjaan)}}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																<?php $karyawan_object = new \App\Model\Karyawan();?>
																<li>
																	<a href="detail_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Laporan</a>
																</li>
																<li>
																	<a href="#detail_member" data-toggle='modal' onclick="detail_member({{ $row->Report_troubleshoot_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																</li>
																@if($row->Approval == 0)
																	<li>
																	<a href="approve_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-check"></i>Approve</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0 )
																	<li>
																	<a href="update_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-edit" style="color:green;"></i>Ubah</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 ) && $row->Approval == 1)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
															</ul>
														</div>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab_3">
										<table id="need_approval_troubleshoots" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Subjek</th>
													<th>Nama projek</th>
													<th>Tanggal Pekerjaan</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$karyawan_object = new \App\Model\Karyawan(); 
													$project_object = new \App\Model\Project(); 
												?>
												@foreach($need_approval_troubleshoots as $row)
												<tr>
													<td>{{$karyawan_object::find($row->Karyawan_ID)->Nama_karyawan}}</td>
													<td>{{$row->Subject}}</td>
													<td>{{$project_object::find($row->Project_ID)->Nama_project}}</td>
													<td>{{change_date($row->Tanggal_pekerjaan)}}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																<?php $karyawan_object = new \App\Model\Karyawan();?>
																<li>
																	<a href="detail_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Laporan</a>
																</li>
																<li>
																	<a href="#detail_member" data-toggle='modal' onclick="detail_member({{ $row->Report_troubleshoot_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																</li>
																@if($row->Approval == 0)
																	<li>
																	<a href="approve_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-check"></i>Approve</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0 )
																	<li>
																	<a href="update_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-edit" style="color:green;"></i>Ubah</a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5 || Session::get('user_login_data')->Jabatan_ID == $karyawan_object::find($row->Karyawan_ID)->Jabatan_ID) && $row->Approval == 0)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
																@if((Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 ) && $row->Approval == 1)
																	<li>
																	<a href="delete_troubleshoot_report/{{ $row->Report_troubleshoot_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus </a>
																	</li>
																@endif
															</ul>
														</div>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div>

		<div class="modal fade" id="detail_member" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Detail member</h4>
			</div>
			<div class="modal-body">
				<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_detail_member')) !!}</center>
				<div id="response_detail_member"></div> <!--untuk menaruh hasil response-->
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</section>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
					
			$(function() {
				$( "#datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: yearFrom+":"+yearTo,
					dateFormat: "yy-mm-dd"
				});
			});
			
			$("#all_troubleshoots, #approve_troubleshoots, #need_approval_troubleshoots").dataTable({
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aaSorting": []
			});
			
			function detail_member(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_detail_member').hide();
						$('#loading_detail_member').show();
					},
					complete: function() {
						$('#loading_detail_member').hide();
						$('#response_detail_member').show();
					},
					success: function() {
						$('#loading_detail_member').hide();
						$('#response_detail_member').show();
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
							document.getElementById("response_detail_member").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_detail_member_report_instalation/"+ID,true);
					xmlhttp.send();
				}
			}
		</script>
	</div>
@stop