@extends('layouts.master')

@section('content')
	<div class="row mt-5">
		<div class="jumbotron col px-md-5">
			<h1 class="display-4 text-center">Juan's Auto Paint</h1>
		</div>
	</div>

	<div class="row">
		<ul class="nav" id="myTab">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">NEW PAINT JOBS</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" href="{{ url('/api/cars') }}" role="tab">PAINT JOBS</a>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="tab-content col" id="myTabContent">
			<br>
			<h1 class="display-4 text-center"><b>New Paint Job</b></h1>
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<div class="row">
				    <div class="col-sm">
				     	<img id="curr_color" src="{{ url('../resources/assets/car_gray.png') }}" alt="..." class="border-0 img-thumbnail">
				    </div>
				    <div class="col-sm">
				    	<br><br>
				     	<img src="{{ url('../resources/assets/Arrow.png') }}" alt="..." width="150" height="150" class="border-0 img-thumbnail mx-auto d-block">
				    </div>
				    <div class="col-sm">
				    	<img id="target_color" src="{{ url('../resources/assets/car_gray.png') }}" alt="..." class="border-0 img-thumbnail">
				    </div>
			  </div>							
			</div>
			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">queued</div>
		</div>		
	</div>
	<br>
	<div class="col-md-7">
		<form autocomplete="off">
			<h3>Car Details:</h3><br>
			<div class="form-group row">
				<label for="inputEmail3" class="col-sm-2 col-form-label">Plate No.</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="plate_no" name="plate_no" placeholder="Plate Number">
				  <span id="plate_error" style="color:red;font-size:12px;"></span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Current Color: </label>
				<div class="col-sm-10">
					<select class="form-control" id="curr" name="curr_color">
						<option selected disabled>-- Choose Color --</option>
						<option value="red" data-src="{{ url('../resources/assets/car_red.png') }}">Red</option>
						<option value="green" data-src="{{ url('../resources/assets/car_green.png') }}">Green</option>
						<option value="blue" data-src="{{ url('../resources/assets/car_blue.png') }}">Blue</option>
					</select>
			  		<span id="curr_error" style="color:red;font-size:12px;"></span>
				</div>
			</div>
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Target Color: </label>
				<div class="col-sm-10">
					<select class="form-control" id="target" name="target_color">
						<option selected disabled>-- Choose Color --</option>
						<option value="red" data-src="{{ url('../resources/assets/car_red.png') }}">Red</option>
						<option value="green" data-src="{{ url('../resources/assets/car_green.png') }}">Green</option>
						<option value="blue" data-src="{{ url('../resources/assets/car_blue.png') }}">Blue</option>
					</select>
			  		<span id="target_error" style="color:red;font-size:12px;"></span>
				</div>
			</div>	

			<div class="form-group row">
				<button class="btn btn-md btn-danger" id="process">Submit</button>
			</div>		
		</form>			
	</div>			


@endsection

@section('javascript')
	<script type="text/javascript">
     	jQuery(document).ready(function(){

			// Error message
			jQuery('#alert').hide();
			jQuery('.plate_no1').hide();

			// Change current color image
			jQuery('#curr').on('change', function() {				
				jQuery('#curr_color').attr("src", jQuery(this).find(":selected").attr("data-src"));				
			});

			// Change target color image
			jQuery('#target').on('change', function() {
				jQuery('#target_color').attr("src", jQuery(this).find(":selected").attr("data-src"));
			});
		});

		jQuery('#process').click(function(e) {
			e.preventDefault();
  			$('#plate_error').empty()
  			$('#curr_error').empty()
  			$('#target_error').empty()


			$.ajaxSetup({
          		headers: {
          			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          		}
      		});

      		jQuery.ajax({
				url: "{{ url('/api/process') }}",
          		method: 'post',
          		data: {
          			plate_no: jQuery('#plate_no').val(),
          			curr: jQuery('#curr').val(),
          			target: jQuery('#target').val()
          		},
          		success: function(res) {
          			window.location.href = "http://localhost/paint-job/public/api/cars";
          		},
          		error: function(errors) {
          			console.log(errors)
          			if (errors.responseJSON.errors['plate_no']) {
          				console.log(errors.responseJSON.errors)
	          			$('#plate_error').append('<p>' + errors.responseJSON.errors['plate_no'][0] + '</p>');
          			}
          			if (errors.responseJSON.errors['curr']) {
          				$('#curr_error').append('<p>' + errors.responseJSON.errors['curr'][0] + '</p>');
          			}
          			if (errors.responseJSON.errors['target']) {
	          			$('#target_error').append('<p>' + errors.responseJSON.errors['target'][0] + '</p>');
          			}
          		}
      		});

		});					

	</script>
@endsection