@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="{{ route('site-category.index') }}"><span class="text-muted fw-light">Site Kateqoriyalar /</span></a>Yeni Site Kateqori</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
              <h5 class="card-header">Yeni Site Kateqori</h5>
              <div class="card-body">
                <div>
                    <form action="{{ route('site-category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf          
                        <div class="mb-3">
                            <label for="site_id" class="form-label">Site Adı</label>
                            <select class="form-select  @error('site_id') is-invalid @enderror" name="site_id" id="site_id">
                              <option value="" selected="selected">Seçin</option>
                                @foreach ($sites as $key=>$val)
                                  <option value="{{ $key }}" {{ old('site_id') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('site_id')
                              <span class="">
                                  <small class="text-danger">{{ $message }}</small>
                              </span>
                            @enderror
                        </div>
                        @include('admin.components.input-text',['name'=>'place', 'placeholder'=>'Reklamın yerin daxil edin', 'label' => 'Yer' ])
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    @include('admin.components.status-select',['label'=>'Növ', 'selected' => \App\Enum\TypeEnum::WEB, 'options'=>\App\Enum\TypeEnum::cases(), 'name'=>'type' ])
                                    @include('admin.components.status-select',['label'=>'Status', 'selected' => \App\Enum\StatusEnum::ACTIVE, 'options'=>\App\Enum\StatusEnum::cases(), 'name'=>'status' ])
                                </div>
                                <div class="col-md-6">
                                    @include('admin.components.files', ['name'=>'image'])
                                </div>
                            </div>
                        
                        </div>
                        
                      
                        <button type="submit" class="btn btn-primary">Əlave et</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection