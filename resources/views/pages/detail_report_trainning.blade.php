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
				<li class="active">Form Detail Laporan Trainning</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Detail Laporan Trainning</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-app="MyApp" ng-controller ="FormController">
						<div class="form-group">
							<label>Nama Karyawan</label>
							<input type="text" class="form-control" placeholder="" ng-model="Karyawan_name" readonly/>
						</div>
						<div class="form-group">
							<label>Subjek</label>
							<input type="text" id="Subject_text" class="form-control" name="Subject_text" ng-model="Subject_text" readonly/>	
						</div>
						<div class="form-group">
							<label>Lokasi</label>
							<input type="text" id="Location_text" class="form-control" name="Location_text" ng-model="Location_text" readonly/>
						</div>
						<div class="form-group">
							<label>Tanggal Training</label>
							<input type="text" id="Trainning_date" class="form-control" name="Trainning_date" ng-model="Trainning_date" readonly/>	
						</div>
						<div class="form-group" >
							<label>Waktu Mulai</label>
							<input type="text" id="Start_time" class="form-control" name="Start_time" ng-model="Start_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Waktu Selesai</label>
							<input type="text" id="End_time" class="form-control" name="End_time" ng-model="End_time" readonly/>	
						</div>
						<div class="form-group">
							<label>Hasil Trainning</label>
							<textarea class="form-control" id="Trainning_result_text" rows="10" style="resize:none;" name="Trainning_result_text" readonly>{{$trainnings->Hasil_training}}
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
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked == 1) ? 'checked': ''; ?> disabled/> {{$karyawan->Nama_karyawan}} <br/>
									<?php
										$no++;
									?>
									@endif
								@endforeach
								<input type="hidden" name="no" value="{{$no}}">
						</div>
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
		
		<script>			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$trainnings->Subject}}';
				$scope.Location_text = '{{$trainnings->Lokasi}}';
				$scope.Trainning_date = '{{change_date($trainnings->Tanggal_training)}}';
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

