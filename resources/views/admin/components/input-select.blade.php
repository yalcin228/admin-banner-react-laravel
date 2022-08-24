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
    <label for="{{ $name }}" class="form-label">@lang($label)</label>
    <select class="form-select {{ $class }}" name="{{ $name }}" id="{{ $name }}">
      <option value="0" selected="selected">Seçin</option>
        @foreach ($items as $item)
          <option value="{{ $item->id }}">{{ \App\Http\Controllers\Admin\CategoryController::getParentsTree($item, $item->name) }}</option>
        @endforeach

    </select>
</div>

