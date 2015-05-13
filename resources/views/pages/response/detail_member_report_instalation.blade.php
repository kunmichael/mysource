<?php
$member_name = explode(", ", $header_report_instalation->Nama_teknisi);
?>
<table>
	@for($i=0;$i<count($member_name)-1;$i++)
		<tr>
			<td>{{$i+1}}.</td>
			<td style="padding-left:5px;">{{$member_name[$i]}}</td>
		</tr>
	@endfor
</table>