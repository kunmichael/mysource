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
				<li class="active">Form Detail Laporan Instalasi</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Detail Laporan Instalasi</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'instalation_form', 'action' => 'InstalationController@update_instalation_report')) !!}
						<div class="form-group">
							<label>Subjek</label>
							<input type="text" id="Subject_text" class="form-control" ng-model="Subject_text" readonly/>	
						</div>
						<div class="form-group">
						<label>Projek</label>
						<select class="form-control" name="Project_ID" id="Project_ID" disabled>
							@foreach ($projects as $project)
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $instalations->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group">
							<label>Tanggal Instalasi</label>
							<input type="text" id="Instalation_date" class="form-control" ng-model="Instalation_date" readonly/>	
						</div>
						<div class="form-group">
							<label>Waktu Mulai</label>
							<input type="text" id="Start_time" class="form-control" ng-model="Start_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Waktu Selesai</label>
							<input type="text" id="End_time" class="form-control" name="End_time" ng-model="End_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Hasil Pekerjaan</label>
							<textarea class="form-control" id="Instalation_result_text" rows="10" style="resize:none;" name="Instalation_result_text" readonly>{{$instalations->Hasil_pekerjaan}}</textarea>
						</div>
						<div class="form-group">
							<label>Kendala</label>
							<textarea class="form-control" id="Problem_text" rows="10" style="resize:none;" name="Problem_text" readonly>{{$instalations->Kendala}}</textarea>
						</div>
						<div class="form-group">
							<label>Tanggal Menjalankan Agenda selanjutnya</label>
							<input type="text" id="Next_agenda_date" class="form-control" name="Next_agenda_date" value="{{$instalations->Tanggal_agenda}}" readonly/>	
						</div>
						<div class="form-group">
							<label>Agenda Pekerjaan Selanjutnya</label>
							<textarea class="form-control" id="Next_agenda" rows="10" style="resize:none;" name="Next_agenda" readonly>{{$instalations->Agenda}}</textarea>
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
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked == 1) ? 'checked': ''; ?> disabled/> {{$karyawan->Nama_karyawan}} <br/>
									<?php
										$no++;
									?>
									@endif
								@endforeach
						</div>
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
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
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

