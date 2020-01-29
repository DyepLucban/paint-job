@extends('layouts.master')

@section('content')
	<br>
	<div class="row">
		<div class="col-md-8">
			<h1>Paint Job in Progress</h1>
			<table id="in_prog" class="table">
				<thead class="thead-light">
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
							<button class="btn btn-primary" onClick="update({{ $list->id }});" id="update">Mark as Complete</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-4">
			<h1 style="color:white;">. . .</h1>
			<table class="table" id="total">
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
			</tbody>							
		</table>
		</div>
	</div>
	<br></br>
	<div class="row">
		<div class="col-md-8">
			<h1>Paint in Queue</h1>
			<table class="table" id="queue">
				<thead class="thead-light">
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
		<div class="col-md-4">
			
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
     		// refresh();
		});

		// function refresh() {
	 // 		setInterval(function () {
	 //      		jQuery.ajax({
		// 			url: "{{ url('/api/count') }}",
	 //          		method: 'get',
	 //          		success: function(res) {
	 //          			console.log('refreshed!');   
  //         				location.reload();
	 //          		},
	 //      		}); 
	 // 		}, 5000);
		// }

		function updateQueued() {
			jQuery.get("{{ url('/api/count') }}", function(res) {
				if (res) {
					$( "#queue" ).load(window.location.href + " #queue" );
				}
			})
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
					updateQueued();
					$( "#total" ).load(window.location.href + " #total" );
					$( "#queue" ).load(window.location.href + " #queue" );
					$( "#in_prog" ).load(window.location.href + " #in_prog" );
          		},
          		error: function(errors) {
					$('#alert').show().delay(2000).fadeOut('fast');
          		}
      		});      			
 		}

	</script>
@endsection