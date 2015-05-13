@extends('layouts.main')
@section('content')
	<?php
		function change_date($date){
			$exploded_date = explode('-',$date);
			$array = array($exploded_date[2],$exploded_date[1],$exploded_date[0]);
			$today_date = implode('-',$array);
			return $today_date;
		}
		
		$month = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	?>
	
	<?php
		$error = Session::get('error_absent');
		if(!empty($error)){
	?>
		<script>
			alert('{{$error}}');
		</script>
	<?php
		Session::forget('error_absent');
		}
	?>

	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Rekap data absen</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Rekap data absen {{$month[$months-1]}} {{$years}}</b></h3> 
				  <div class="box-tools pull-right">
					<a href="#sort_data" data-toggle='modal'><i class="fa fa-search"></i></a>
					<a href="#download_excel" data-toggle='modal'><span class="glyphicon glyphicon-download-alt"></span></a>
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						<table id="data_absent" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Tanggal</th>
									<th>Waktu Datang</th>
									<th>Waktu Pulang</th>
								</tr>
							</thead>
							<tbody>
							<?php $karyawan_object = new \App\Model\Karyawan(); ?>
								@foreach($absents as $row)
								<?php
									$jam_datang = new DateTime($row->Waktu_masuk);
									$jam_masuk_normal = new DateTime('08:30:00');
									
								?>
								<tr>
									<td>{{ $karyawan_object::find($row->Karyawan_ID)->Nama_karyawan }}</td>
									<td>{{ change_date($row->Tanggal_absen) }}</td>
									<td>{{ $row->Waktu_masuk }}</td>
									<td>
										@if($row->Waktu_pulang != "")
											{{ $row->Waktu_pulang }}
										@else
											00:00:00
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
		
		<div class="modal fade" id="sort_data" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Rekap data</h4>
				</div>
				<div class="modal-body">
					{!! Form::open(array('action' => 'AbsentController@rekap_absent')) !!}
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="month_text" name="month_text">
							@for($i=1;$i<=12;$i++)
								<option value="{{$i}}">{{$month[$i-1]}}</option>
							@endfor
						</select>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="year_text" name="year_text">
							@for($i=2014;$i<=3000;$i++)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
					<hr>
					<center><button type="submit" class="btn btn-info btn-sm">Submit</button></center>
					{!! Form::close() !!}
				</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="download_excel" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Download Absent</h4>
				</div>
				<div class="modal-body">
					{!! Form::open(array('action' => 'AbsentController@export_xls_absent', 'method' => 'GET')) !!}
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="month_text" name="month_text">
							@for($i=1;$i<=12;$i++)
								<option value="{{$i}}">{{$month[$i-1]}}</option>
							@endfor
						</select>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="year_text" name="year_text">
							@for($i=2014;$i<=3000;$i++)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
					<div class="form-group">
						<label>Format File</label>
						<select class="form-control" id="file_text" name="file_text">
							<option value="xls">xls</option>
							<option value="xlsx">xlsx</option>
						</select>
					</div>
					<hr>
					<center><button type="submit" class="btn btn-info btn-sm">Submit</button></center>
					{!! Form::close() !!}
				</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</section>
		<script>
			$("#data_absent").dataTable({
					"bPaginate": true,
					"bLengthChange": true,
					"bFilter": true,
					"bSort": true,
					"bInfo": true,
					"bAutoWidth": true,
					"aaSorting": [],
					"iDisplayLength": -1,
					"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
				});
		</script>
	</div>
@stop