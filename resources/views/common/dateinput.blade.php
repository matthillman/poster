<div class="datepicker mdl-textfield mdl-js-textfield mdl-textfield--floating-label{{ $errors->has($name) ? ' is-invalid' : '' }}">
	<input class="mdl-textfield__input datepicker__input" type="date" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}">
	<label class="mdl-textfield__label" for="{{ $name }}">{{ isset($display_name) ? $display_name : title($name) }}</label>
	@if ($errors->has($name))
		<span class="mdl-textfield__error">
			<strong>{{ $errors->first($name) }}</strong>
		</span>
	@endif
</div>
