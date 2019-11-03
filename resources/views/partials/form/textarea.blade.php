<div class="form-group">
    <label class="font-weight-bold text-gray-800">{{ $label }}</label>
    <textarea name="{{ $name }}" placeholder="{{ $placeholder }}" class="form-control form-control-user font-size-1 rounded{{ $errors->has($name) ? ' is-invalid' : '' }}">{{ $value }}</textarea>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>