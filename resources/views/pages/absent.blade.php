@extends('layouts.main')
@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Absen</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Absen saya</b></h3> <small>( {{$today_date}} )</small>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="myApp" ng-controller="absent_controller">
							<div class="pull-left col-xs-12 col-sm-4 col-md-3 col-lg-3" style="padding-left:0px;padding-right:0px;margin-top:3px;">
								<a href='#add' data-toggle='modal'><span class='btn btn-info btn-sm'><span class="glyphicon glyphicon-plus"></span> Tambah Absen</span></a>
							</div>
							<div class="pull-right col-xs-12 col-sm-8 col-md-3 col-lg-3" style="padding-right:0px;padding-left:0px;margin-top:3px;">
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-search"></i></div>
									<input type="text" class="form-control" placeholder="Masukan nama lokasi" ng-model="search.Lokasi">
								</div>      
							</div>
						<br/>
						<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>
									<a href="#" ng-click="sortType = 'Lokasi'; sortReverse = !sortReverse" style="text-decoration:none;color:black;">
									Lokasi
									<span ng-show="sortType == 'Lokasi' && !sortReverse" class="fa fa-caret-down"></span>
									<span ng-show="sortType == 'Lokasi' && sortReverse" class="fa fa-caret-up"></span>
									</a>
								</th>
								<th>
									<a href="#" ng-click="sortType = 'Waktu_masuk'; sortReverse = !sortReverse" style="text-decoration:none;color:black;">
									Waktu Masuk
									<span ng-show="sortType == 'Waktu_masuk' && !sortReverse" class="fa fa-caret-down"></span>
									<span ng-show="sortType == 'Waktu_masuk' && sortReverse" class="fa fa-caret-up"></span>
									</a>
								</th>
								<th>
									<a href="#" ng-click="sortType = 'Waktu_pulang'; sortReverse = !sortReverse" style="text-decoration:none;color:black;">
									Waktu Pulang
									<span ng-show="sortType == 'Waktu_pulang' && !sortReverse" class="fa fa-caret-down"></span>
									<span ng-show="sortType == 'Waktu_pulang' && sortReverse" class="fa fa-caret-up"></span>
								</th>
								</a>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@if(empty(json_decode($data_absent_json, true)))
								<tr>
									<td colspan="4"><center>Tidak ada data</center></td>
								</tr>
							@else
								<tr ng-repeat="x in data | orderBy:sortType:sortReverse | filter:search:strict">
									<td>@{{ x.Lokasi }}</td>
									<td>@{{ x.Waktu_masuk }}</td>
									<td>@{{ x.Waktu_pulang }}</td>
									<td>
									<a ng-if="x.Waktu_pulang == '00:00:00'" class="btn-sm btn-info" href="absent/@{{ x.Absensi_ID }}">Pulang</a>
									</td>
								</tr>	
							@endif
						</tbody>
						</table>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
		
		<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Tambah Absen</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(array('name' => 'absen_form', 'action' => 'AbsentController@add_absent')) !!}
				<?php
					$error = Session::get('error_absen');
					if(!empty($error)){
				?>
						@if ($error == "Success Absen !")
							<div class="alert alert-success alert-dismissible" role="alert">
						@else
							<div class="alert alert-danger alert-dismissible" role="alert">
						@endif
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?=$error?>
					</div>
				<?php
					Session::forget('error_absen');
					}
				?>
					<div class="form-group">
						<div class="form-inline">
						<label>Nama Karyawan</label>
						</div>
						<input type="text" class="form-control" value="{{Session::get('user_login_data')->Nama_karyawan}}" disabled>
					</div>
					<div class="form-group">
						<label>Tipe Absen</label>
						<select class="form-control" name="absen_type_text">
						<option value="Masuk" selected>Masuk</option>
						<option value="Cuti">Cuti</option>
						<option value="Sakit">Sakit</option>
						</select>
					</div>
					<div class="form-group">
						<div class="form-inline">
						<label>Lokasi</label>
						</div>
						<select class="form-control" onchange="check_location()" id="location_text" name="location_text">
							<option value="Kirana Office">Kirana Office</option>
							<option value="Riviera Office">Riviera Office</option>
							@foreach ($data_project as $project)
								<option value="{{$project->Nama_project}}">{{$project->Nama_project}}</option>
							@endforeach
							<option value="other">Other</option>
						</select>
						<div id="other_box" class="other_box">
						
						</div>
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<textarea class="form-control" name="keterangan_text" rows="3" placeholder="Masukan Keterangan anda . . ." style="resize:none;"></textarea>
					</div>
					<hr>
					<div id="location_hidden"></div>
					<center><button type="submit" class="btn btn-info">Submit</button></center>
				{!! Form::close() !!}
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		</section>

		<script>
			//to get latitude and longitude, script from w3school
			window.onload = getLocation;
			var x = document.getElementById("location_hidden");
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				} else { 
					x.innerHTML = "Geolocation is not supported by this browser.";
				}
			}
			
			function showPosition(position) {
				x.innerHTML = "<input type='hidden' name='latitude_text' value='" + position.coords.latitude + "' /> <input type='hidden' name='longitude_text' value='" + position.coords.longitude +"' />";	
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
			
			var app = angular.module('myApp', []);
			app.controller('absent_controller', function($scope) {
				$scope.sortType     = ''; // set the default sort type
				$scope.sortReverse  = false;  // set the default sort order (True = asc)
				
				//json tidak bisa menggunakan {{}} karena terdapat quote ( " )
				$scope.data = <?=$data_absent_json?>;			
			});
			
			$(document).ready(check_location()); 
		</script>
	</div>
@stop

