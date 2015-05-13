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
				<li class="active">Form Detail Laporan Maintenance</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Form Detail Laporan Maintenance</b></h3>
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
						<div class="form-group">
							<div class="form-inline">
								<label>Subjek</label>
							</div>
							<input type="text" id="Subject_text" class="form-control" placeholder="Masukan Subject Laporan" name="Subject_text" ng-model="Subject_text" readonly/>	
						</div>
						<div class="form-group">
						<label>Projek</label>
						<select class="form-control" name="Project_ID" id="Project_ID" disabled>
							<?php
								$project_selected = Session::get('project_selected');
								Session::forget('project_selected');
							?>
							@foreach ($projects as $project)
								<option value="{{$project->Project_ID}}" <?php echo ($project->Project_ID == $maintenances->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group">
							<div class="form-inline">
							<label>Tanggal Maintenance</label>
							</div>
							<input type="text" id="Maintenance_date" class="form-control" placeholder="Tanggal mengikuti instalasi" name="Maintenance_date" ng-model="Maintenance_date" readonly/>	
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Waktu Mulai</label>
							</div>
							<input type="text" id="Start_time" class="form-control" placeholder="Waktu Mulai Pekerjaan ( 00:00 - 24:00 )" name="Start_time" ng-model="Start_time" readonly/>	
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Waktu Selesai</label>
							</div>
							<input type="text" id="End_time" class="form-control" placeholder="Waktu Selesai Berkerja ( 00:00 - 24:00 )" name="End_time" ng-model="End_time" readonly/>	
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Kondisi awal</label>
							</div>
							<textarea class="form-control" id="First_condition" rows="10" placeholder="Masukan kondisi awal" style="resize:none;" name="First_condition" readonly>{{$maintenances->Kondisi_awal}}</textarea>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Kondisi Akhir</label>
							</div>
							<textarea class="form-control" id="Last_condition" rows="10" placeholder="Masukan kondisi terakhir" style="resize:none;" name="Last_condition" readonly>{{$maintenances->Kondisi_akhir}}</textarea>
						</div>
						<div class="form-group">
							<div class="form-inline">
								<label>Nama User</label>
							</div>
							<input type="text" id="User_text" class="form-control" placeholder="Masukan nama user" name="User_text" ng-model="User_text" readonly/>	
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
									<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Nama_karyawan}}" <?php echo ($data_checked == 1) ? 'checked': ''; ?> disabled/> {{$karyawan->Nama_karyawan}} <br/>
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
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.Karyawan_name = '{{$report_maker}}';
				$scope.Subject_text = '{{$maintenances->Subject}}';
				$scope.Maintenance_date = '{{change_date($maintenances->Tanggal_pekerjaan)}}';
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

