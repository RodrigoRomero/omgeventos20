@extends('admin.layout.base')

@section('content')


	<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-title">
				<h3>
					<i class="fa fa-table"></i>
					Checkboxes
				</h3>
			</div>
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-bordered dataTable" data-nosort="0">
					<thead>
					<tr>
						<th class='with-checkbox'>
							<input type="checkbox" name="check_all" class="dataTable-checkall">
						</th>
						<th>Rendering engine</th>
						<th>Browser</th>
						<th class='hidden-350'>Platform(s)</th>
						<th class='hidden-1024'>Engine version</th>
						<th class='hidden-480'>CSS grade</th>
					</tr>
					</thead>
					<tbody>
					@foreach($users as $user)

					
					<tr>
						<td class="with-checkbox">
							<input type="checkbox" name="check" value="1">
						</td>
						<td>{{ $user->name }}</td>
						<td>
							
						</td>
						<td class='hidden-350'>Win 95+</td>
						<td class='hidden-1024'>4</td>
						<td class='hidden-480'>X</td>
					</tr>
					@endforeach
					<tr>
						<td class="with-checkbox">
							<input type="checkbox" name="check" value="1">
						</td>
						<td>Presto</td>
						<td>Nokia N800</td>
						<td class='hidden-350'>N800</td>
						<td class='hidden-1024'>-</td>
						<td class='hidden-480'>A</td>
					</tr>
					<tr>
						<td class="with-checkbox">
							<input type="checkbox" name="check" value="1">
						</td>
						<td>Misc</td>
						<td>NetFront 3.4</td>
						<td class='hidden-350'>Embedded devices</td>
						<td class='hidden-1024'>-</td>
						<td class='hidden-480'>A</td>
					</tr>
					<tr>
						<td class="with-checkbox">
							<input type="checkbox" name="check" value="1">
						</td>
						<td>Misc</td>
						<td>Dillo 0.8</td>
						<td class='hidden-350'>Embedded devices</td>
						<td class='hidden-1024'>-</td>
						<td class='hidden-480'>X</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection