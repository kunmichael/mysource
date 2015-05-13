<?php 
	$detail_object = new \App\Model\Detail_jadwal(); 
?>
{!! Form::open(array('name' => 'schedule_form', 'action' => 'ScheduleController@edit_schedule')) !!}
<div class="form-group">
	<div class="form-inline">
	<label>Nama Pembuat Jadwal</label>
	</div>
	<input type="text" class="form-control" value="{{$headers->Nama_pembuat}}" readonly>
</div>
<div class="form-group">
	<label>Tipe Jadwal</label>
	<select class="form-control" name="schedule_type_text">
		<option value="Instalasi" <?php echo ($headers->Jenis_laporan == "Instalasi") ? 'selected': ''; ?>>Instalasi</option>
		<option value="Maintenance" <?php echo ($headers->Jenis_laporan == "Maintenance") ? 'selected': ''; ?>>Maintenance</option>
		<option value="Troubleshoot" <?php echo ($headers->Jenis_laporan == "Troubleshoot") ? 'selected': ''; ?>>Troubleshoot</option>
		<option value="Trainning" <?php echo ($headers->Jenis_laporan == "Trainning") ? 'selected': ''; ?>>Trainning</option>
	</select>
</div>
<div class="form-group">
	<label>Nama Project</label>
	<select class="form-control" id="project_name_text" name="project_name_text">
		@foreach ($projects as $project)
			<option value="{{$project->Project_ID}}" <?php echo ($headers->Project_ID == $project->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label>Subjek</label>
	<input type="text" class="form-control" name="subject_text" value="{{$headers->Subjek}}">
</div>
<div class="form-group">
	<label>Tanggal Jadwal</label>
	<input type="text" id="datepickeredit" class="form-control datepickerinmodal" name="schedule_date_text" value="{{$headers->Tanggal_jadwal}}" />
</div>
<div class="form-group">
	<label>Waktu Jadwal</label>
	<input type="text" class="form-control" name="schedule_time_text" value="{{$headers->Waktu_jadwal}}" />
</div>
<div class="form-group">
	<label>Deskripsi</label>
	<textarea class="form-control" name="description_text" rows="3" >{{$headers->Keterangan}}</textarea>
</div>
<div class="form-group">
		<label>Nama Peserta</label><br/>
		<?php
			$no = 1;
		?>
		@foreach ($karyawans as $karyawan)
			@if($karyawan->Karyawan_ID != 1)
			<input type="checkbox" name="karyawan_id{{$no}}" value="{{$karyawan->Karyawan_ID}}" <?php echo ($detail_object::where('Jadwal_ID','=',$headers->Jadwal_ID)->where('Karyawan_ID','=',$karyawan->Karyawan_ID)->count() == 1) ? 'checked': ''; ?> /> {{$karyawan->Nama_karyawan}} <br/>
			<?php
				$no++;
			?>
			@endif
		@endforeach
		<input type="hidden" name="no" value="{{$no}}">
</div>
	<hr>
	<input type="hidden" name="Jadwal_ID" value="{{$headers->Jadwal_ID}}">
	<center><button type="submit" class="btn btn-info">Submit</button></center>
{!! Form::close() !!}
