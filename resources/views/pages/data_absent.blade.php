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
		$error = Session::get('error_absent');
		if(!empty($error)){
	?>
		<script>
			alert('{{$error}}');
		</script>
	<?php
		Session::forget('error_absent');
		}
	?>

	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Data absen</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Data absen</b></h3> <small><a href="#add_absent" data-toggle='modal'><span class="glyphicon glyphicon-plus"></span></a></small>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						<table id="data_absent" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Lokasi</th>
									<th>Tanggal</th>
									<th>Waktu Datang</th>
									<th>Waktu Pulang</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
							<?php $karyawan_object = new \App\Model\Karyawan(); ?>
								@foreach($absents as $row)
								<tr>
									<td>{{ $karyawan_object::find($row->Karyawan_ID)->Nama_karyawan }}</td>
									<td>{{ $row->Lokasi }}</td>
									<td>{{ change_date($row->Tanggal_absen) }}</td>
									<td>{{ $row->Waktu_masuk }}</td>
									<td>
										@if($row->Waktu_pulang != "")
											{{ $row->Waktu_pulang }}
										@else
											00:00:00
										@endif
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												Aksi <span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right" role="menu">
												@if($row->Geo_location != "")
												<?php
													$coordinate = explode('=', $row->Geo_location);
													$latitude = $coordinate[0];
													$longitude = $coordinate[1];
												?>
												<li>
													<a href="#show_map" data-toggle='modal' onclick="show_map({{$latitude}}, {{$longitude}})"><i class="fa fa-map-marker" style="color:red;"></i>Peta</a>
												</li>
												@endif
												@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5)
													<li>
													<a href="#edit_absent" data-toggle='modal' onclick="edit_absent({{ $row->Absensi_ID }})"><i class="fa fa-edit" style="color:green;"></i>Ubah</a>
													</li>
												@endif
												@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 4 || Session::get('user_login_data')->Jabatan_ID == 5)
													<li>
													<a href="delete_absent/{{ $row->Absensi_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
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
		
			<div class="modal fade" id="edit_absent" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ubah Absen</h4>
				</div>
				<div class="modal-body">
					<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_edit_absent')) !!}</center>
					<div id="response_edit_absent"></div> <!--untuk menaruh hasil response-->
				</div>
			</div>
			</div>
			</div>

			<div class="modal fade" id="show_map" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Peta</h4>
				</div>
				<div class="modal-body">
					<center>
						<div id="mapholder"></div>						
					</center>	
				</div>
			</div>
			</div>
			</div>
			
			<div class="modal fade" id="add_absent" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tambah Absen</h4>
				</div>
				<div class="modal-body">
					{!! Form::open(array('name' => 'absen_form', 'action' => 'AbsentController@add_absent_manual')) !!}
						<div class="form-group">
							<div class="form-inline">
							<label>Nama Karyawan</label>
							</div>
							<select class="form-control" name="karyawan_id_text">
								@foreach($karyawans as $karyawan)
									@if($karyawan->Jabatan_ID != "1" && $karyawan->Jabatan_ID != "10")
										<option value="{{$karyawan->Karyawan_ID}}">{{$karyawan->Nama_karyawan}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Tipe Absen</label>
							<select class="form-control" name="absen_type_text">
							<option value="Masuk">Masuk</option>
							<option value="Cuti">Cuti</option>
							<option value="Sakit">Sakit</option>
							</select>
						</div>
						<div class="form-group">
							<label>Tanggal Absen</label>
							<input type="text" id="datepicker" class="form-control" name="tanggal_jadwal_text"/>
						</div>
						<div class="form-group">
							<label>Lokasi</label>
							<select class="form-control" onchange="check_location()" id="location_text" name="location_text">
								<option value="Kirana Office">Kirana Office</option>
								<option value="Riviera Office">Riviera Office</option>
								@foreach ($projects as $project)
									<option value="{{$project->Nama_project}}">{{$project->Nama_project}}</option>
								@endforeach
								<option value="other">Other</option>
							</select>
							<div id="other_box" class="other_box">
							
							</div>
						</div>
						<div class="form-group">
							<label>Waktu Datang</label>
							<input type="text" class="form-control" name="Waktu_datang_text">
						</div>
						<div class="form-group">
							<label>Waktu Pulang</label>
							<input type="text" class="form-control" name="Waktu_pulang_text">
						</div>
						<div class="form-group">
							<label>Keterangan</label>
							<textarea class="form-control" name="keterangan_text" rows="3" placeholder="Masukan Keterangan anda . . ." style="resize:none;"></textarea>
						</div>
						<div class="form-group">
							<label>Keterangan Pulang</label>
							<textarea class="form-control" name="keterangan_pulang_text" rows="3" placeholder="Masukan Keterangan anda . . ." style="resize:none;"></textarea>
						</div>
						<hr>
						<center><button type="submit" class="btn btn-info">Submit</button></center>
					{!! Form::close() !!}
				</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</section>
		
		<script>
			//untuk datepicker
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;

			//variable untuk menampung data map
			var lat = "";
			var longi = "";
			var global_map;
			
			$("#data_absent").dataTable({
				"bPaginate": true,
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aaSorting": []
			});

			$( "#datepicker" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			function edit_absent(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_edit_absent').hide();
						$('#loading_edit_absent').show();
					},
					complete: function() {
						$('#loading_edit_absent').hide();
						$('#response_edit_absent').show();
					},
					success: function() {
						$('#loading_edit_absent').hide();
						$('#response_edit_absent').show();
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
							document.getElementById("response_edit_absent").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_edit_absent/"+ID,true);
					xmlhttp.send();
				}
			}
			
			function check_location(){
				var e = document.getElementById("location_text");
				var location_value_selected = e.options[e.selectedIndex].value;
				document.getElementById("other_box").innerHTML="";
				
				if(location_value_selected == "other"){
					var btn = document.createElement("input");
					btn.type = "text";
					btn.placeholder = "Masukan nama lokasi . . .";
					btn.style= "margin-top:2px;";
					btn.name = "other_location";
					btn.setAttribute("class", "form-control");
					btn.setAttribute("ng-minlength", "3");
					btn.setAttribute("required","true");
					var t = document.createTextNode("");
					btn.appendChild(t);
					document.getElementById("other_box").appendChild(btn);
				}
			}

			function show_map(latitude, longitude) {
			    if(latitude == "" || longitude == ""){	
			    	alert("you don't have latitude and longitude");
			    }
			    else{
			    	lat = latitude;
			    	longi = longitude;
			    	latlon = new google.maps.LatLng(latitude, longitude)
				    mapholder = document.getElementById('mapholder')
				    mapholder.style.height = '250px';
				    mapholder.style.width = '500px';

				    var myOptions = {
					    center:latlon,zoom:14,
					    mapTypeId:google.maps.MapTypeId.ROADMAP,
					    mapTypeControl:false,
					    navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
				    }
				    
				    var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
				    var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
				    global_map = map;

			    }
			}

			$('#show_map').on('shown.bs.modal',function(){
		    	google.maps.event.trigger(global_map,'resize');
				global_map.setCenter(new google.maps.LatLng(lat, longi));
		    });

			$(document).ready(check_location()); 
		</script>
	</div>
@stop