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
				<li class="active">Form Update Laporan Troubleshoot</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Update Laporan Troubleshoot</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'troubleshoot_form', 'action' => 'TroubleshootController@update_troubleshoot_report')) !!}
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" ng-model="Karyawan_name" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.Subject_text.$invalid && !troubleshoot_form.Subject_text.$pristine ) || troubleshoot_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Subject_text.$error.required && !troubleshoot_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Subject_text.$error.minlength">Minimal 3 character.</label>
							</div>
							<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group">
						<label><b style="color:red;">*</b> Projek</label>
						<select class="form-control" name="Project_ID" id="Project_ID">
							@foreach ($projects as $project)
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $troubleshoots->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.Problem_text.$invalid && !troubleshoot_form.Problem_text.$pristine ) || troubleshoot_form.Problem_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Gangguan</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Problem_text.$error.required && !troubleshoot_form.Problem_text.$pristine">Problem is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Problem_text.$error.minlength">Minimal 3 character.</label>
							</div>
							<input type="text" id="Problem_text" class="form-control" placeholder="Masukan Gangguan" name="Problem_text" ng-model="Problem_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.Troubleshoot_date.$invalid && !troubleshoot_form.Troubleshoot_date.$pristine ) || troubleshoot_form.Troubleshoot_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Troubleshoot</label>
							<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Troubleshoot_date.$error.required && !troubleshoot_form.Troubleshoot_date.$pristine">Instalation date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Troubleshoot_date.$error.minlength || troubleshoot_form.Troubleshoot_date.$error.maxlength">Must 10 character.</label>
							</div>
							<input type="text" id="Troubleshoot_date" class="form-control" placeholder="Tanggal mengikuti troubleshoot" name="Troubleshoot_date" ng-model="Troubleshoot_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.Start_time.$invalid && !troubleshoot_form.Start_time.$pristine ) || troubleshoot_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Start_time.$error.required && !troubleshoot_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Start_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.End_time.$invalid && !troubleshoot_form.End_time.$pristine ) || troubleshoot_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.End_time.$error.required && !troubleshoot_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.End_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi Awal</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.First_condition.$error.required && !troubleshoot_form.First_condition.$pristine">First condition result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.First_condition.$error.minlength">Minimal 5 character.</label>
							</div>
							<textarea class="form-control" id="First_condition" rows="10" placeholder="Masukan kondisi awal" style="resize:none;" name="First_condition">{{$troubleshoots->Kondisi_awal}}</textarea>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Hasil Pekerjaan</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Result_text.$error.required && !troubleshoot_form.Result_text.$pristine">Result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Result_text.$error.minlength">Minimal 5 character.</label>
							</div>
							<textarea class="form-control" id="Result_text" rows="10" placeholder="Masukan kondisi awal" style="resize:none;" name="Result_text">{{$troubleshoots->Hasil_pekerjaan}}</textarea>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Kondisi Akhir</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Last_condition.$error.required && !troubleshoot_form.Last_condition.$pristine">Last condition is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.Last_condition.$error.minlength">Minimal 5 character.</label>
							</div>
							<textarea class="form-control" id="Last_condition" rows="10" placeholder="Masukan kondisi terakhir" style="resize:none;" name="Last_condition">{{$troubleshoots->Kondisi_akhir}}</textarea>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( troubleshoot_form.User_text.$invalid && !troubleshoot_form.User_text.$pristine ) || troubleshoot_form.User_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Nama User</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.User_text.$error.required && !troubleshoot_form.User_text.$pristine">User name is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="troubleshoot_form.User_text.$error.minlength">Minimal 3 character.</label>
								<label style="color:red;font-size:x-small;"><?=$errors->first('User_text');?></label>
							</div>
							<input type="text" id="User_text" class="form-control" placeholder="Masukan nama user" name="User_text" ng-model="User_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group">
								<label>Nama Peserta</label><br/>
								<?php
									$nama_teknisi = explode(", ", $troubleshoots->Nama_teknisi);
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
						<input type="hidden" name="Report_troubleshoot_ID" value="{{$troubleshoots->Report_troubleshoot_ID}}">
						<center><button type="submit" ng-disabled="troubleshoot_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Upload Gambar Troubleshoot</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
								{!! Form::open(array('name' => 'upload_image_troubleshoot_form', 'action' => 'TroubleshootController@upload_image_troubleshoot_report', 'files'=>true)) !!}
								<div class="form-group">
								<label>Pilih Gambar</label>
								<input type="file" id="file" name="file">
								</div>
								<input type="hidden" name="Report_troubleshoot_ID" value="{{$troubleshoots->Report_troubleshoot_ID}}">
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
				  <h3 class="box-title"><b>Gambar Laporan Troubleshoot</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php $troubleshoot_image_object = new \App\Model\Troubleshoot_image()?>	
					@foreach($details as $row)
					<a class="fancybox-effects-c" href="http://miland.asia/asset/images/project/{{$troubleshoot_image_object::find($row->Troubleshoot_image_ID)->Nama_gambar_troubleshoot}}">
						{!! HTML::image('http://miland.asia/asset/images/project/'.$troubleshoot_image_object::find($row->Troubleshoot_image_ID)->Nama_gambar_troubleshoot, 'Loading image', array('width'=>'200px', 'height'=>'200px')) !!}
					</a>
					@endforeach
				</div>
				</div>
			</div>
		</section>
		
		<?php
			$error = Session::get('error_troubleshoot');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_troubleshoot');
			}
		?>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
			
			$( "#Troubleshoot_date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$troubleshoots->Subject}}';
				$scope.Problem_text = '{{$troubleshoots->Gangguan}}';
				$scope.Troubleshoot_date = '{{$troubleshoots->Tanggal_pekerjaan}}';
				$scope.Start_time = '{{$troubleshoots->Waktu_mulai}}';
				$scope.End_time = '{{$troubleshoots->Waktu_selesai}}';
				$scope.User_text = '{{$troubleshoots->Nama_user}}';
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


