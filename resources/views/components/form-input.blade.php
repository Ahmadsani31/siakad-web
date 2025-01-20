<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }} @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type }}" class="form-control" id="{{ $name }}" name="{{ $name }}"
        value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $readonly ? 'readonly' : '' }} />
    <div class="invalid-feedback" id="error-{{ $name }}"></div>
</div>
