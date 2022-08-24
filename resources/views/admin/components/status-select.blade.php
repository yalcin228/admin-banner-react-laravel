@php
    $width      = 'col-md-'.( $width ?? '12' );
    $label      = $label ?? 'Name';
    $name       = $name ?? 'name';
    $class      = $class ?? null;
    $attrs      = $attrs ?? 'data-toggle="select2"';
    $multiple   = isset($multiple) ? 'multiple' : null;
    $options    = $options ?? [];
    $optionName = $optionName ?? null;
    $optionValue = $optionValue ?? null;
    $selected   = $selected ?? [];
@endphp



<div class="mb-3 {{ $width }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select class="form-select @error($name) is-invalid @enderror {{ $class }}" name="{{ $name }}" id="{{ $name }}">
      <option value="" selected="selected">Seçin</option>
        @foreach ($options as $item)
          <option value="{{ $item->value }}" {{ $item->value == $selected->value ? 'selected' : '' }}>{{ $item->value }}</option>
        @endforeach
    </select>
    
    @error(str_replace('[]','',$name))
      <span class="">
          <small class="text-danger">{{ $message }}</small>
      </span>
    @enderror
</div>