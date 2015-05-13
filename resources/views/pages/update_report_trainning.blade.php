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
		{!! HTML::style('fancybox/fancybox_source/jquery.fancybox.css?v=2.1.5') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		{!! HTML::script('fancybox/fancybox_source/jquery.fancybox.js?v=2.1.5') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Form Update Laporan Trainning</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Update Laporan Trainning</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'trainning_form', 'action' => 'TrainningController@update_trainning_report')) !!}
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" ng-model="Karyawan_name" readonly/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Subject_text.$invalid && !trainning_form.Subject_text.$pristine ) || trainning_form.Subject_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Subjek</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Subject_text.$error.required && !trainning_form.Subject_text.$pristine">Subject is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Subject_text.$error.minlength">Minimal 3 character.</label>
							</div>
							<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" ng-minlength="3" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Location_text.$invalid && !trainning_form.Location_text.$pristine ) || trainning_form.Location_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Lokasi</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Location_text.$error.required && !trainning_form.Location_text.$pristine">Location is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Location_text.$error.minlength">Minimal 3 character.</label>
							</div>
							<input type="text" id="Location_text" class="form-control" placeholder="Masukan lokasi trainning" name="Location_text" ng-model="Location_text" ng-minlength="3" required/>
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Trainning_date.$invalid && !trainning_form.Trainning_date.$pristine ) || trainning_form.Trainning_date.$error.minlength }">
							<div class="form-inline">
							<label><b style="color:red;">*</b> Tanggal Training</label>
							<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_date.$error.required && !trainning_form.Trainning_date.$pristine">Trainning date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_date.$error.minlength || trainning_form.Trainning_date.$error.maxlength">Must 10 character.</label>
							</div>
							<input type="text" id="Trainning_date" class="form-control" placeholder="Tanggal mengikuti trainning" name="Trainning_date" ng-model="Trainning_date" ng-minlength="10" ng-maxlength="10" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Start_time.$invalid && !trainning_form.Start_time.$pristine ) || trainning_form.Start_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Mulai</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.required && !trainning_form.Start_time.$pristine">Start time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Start_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.End_time.$invalid && !trainning_form.End_time.$pristine ) || trainning_form.End_time.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Waktu Selesai</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.required && !trainning_form.End_time.$pristine">End time is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.minlength">Must 5 character.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.End_time.$error.maxlength">Must 5 character.</label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" ng-minlength="5" ng-maxlength="5" required/>	
						</div>
						<div class="form-group" ng-class="{ 'has-error' : ( trainning_form.Trainning_result_text.$invalid && !trainning_form.Trainning_result_text.$pristine ) || trainning_form.Trainning_result_text.$error.minlength }">
							<div class="form-inline">
								<label><b style="color:red;">*</b> Hasil Trainning</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_result_text.$error.required && !trainning_form.Trainning_result_text.$pristine">Trainning result is required.</label>
								<label style="color:red;font-size:x-small;" ng-show="trainning_form.Trainning_result_text.$error.minlength">Minimal 5 character.</label>
							</div>
							<textarea class="form-control" id="Trainning_result_text" rows="10" placeholder="Masukan hasil trainning" style="resize:none;" name="Trainning_result_text">{{$trainnings->Hasil_training}}
							</textarea>
						</div>
						<div class="form-group">
								<label>Nama Peserta</label><br/>
								<?php
									$nama_teknisi = explode(", ", $trainnings->Nama_teknisi);
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
								<input type="hidden" name="no" value="{{$no}}">
						</div>
						<hr>
						<input type="hidden" name="Report_trainning_ID" value="{{$trainnings->Report_training_ID}}">
						<center><button type="submit" ng-disabled="trainning_form.$invalid" class="btn btn-info">Submit</button></center>
						{!! Form::close() !!}
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><b>Upload Gambar Trainning</b></h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row" style="margin-top:5px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
								{!! Form::open(array('name' => 'upload_image_trainning_form', 'action' => 'TrainningController@upload_image_trainning_report', 'files'=>true)) !!}
								<div class="form-group">
								<label>Pilih Gambar</label>
								<input type="file" id="file" name="file">
								</div>
								<input type="hidden" name="Report_trainning_ID" value="{{$trainnings->Report_training_ID}}">
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
				  <h3 class="box-title"><b>Gambar Laporan Trainning</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php $trainning_image_object = new \App\Model\Trainning_image()?>	
					@foreach($details as $row)
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
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$trainnings->Subject}}';
				$scope.Location_text = '{{$trainnings->Lokasi}}';
				$scope.Trainning_date = '{{$trainnings->Tanggal_training}}';
				$scope.Start_time = '{{$trainnings->Waktu_mulai}}';
				$scope.End_time = '{{$trainnings->Waktu_selesai}}';
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

