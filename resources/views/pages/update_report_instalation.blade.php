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
				<li class="active">Form Update Laporan Instalasi</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Form Update Laporan Instalasi</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
							{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'instalation_form', 'action' => 'InstalationController@update_instalation_report')) !!}
							<div class="form-group">
								<label>Nama Karyawan</label>
								<input type="text" class="form-control" placeholder="" ng-model="Karyawan_name" readonly/>
							</div>
							<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Subject_text.$invalid && !instalation_form.Subject_text.$pristine ) || instalation_form.Subject_text.$error.minlength }">
								<div class="form-inline">
									<label><b style="color:red;">*</b> Subjek</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Subject_text.$error.required && !instalation_form.Subject_text.$pristine">Subject is required.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Subject_text.$error.minlength">Minimal 3 character.</label>
								</div>
								<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" ng-minlength="3" required/>	
							</div>
							<div class="form-group">
							<label><b style="color:red;">*</b> Projek</label>
							<select class="form-control" name="Project_ID" id="Project_ID">
								@foreach ($projects as $project)
									<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $instalations->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
								@endforeach
							</select>
							</div>
							<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Instalation_date.$invalid && !instalation_form.Instalation_date.$pristine ) || instalation_form.Instalation_date.$error.minlength }">
								<div class="form-inline">
								<label><b style="color:red;">*</b> Tanggal Instalasi</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_date.$error.required && !instalation_form.Instalation_date.$pristine">Instalation date is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_date.$error.minlength || instalation_form.Instalation_date.$error.maxlength">Must 10 character.</label>
								</div>
								<input type="text" id="Instalation_date" class="form-control" placeholder="Tanggal mengikuti instalasi" name="Instalation_date" ng-model="Instalation_date" ng-minlength="10" ng-maxlength="10" required/>	
							</div>
							<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Start_time.$invalid && !instalation_form.Start_time.$pristine ) || instalation_form.Start_time.$error.minlength }">
								<div class="form-inline">
									<label><b style="color:red;">*</b> Waktu Mulai</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.required && !instalation_form.Start_time.$pristine">Start time is required.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.minlength">Must 5 character.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Start_time.$error.maxlength">Must 5 character.</label>
								</div>
								<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
							</div>
							<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.End_time.$invalid && !instalation_form.End_time.$pristine ) || instalation_form.End_time.$error.minlength }">
								<div class="form-inline">
									<label><b style="color:red;">*</b> Waktu Selesai</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.required && !instalation_form.End_time.$pristine">End time is required.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.minlength">Must 5 character.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.End_time.$error.maxlength">Must 5 character.</label>
								</div>
								<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
							</div>
							<div class="form-group" ng-class="{ 'has-error' : ( instalation_form.Instalation_result_text.$invalid && !instalation_form.Instalation_result_text.$pristine ) || instalation_form.Instalation_result_text.$error.minlength }">
								<div class="form-inline">
									<label><b style="color:red;">*</b> Hasil Pekerjaan</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_result_text.$error.required && !instalation_form.Instalation_result_text.$pristine">Instalation result is required.</label>
									<label style="color:red;font-size:x-small;" ng-show="instalation_form.Instalation_result_text.$error.minlength">Minimal 5 character.</label>
								</div>
								<textarea class="form-control" id="Instalation_result_text" rows="10" placeholder="Masukan hasil trainning" style="resize:none;" name="Instalation_result_text">{{$instalations->Hasil_pekerjaan}}</textarea>
							</div>
							<div class="form-group">
								<label>Kendala</label>
								<textarea class="form-control" id="Problem_text" rows="10" placeholder="Masukan Kendala bila ada" style="resize:none;" name="Problem_text">{{$instalations->Kendala}}</textarea>
							</div>
							<div class="form-group">
								<label>Tanggal Menjalankan Agenda selanjutnya</label>
								<input type="text" id="Next_agenda_date" class="form-control" placeholder="Masukan tanggal agenda selanjutnya bila ada" name="Next_agenda_date" value="{{$instalations->Tanggal_agenda}}"/>	
							</div>
							<div class="form-group">
								<label>Agenda Pekerjaan Selanjutnya</label>
								<textarea class="form-control" id="Next_agenda" rows="10" placeholder="Masukan Agenda selanjutnya bila ada" style="resize:none;" name="Next_agenda">{{$instalations->Agenda}}</textarea>
							</div>
							<div class="form-group">
									<label>Nama Peserta</label><br/>
									<?php
										$nama_teknisi = explode(", ", $instalations->Nama_teknisi);
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
							<input type="hidden" name="Report_instalation_ID" value="{{$instalations->Report_instalasi_ID}}">
							<center><button type="submit" ng-disabled="instalation_form.$invalid" class="btn btn-info">Submit</button></center>
							{!! Form::close() !!}
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- ./box-body -->
					</div><!-- /.box -->
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Upload Gambar Instalasi</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
								{!! Form::open(array('name' => 'upload_image_instalation_form', 'action' => 'InstalationController@upload_image_instalation_report', 'files'=>true)) !!}
								<div class="form-group">
								<label>Pilih Gambar</label>
								<input type="file" id="file" name="file">
								</div>
								<input type="hidden" name="Report_instalation_ID" value="{{$instalations->Report_instalasi_ID}}">
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
				  <h3 class="box-title"><b>Gambar Laporan Instalasi</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php $instalation_image_object = new \App\Model\Instalation_image()?>	
					@foreach($details as $row)
					<a class="fancybox-effects-c" href="http://miland.asia/asset/images/project/{{$instalation_image_object::find($row->Instalasi_image_ID)->Nama_gambar_instalasi}}">
						{!! HTML::image('http://miland.asia/asset/images/project/'.$instalation_image_object::find($row->Instalasi_image_ID)->Nama_gambar_instalasi, 'Loading image', array('width'=>'200px', 'height'=>'200px')) !!}
					</a>
					@endforeach
				</div>
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
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$instalations->Subject}}';
				$scope.Instalation_date = '{{$instalations->Tanggal_pekerjaan}}';
				$scope.Start_time = '{{$instalations->Waktu_mulai}}';
				$scope.End_time = '{{$instalations->Waktu_selesai}}';
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

