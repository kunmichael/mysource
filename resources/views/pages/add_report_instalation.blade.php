@extends('layouts.main')
@section('content')
	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Form Laporan Instalasi</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Laporan Instalasi</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'instalation_form', 'action' => 'InstalationController@add_instalation_report')) !!}
						<div class="form-group">
							<label>Subjek Jadwal</label>
							<input type="text" class="form-control" value="{{$jadwals->Subjek}}" readonly/>
						</div>
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" value="{{Session::get('user_login_data')->Nama_karyawan}}" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Subject_text.$invalid && !instalation_form.Subject_text.$pristine ) || instalation_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Subject_text.$error.required && !instalation_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Subject_text.$error.minlength">Minimal 3 character.</label>
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
						<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Instalation_date.$invalid && !instalation_form.Instalation_date.$pristine ) || instalation_form.Instalation_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Instalasi</label>
							<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_date.$error.required && !instalation_form.Instalation_date.$pristine">Instalation date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_date.$error.minlength || instalation_form.Instalation_date.$error.maxlength">Must 10 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('Instalation_date');?></label>
							</div>
							<input type="text" id="Instalation_date" class="form-control" placeholder="Tanggal mengikuti instalasi" name="Instalation_date" ng-model="Instalation_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Start_time.$invalid && !instalation_form.Start_time.$pristine ) || instalation_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.required && !instalation_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Start_time');?></label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.End_time.$invalid && !instalation_form.End_time.$pristine ) || instalation_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.required && !instalation_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('End_time');?></label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Instalation_result_text.$invalid && !instalation_form.Instalation_result_text.$pristine ) || instalation_form.Instalation_result_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Hasil Pekerjaan</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_result_text.$error.required && !instalation_form.Instalation_result_text.$pristine">Instalation result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_result_text.$error.minlength">Minimal 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Instalation_result_text');?></label>
							</div>
							<textarea class="form-control" id="Instalation_result_text" rows="10" placeholder="Masukan hasil trainning" style="resize:none;" name="Instalation_result_text" ng-model="Instalation_result_text" ng-minlength="5" required></textarea>
						</div>
						<div class="form-group">
							<label>Kendala</label>
							<textarea class="form-control" id="Problem_text" rows="10" placeholder="Masukan Kendala bila ada" style="resize:none;" name="Problem_text">{!!Form::old('Problem_text')!!}</textarea>
						</div>
						<div class="form-group">
							<label>Tanggal Menjalankan Agenda selanjutnya</label>
							<input type="text" id="Next_agenda_date" class="form-control" placeholder="Masukan tanggal agenda selanjutnya bila ada" name="Next_agenda_date" value="{!!Form::old('Next_agenda_date')!!}"/>	
						</div>
						<div class="form-group">
							<label>Agenda Pekerjaan Selanjutnya</label>
							<textarea class="form-control" id="Next_agenda" rows="10" placeholder="Masukan Agenda selanjutnya bila ada" style="resize:none;" name="Next_agenda">{!!Form::old('Next_agenda')!!}</textarea>
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
						<center><button type="submit" ng-disabled="instalation_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
			</div>
		</section>
		
		<?php
			$error = Session::get('error_instalation');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_instalation');
			}
		?>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
			
			$( "#Instalation_date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			$( "#Next_agenda_date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Subject_text = '{!!Form::old('Subject_text')!!}';
				$scope.Instalation_date = '{!!Form::old('Instalation_date')!!}';
				$scope.Start_time = '{!!Form::old('Start_time')!!}';
				$scope.End_time = '{!!Form::old('End_time')!!}';
				$scope.Instalation_result_text = '{!!Form::old('Instalation_result_text')!!}';
			})
		</script>
	</div>
@stop

