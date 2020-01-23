@extends('layouts.master')

@section('content')
	<br>
	<div class="row">
		<div class="col-md-8">
			<h1>Paint Job in Progress</h1>
			<table id="in_prog" class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Plate No.</th>
						<th scope="col">Current Color</th>
						<th scope="col">Target Color</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($online as $list)
					<tr>
						<th>{{ $list->plate_number }}</th>
						<td>{{ $list->curr_color }}</td>
						<td>{{ $list->target_color }}</td>
						<td>
							<input type="hidden" id="id" value="{{ $list->id }}">
							<button onClick="update({{ $list->id }});" class="btn btn-xs btn-primary" id="update"><span class="fa fa-pencil"></span></button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-4">
			<h1 style="color:white;">. . .</h1>
			<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col" colspan="2">Shop Performance</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Total Cars Painted</td>
					<td>{{ $total }}</td>
				</tr>
				<tr>
					<td colspan="2">Breakdown:</td>
				</tr>
				<tr>
					<td style="padding-left:50px;">Blue</td>
					<td>{{ $totalBlue }}</td>
				</tr>								
				<tr>
					<td style="padding-left:50px;">Red</td>
					<td>{{ $totalRed }}</td>
				</tr>	
				<tr>
					<td style="padding-left:50px;">Green</td>
					<td>{{ $totalGreen }}</td>
				</tr>									
		</table>
		</div>
	</div>
	<br></br>
	<div class="row">
		<div class="col-md-12">
			<h1>Paint in Queue</h1>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Plate No.</th>
						<th scope="col">Current Color</th>
						<th scope="col">Target Color</th>
					</tr>
				</thead>
				<tbody>
					@foreach($queued as $queues)
					<tr>
						<th>{{ $queues->plate_number }}</th>
						<td>{{ $queues->curr_color }}</td>
						<td>{{ $queues->target_color }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>

	<br></br>
	<div class="row">
		<a class="btn btn-primary" href="{{ url('/') }}"><i class="fa fa-arrow-left"></i> Back to home</a>
	</div>	

@endsection

@section('javascript')
	<script type="text/javascript">
     	jQuery(document).ready(function(){
     		test();
		});

		function test() {
	 		setInterval(function () {
	      		jQuery.ajax({
					url: "{{ url('/api/count') }}",
	          		method: 'get',
	          		success: function(res) {
	          			console.log('refreshed!');   
          				location.reload();
	          		},
	      		}); 
	 		}, 5000);
		}

 		function update(id) {
			$.ajaxSetup({
          		headers: {
          			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          		}
      		});

      		jQuery.ajax({
				url: "{{ url('/api/queue/') }}" + '/' + id,
          		method: 'put',
          		data: {
          			id: id,
          		},
          		success: function(res) {
          			console.log(res);
      				location.reload();
          		},
          		error: function(errors) {
					$('#alert').show().delay(2000).fadeOut('fast');
					console.log(errors, 11);
          		}
      		});     			
 		}

	</script>
@endsection