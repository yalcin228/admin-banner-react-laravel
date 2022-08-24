@php
    $width      = 'col-md-'.( $width ?? '12' );
    $label      = $label ?? 'Name';
    $name       = $name ?? 'name';
    $value      = $value ?? null;
    $attrs      = $attrs ?? null;
    $class      = $class ?? null;
    $type      = $type ?? 'text';
    $placeholder = $placeholder ?? null;
@endphp

<div class="mb-3 {{ $width }}">
    <label for="{{ $name }}" class="form-label">@lang($label)<span class="text-danger"> {{ $attrs ? '*' : '' }}</span></label>
    <input type="{{ $type }}" name="{{ $name }}" {!! $attrs !!} class="form-control {{ $class }} @error($name) is-invalid @enderror" id="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"/>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>