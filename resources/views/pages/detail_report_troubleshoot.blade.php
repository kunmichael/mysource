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
				<li class="active">Form Detail Laporan Troubleshoot</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Detail Laporan Troubleshoot</b></h3>
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
						<div class="form-group">
							<label>Subjek</label>
							<input type="text" id="Subject_text" class="form-control" name="Subject_text" ng-model="Subject_text" readonly/>	
						</div>
						<div class="form-group">
						<label>Projek</label>
						<select class="form-control" name="Project_ID" id="Project_ID" disabled>
							@foreach ($projects as $project)
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $troubleshoots->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Gangguan</label>
							</div>
							<input type="text" id="Problem_text" class="form-control" name="Problem_text" ng-model="Problem_text" readonly/>	
						</div>
						<div class="form-group">
							<label>Tanggal Troubleshoot</label>
							<input type="text" id="Troubleshoot_date" class="form-control" name="Troubleshoot_date" ng-model="Troubleshoot_date" readonly/>	
						</div>
						<div class="form-group">
							<label>Waktu Mulai</label>
							<input type="text" id="Start_time" class="form-control" name="Start_time" ng-model="Start_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Waktu Selesai</label>
							<input type="text" id="End_time" class="form-control" name="End_time" ng-model="End_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Kondisi Awal</label>
							<textarea class="form-control" id="First_condition" rows="10" style="resize:none;" name="First_condition" readonly>{{$troubleshoots->Kondisi_awal}}</textarea>
						</div>
						<div class="form-group">
							<label>Hasil Pekerjaan</label>
							<textarea class="form-control" id="Result_text" rows="10" style="resize:none;" name="Result_text" readonly>{{$troubleshoots->Hasil_pekerjaan}}</textarea>
						</div>
						<div class="form-group">
							<label>Kondisi Akhir</label>
							<textarea class="form-control" id="Last_condition" rows="10" style="resize:none;" name="Last_condition" readonly>{{$troubleshoots->Kondisi_akhir}}</textarea>
						</div>
						<div class="form-group">
							<label>Nama User</label>
							<input type="text" id="User_text" class="form-control" name="User_text" ng-model="User_text" readonly/>	
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
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked == 1) ? 'checked': ''; ?> disabled/> {{$karyawan->Nama_karyawan}} <br/>
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

