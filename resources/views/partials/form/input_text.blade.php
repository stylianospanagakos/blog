<div class="form-group">
    <label class="font-weight-bold text-gray-800">{{ $label }}</label>
    <input name="{{ $name }}" type="text" class="form-control form-control-user font-size-1 rounded{{ $errors->has($name) ? ' is-invalid' : '' }}" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ $placeholder }}" value="{{ $value }}">
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
    @if (!empty($subtitle))
        <small class="text-gray-500 small-text">{{ $subtitle }}</small>
    @endif
</div>