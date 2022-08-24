@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="{{ route('site-category.index') }}"><span class="text-muted fw-light">Site Kateqoriyalar /</span></a>Kateqori Yeniləmə</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
              <h5 class="card-header">Kateqori Yeniləmə</h5>
              <div class="card-body">
                <div>
                    <form action="{{ route('site-category.update', $siteCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf          
                        @method('PUT')
                        <div class="mb-3">
                            <label for="site_id" class="form-label">Site Adı</label>
                            <select class="form-select  @error('site_id') is-invalid @enderror" name="site_id" id="site_id">
                              <option value="" selected="selected">Seçin</option>
                                @foreach ($sites as $key=>$val)
                                  <option value="{{ $key }}" {{ old('site_id', $siteCategory->site_id) == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('site_id')
                              <span class="">
                                  <small class="text-danger">{{ $message }}</small>
                              </span>
                            @enderror
                        </div>
                        @include('admin.components.input-text',['name'=>'place', 'placeholder'=>'Reklamın yerin daxil edin', 'label' => 'Yer', 'value'=>$siteCategory->place ])
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Növ</label>
                                        <select class="form-select  @error('type') is-invalid @enderror" name="type" id="type">
                                          <option value="">Seçin</option>
                                            @foreach (\App\Enum\TypeEnum::cases() as $item)
                                              <option value="{{ $item->value }}" {{ old('type', $siteCategory->type) == $item->value ? 'selected' : '' }}>{{ $item->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                          <span class="">
                                              <small class="text-danger">{{ $message }}</small>
                                          </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Növ</label>
                                        <select class="form-select  @error('status') is-invalid @enderror" name="status" id="status">
                                          <option value="">Seçin</option>
                                            @foreach (\App\Enum\StatusEnum::cases() as $item)
                                              <option value="{{ $item->value }}" {{ old('status',$siteCategory->status) == $item->value ? 'selected' : '' }}>{{ $item->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                          <span class="">
                                              <small class="text-danger">{{ $message }}</small>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @include('admin.components.files', ['name'=>'image','src' => $siteCategory->image])
                                </div>
                            </div>
                        
                        </div>
                        
                      
                        <button type="submit" class="btn btn-primary">Yenilə</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection