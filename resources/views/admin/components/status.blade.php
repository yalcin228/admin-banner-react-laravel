@php
    $width      = 'col-md-'.( $width ?? '12' );
    $label      = $label ?? 'Name';
    $name       = $name ?? 'name';
    $class      = $class ?? '';
    $active     = $active ?? '';
    $passive     = $passive ?? '';
    $attrs      = $attrs ?? '';
    $selected = $selected ?? 1;
@endphp

<div class="mb-3 {{$width}}">
    <label for="{{$name}}" class="form-label">{{$label}}</label>
    <select class="form-select {{$class}}" {!! $attrs !!} name="{{$name}}" id="{{$name}}">
        <option value="1" {{ 1 === $selected ? 'selected' :''}}>{{$active}}</option>
        <option value="0" {{ 0 === $selected ? 'selected' :''}}>{{$passive}}</option>
    </select>
</div>
