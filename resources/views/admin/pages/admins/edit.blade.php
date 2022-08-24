@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="{{ route('admins.index') }}"><span class="text-muted fw-light">Adminlər /</span></a>Admin Yenilə</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Admin Yeniləmə</h5>
                <div class="card-body">
                    <div>
                        <form action="{{ route('admins.update',$result['admin']->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $result['admin']->id }}">
                            @include('admin.components.input-text',['name'=>'name', 'value'=>$result['admin']->name, 'placeholder'=>'Adınız Soyadınız', 'label' => 'Ad Soyad', 'attrs' => 'required' ])
                            @include('admin.components.input-text',['name'=>'username', 'value'=>$result['admin']->username, 'placeholder'=>'İstifadəçi adınızı giriş edin', 'label' => 'İstifadəçi adı', 'attrs' => 'required' ])
                            @include('admin.components.input-text',['type' => 'email', 'value'=>$result['admin']->email, 'name'=>'email', 'placeholder'=>'Email ünvanı giriş edin', 'label' => 'Email', 'attrs' => 'required' ])
                            @include('admin.components.input-text',['type' => 'tel', 'value'=>$result['admin']->phone, 'name'=>'phone', 'placeholder'=>'Nömrənizi giriş edin', 'label' => 'Mobil Nömrə', 'attrs' => 'required' ])
                            <div class="mb-3">
                                <label class="col-12 col-form-label">İstifadəçi rolu :</label>
                                <div class="col-12">
                                    <select name="roles[]" id="roles" class="form-control @error('roles') is-invalid @enderror" required>
                                        <option value="">Seçin</option>
                                        @foreach($result['roles'] as $role)
                                            <option @if(in_array($role->id,$result['adminRole'])) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
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
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  id="password" minlength="6" value="{{old('password')}}">
                                    @error('password')
                                    <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>
                                <div id="button" class="col-2 btn btn-primary" onclick="genPassword()">Generate</div>
                            </div>
                            <div class="mb-3">
                                <label for="outside" class="form-label">Kənardan giriş</label>
                                <select class="form-select  @error('is_outside') is-invalid @enderror" name="is_outside" id="outside">
                                <option value="">Seçin</option>
                                    @foreach (\App\Enum\OutsideEnum::cases() as $item)
                                    <option value="{{ $item->value }}" {{ old('is_outside',$result['admin']->is_outside) == $item->value ? 'selected' : '' }}>{{ $item->value }}</option>
                                    @endforeach
                                </select>
                                @error('is_outside')
                                <span class="">
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select  @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="">Seçin</option>
                                    @foreach (\App\Enum\StatusEnum::cases() as $item)
                                    <option value="{{ $item->value }}" {{ old('status',$result['admin']->status) == $item->value ? 'selected' : '' }}>{{ $item->value }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <span class="">
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Məlumatları yenilə</button>
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
