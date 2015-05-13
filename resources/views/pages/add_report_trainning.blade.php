@extends('layouts.main')
@section('content')
	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::style('fancybox/fancybox_source/jquery.fancybox.css?v=2.1.5') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		{!! HTML::script('fancybox/fancybox_source/jquery.fancybox.js?v=2.1.5') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Form Laporan Trainning</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Laporan Trainning</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'trainning_form', 'action' => 'TrainningController@add_trainning_report')) !!}
						<div class="form-group">
							<label>Subjek Jadwal</label>
							<input type="text" class="form-control" value="{{$jadwals->Subjek}}" readonly/>
						</div>
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" value="{{Session::get('user_login_data')->Nama_karyawan}}" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Subject_text.$invalid && !trainning_form.Subject_text.$pristine ) || trainning_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Subject_text.$error.required && !trainning_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Subject_text.$error.minlength">Minimal 3 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Subject_text');?></label>
							</div>
							<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Location_text.$invalid && !trainning_form.Location_text.$pristine ) || trainning_form.Location_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Lokasi</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Location_text.$error.required && !trainning_form.Location_text.$pristine">Location is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Location_text.$error.minlength">Minimal 3 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Location_text');?></label>
							</div>
							<input type="text" id="Location_text" class="form-control" placeholder="Masukan lokasi trainning" name="Location_text" ng-model="Location_text" ng-minlength="3" required/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Trainning_date.$invalid && !trainning_form.Trainning_date.$pristine ) || trainning_form.Trainning_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Training</label>
							<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_date.$error.required && !trainning_form.Trainning_date.$pristine">Trainning date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_date.$error.minlength || trainning_form.Trainning_date.$error.maxlength">Must 10 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('Trainning_date');?></label>
							</div>
							<input type="text" id="Trainning_date" class="form-control" placeholder="Tanggal mengikuti trainning" name="Trainning_date" ng-model="Trainning_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Start_time.$invalid && !trainning_form.Start_time.$pristine ) || trainning_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.required && !trainning_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Start_time');?></label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.End_time.$invalid && !trainning_form.End_time.$pristine ) || trainning_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.required && !trainning_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.maxlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('End_time');?></label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Trainning_result_text.$invalid && !trainning_form.Trainning_result_text.$pristine ) || trainning_form.Trainning_result_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Hasil Trainning</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_result_text.$error.required && !trainning_form.Trainning_result_text.$pristine">Trainning result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_result_text.$error.minlength">Minimal 5 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('Trainning_result_text');?></label>
							</div>
							<textarea class="form-control" id="Trainning_result_text" rows="10" placeholder="Masukan hasil trainning" style="resize:none;" name="Trainning_result_text" ng-model="Trainning_result_text" ng-minlength="5" required></textarea>
						</div>
						<div class="form-group">
								<label>Nama Peserta</label><br/>
								<?php
									$no = 1;
									$data_checked = Session::get('data_checked');
									Session::forget('data_checked');
								?>
								@foreach ($karyawans as $karyawan)
									@if($karyawan->Karyawan_ID != 1)
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked[$no] == 1) ? 'checked': ''; ?>/> {{$karyawan->Nama_karyawan}} <br/>
									<?php
										$no++;
									?>
									@endif
								@endforeach
								<input type="hidden" name="no" value="{{$no}}">
						</div>
						<hr>
						<input type="hidden" name="Karyawan_ID" value="{{Session::get('user_login_data')->Karyawan_ID}}">
						<input type="hidden" name="Jadwal_ID" value="{{$jadwals->Jadwal_ID}}">
						<center><button type="submit" ng-disabled="trainning_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Gambar Laporan Instalasi</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php $trainning_image_object = new \App\Model\Trainning_image()?>	
					@foreach($details as $row)
					<td>
					<a class="fancybox-effects-c" href="http://miland.asia/asset/images/project/{{$trainning_image_object::find($row->Training_image_ID)->Nama_gambar_training}}">
						{!! HTML::image('http://miland.asia/asset/images/project/'.$trainning_image_object::find($row->Training_image_ID)->Nama_gambar_training, 'Loading image', array('width'=>'200px', 'height'=>'200px')) !!}
					</a>
					@endforeach
				</div>
				</div>
			</div>
		</section>
		
		<?php
			$error = Session::get('error_trainning');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_trainning');
			}
		?>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
			
			$( "#Trainning_date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Subject_text = '{!!Form::old('Subject_text')!!}';
				$scope.Location_text = '{!!Form::old('Location_text')!!}';
				$scope.Trainning_date = '{!!Form::old('Trainning_date')!!}';
				$scope.Start_time = '{!!Form::old('Start_time')!!}';
				$scope.End_time = '{!!Form::old('End_time')!!}';
				$scope.Trainning_result_text = '{!!Form::old('Trainning_result_text')!!}';
			})
			
			$(document).ready(function() {
				$('.fancybox').fancybox();

				// Set custom style, close if clicked, change title type and overlay color
				$(".fancybox-effects-c").fancybox({
						wrapCSS    : 'fancybox-custom',
						closeClick : true,

						openEffect : 'none',

						helpers : {
							title : {
								type : 'inside'
							},
							overlay : {
								css : {
									'background' : 'rgba(238,238,238,0.85)'
								}
							}
						}
					});
			});
		</script>
	</div>
@stop

