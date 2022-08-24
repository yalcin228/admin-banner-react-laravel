@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="{{ route('admins.index') }}"><span class="text-muted fw-light">Adminlər /</span></a>Yeni Admin</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
              <h5 class="card-header">Yeni Admin</h5>
              <div class="card-body">
                <div>
                    <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.components.input-text',['name'=>'name', 'placeholder'=>'Adınız Soyadınız', 'label' => 'Ad Soyad', 'attrs' => 'required' ])
                        @include('admin.components.input-text',['name'=>'username', 'placeholder'=>'İstifadəçi adınızı giriş edin', 'label' => 'İstifadəçi adı', 'attrs' => 'required' ])
                        @include('admin.components.input-text',['type' => 'email', 'name'=>'email', 'placeholder'=>'Email ünvanı giriş edin', 'label' => 'Email', 'attrs' => 'required' ])
                        {{-- , 'attrs'=> 'pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" --}}
                        @include('admin.components.input-text',['type' => 'tel', 'name'=>'phone', 'placeholder'=>'Nömrənizi giriş edin', 'label' => 'Mobil Nömrə', 'attrs' => 'required' ])
                        <div class="form-group row mb-3">
                            <label class="col-12 col-form-label">İstifadəçi rolu :</label>
                            <div class="col-12">
                                <select name="roles[]" id="roles" class="form-control @error('roles') is-invalid @enderror" required>
                                    <option value="">Seçin</option>
                                    @foreach($roles['roles'] as $role)
                                        <option value="{{$role['id']}}"
                                                @if (old('role_id') == $role['id']) selected="selected" @endif>{{$role['name']}}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-form-label">Şifrə</label>
                            <div class="col-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required
                                       minlength="6" value="{{old('password')}}">
                                @error('password')
                                <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div id="button" class="col-2 btn btn-primary" onclick="genPassword()">Generate</div>
                        </div>


                        @include('admin.components.status-select',['label'=>'Kənardan giriş', 'selected' => \App\Enum\OutsideEnum::DEACTIVE, 'options'=>\App\Enum\OutsideEnum::cases(), 'name'=>'is_outside' ])
                        @include('admin.components.status-select',['label'=>'Status', 'selected' => \App\Enum\StatusEnum::ACTIVE, 'options'=>\App\Enum\StatusEnum::cases(), 'name'=>'status' ])


                        <button type="submit" class="btn btn-primary">Əlave et</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
@section('scripts')
        <script src="{{asset('admin/generate-password.js')}}"></script>
@endsection
