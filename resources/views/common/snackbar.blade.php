<div aria-live="assertive" aria-atomic="true" aria-relevant="text" class="mdl-snackbar mdl-js-snackbar">
	<div class="mdl-snackbar__text"></div>
	<button type="button" class="mdl-snackbar__action"></button>
</div>

@if (session('status'))
	@push('scripts')
		<script>
		window.addEventListener('load', function() {
			var notification = document.querySelector('.mdl-js-snackbar');
			var data = {
				message: "{{ session('status') }}",
				timeout: 5000
			};
			notification.MaterialSnackbar.showSnackbar(data);
		}, false);
		</script>
	@endpush
@endif
