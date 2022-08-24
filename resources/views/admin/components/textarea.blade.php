@php
    $width      = 'col-md-'.( $width ?? '12' );
    $label      = $label ?? 'Name';
    $name       = $name ?? 'name';
    $value      = $value ?? null;
    $attrs      = $attrs ?? null;
    $class      = $class ?? null;
    $placeholder = $placeholder ?? null;
    $rows = $rows ?? 4;
@endphp



<div class="mb-3 {{ $width }}">
    <label for="{{ $name }}" class="form-label">@lang($label)</label>
    <textarea class="form-control {{ $class }} @error($name) is-invalid @enderror" {!! $attrs !!} id="{{ $name }}" name="{{ $name }}" rows="5">{!!  old($name, $value)  !!}</textarea>
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<script>
    ClassicEditor
    .create( document.querySelector( '#{{ $name }}' ))
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.log( err );
    } );
</script>