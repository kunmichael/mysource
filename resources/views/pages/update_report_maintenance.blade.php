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
				<li class="active">Form Update Laporan Maintenance</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Update Laporan Maintenance</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'maintenance_form', 'action' => 'MaintenanceController@update_maintenance_report')) !!}
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" ng-model="Karyawan_name" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Subject_text.$invalid && !maintenance_form.Subject_text.$pristine ) || maintenance_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Subject_text.$error.required && !maintenance_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Subject_text.$error.minlength">Minimal 3 character.</label>
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
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $maintenances->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Maintenance_date.$invalid && !maintenance_form.Maintenance_date.$pristine ) || maintenance_form.Maintenance_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Maintenance</label>
							<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Maintenance_date.$error.required && !maintenance_form.Maintenance_date.$pristine">Instalation date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Maintenance_date.$error.minlength || maintenance_form.Maintenance_date.$error.maxlength">Must 10 character.</label>
							</div>
							<input type="text" id="Maintenance_date" class="form-control" placeholder="Tanggal mengikuti instalasi" name="Maintenance_date" ng-model="Maintenance_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.Start_time.$invalid && !maintenance_form.Start_time.$pristine ) || maintenance_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.required && !maintenance_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.Start_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.End_time.$invalid && !maintenance_form.End_time.$pristine ) || maintenance_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.required && !maintenance_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.End_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.First_condition.$invalid && !maintenance_form.First_condition.$pristine ) || maintenance_form.First_condition.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi awal</label>
							</div>
							<textarea class="form-control" id="First_condition" rows="10" placeholder="Masukan kondisi awal" style="resize:none;" name="First_condition">{{$maintenances->Kondisi_awal}}</textarea>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi Akhir</label>
							</div>
							<textarea class="form-control" id="Last_condition" rows="10" placeholder="Masukan kondisi terakhir" style="resize:none;" name="Last_condition">{{$maintenances->Kondisi_akhir}}</textarea>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( maintenance_form.User_text.$invalid && !maintenance_form.User_text.$pristine ) || maintenance_form.User_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Nama User</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.User_text.$error.required && !maintenance_form.User_text.$pristine">User name is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="maintenance_form.User_text.$error.minlength">Minimal 3 character.</label>
							</div>
							<input type="text" id="User_text" class="form-control" placeholder="Masukan nama user" name="User_text" ng-model="User_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group">
								<label>Nama Peserta</label><br/>
								<?php
									$nama_teknisi = explode(", ", $maintenances->Nama_teknisi);
									$no = 1;
								?>
								@foreach ($karyawans as $karyawan)
									@if($karyawan->Karyawan_ID != 1)
									<?php $data_checked = 0; ?>
									@for($i=0;$i<count($nama_teknisi)-1;$i++)
										@if($karyawan->Nama_karyawan == $nama_teknisi[$i])
											<?php $data_checked = 1; ?>
										@endif
									@endfor
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked == 1) ? 'checked': ''; ?>/> {{$karyawan->Nama_karyawan}} <br/>
									<?php
										$no++;
									?>
									@endif
								@endforeach
						</div>
						<hr>
						<input type="hidden" name="no" value="{{$no}}">
						<input type="hidden" name="Report_maintenance_ID" value="{{$maintenances->Report_maintenance_ID}}">
						<center><button type="submit" ng-disabled="maintenance_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Upload Gambar Maintenance</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
								{!! Form::open(array('name' => 'upload_image_maintenance_form', 'action' => 'MaintenanceController@upload_image_maintenance_report', 'files'=>true)) !!}
								<div class="form-group">
								<label>Pilih Gambar</label>
								<input type="file" id="file" name="file">
								</div>
								<input type="hidden" name="Report_maintenance_ID" value="{{$maintenances->Report_maintenance_ID}}">
								<center><button type="submit" class="btn btn-info">Submit</button></center>
								{!! Form::close() !!}
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- ./box-body -->
					</div><!-- /.box -->
				</div>
			</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Gambar Laporan Maintenance</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php $maintenance_image_object = new \App\Model\Maintenance_image()?>	
					@foreach($details as $row)
					<a class="fancybox-effects-c" href="http://miland.asia/asset/images/project/{{$maintenance_image_object::find($row->Maintenance_image_ID)->Nama_gambar_maintenance}}">
						{!! HTML::image('http://miland.asia/asset/images/project/'.$maintenance_image_object::find($row->Maintenance_image_ID)->Nama_gambar_maintenance, 'Loading image', array('width'=>'200px', 'height'=>'200px')) !!}
					</a>
					@endforeach
				</div>
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
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$maintenances->Subject}}';
				$scope.Maintenance_date = '{{$maintenances->Tanggal_pekerjaan}}';
				$scope.Start_time = '{{$maintenances->Waktu_mulai}}';
				$scope.End_time = '{{$maintenances->Waktu_selesai}}';
				$scope.User_text = '{{$maintenances->Nama_user}}';
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

