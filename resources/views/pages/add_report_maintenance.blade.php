@extends('layouts.main')
@section('content')
	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Form Laporan Maintenance</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Laporan Maintenance</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'maintenance_form', 'action' => 'MaintenanceController@add_maintenance_report')) !!}
						<div class="form-group">
							<label>Subjek Jadwal</label>
							<input type="text" class="form-control" value="{{$jadwals->Subjek}}" readonly/>
						</div>
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" value="{{Session::get('user_login_data')->Nama_karyawan}}" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Subject_text.$invalid && !maintenance_form.Subject_text.$pristine ) || maintenance_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Subject_text.$error.required && !maintenance_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Subject_text.$error.minlength">Minimal 3 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Subject_text');?></label>
							</div>
							<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group">
						<label><b style="color:red;">*</b> Projek</label>
						<select class="form-control" name="Project_ID" id="Project_ID">
							<?php
								$project_selected = Session::get('project_selected');
								Session::forget('project_selected');
							?>
							@foreach ($projects as $project)
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $project_selected) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Maintenance_date.$invalid && !maintenance_form.Maintenance_date.$pristine ) || maintenance_form.Maintenance_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Maintenance</label>
							<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Maintenance_date.$error.required && !maintenance_form.Maintenance_date.$pristine">Instalation date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Maintenance_date.$error.minlength || maintenance_form.Maintenance_date.$error.maxlength">Must 10 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('Maintenance_date');?></label>
							</div>
							<input type="text" id="Maintenance_date" class="form-control" placeholder="Tanggal mengikuti maintenance" name="Maintenance_date" ng-model="Maintenance_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Start_time.$invalid && !maintenance_form.Start_time.$pristine ) || maintenance_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.required && !maintenance_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Start_time');?></label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.End_time.$invalid && !maintenance_form.End_time.$pristine ) || maintenance_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.required && !maintenance_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('End_time');?></label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.First_condition.$invalid && !maintenance_form.First_condition.$pristine ) || maintenance_form.First_condition.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi Awal</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.First_condition.$error.required && !maintenance_form.First_condition.$pristine">First condition result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.First_condition.$error.minlength">Minimal 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('First_condition');?></label>
							</div>
							<textarea class="form-control" id="First_condition" rows="10" placeholder="Masukan kondisi awal" style="resize:none;" name="First_condition" ng-model="First_condition" ng-minlength="5" required></textarea>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Last_condition.$invalid && !maintenance_form.Last_condition.$pristine ) || maintenance_form.Last_condition.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi Akhir</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Last_condition.$error.required && !maintenance_form.Last_condition.$pristine">Last condition is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Last_condition.$error.minlength">Minimal 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Last_condition');?></label>
							</div>
							<textarea class="form-control" id="Last_condition" rows="10" placeholder="Masukan kondisi terakhir" style="resize:none;" name="Last_condition" ng-model="Last_condition" ng-minlength="5" required></textarea>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.User_text.$invalid && !maintenance_form.User_text.$pristine ) || maintenance_form.User_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Nama User</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.User_text.$error.required && !maintenance_form.User_text.$pristine">User name is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.User_text.$error.minlength">Minimal 3 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('User_text');?></label>
							</div>
							<input type="text" id="User_text" class="form-control" placeholder="Masukan nama user" name="User_text" ng-model="User_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group">
								<label>Nama Peserta</label><br/>
								<?php
									$data_checked = Session::get('data_checked');
									Session::forget('data_checked');
									$no = 1;
								?>
								@foreach ($karyawans as $karyawan)
									@if($karyawan->Karyawan_ID != 1)
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked[$no] == 1) ? 'checked': ''; ?>/> {{$karyawan->Nama_karyawan}} <br/>
									<?php
										$no++;
									?>
									@endif
								@endforeach
						</div>
						<hr>
						<input type="hidden" name="no" value="{{$no}}">
						<input type="hidden" name="Karyawan_ID" value="{{Session::get('user_login_data')->Karyawan_ID}}">
						<input type="hidden" name="Jadwal_ID" value="{{$jadwals->Jadwal_ID}}">
						<center><button type="submit" ng-disabled="maintenance_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
			</div>
		</section>
		
		<?php
			$error = Session::get('error_maintenance');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_maintenance');
			}
		?>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
			
			$( "#Maintenance_date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Subject_text = '{!!Form::old('Subject_text')!!}';
				$scope.Maintenance_date = '{!!Form::old('Maintenance_date')!!}';
				$scope.Start_time = '{!!Form::old('Start_time')!!}';
				$scope.End_time = '{!!Form::old('End_time')!!}';
				$scope.First_condition = '{!!Form::old('First_condition')!!}';
				$scope.Last_condition = '{!!Form::old('Last_condition')!!}';
				$scope.User_text = '{!!Form::old('User_text')!!}';
			})
		</script>
	</div>
@stop

