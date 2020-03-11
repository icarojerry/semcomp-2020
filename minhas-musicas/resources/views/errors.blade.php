@if ($errors->any())
	<div id="error-panel" class="toast toast-danger" data-autohide="true" aria-atomic="true" data-delay="3500">
		<div class="toast-body">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#error-panel').toast('show');
		});
	</script>	
{{-- 	<div id="error-panel" class="error-panel alert alert-danger">
	</div>


	<script type="text/javascript">
		$(document).ready(function(){
			setTimeout(function() {
				$('#error-panel').hide();
			}, 1000);

		});
				
	</script> --}}
@endif