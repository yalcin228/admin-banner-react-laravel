@extends('admin.layouts.app')
@section('title','Əlave et')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sayt/</span>Yeni sayt əlavə et</h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <form action="{{route('sites.store')}}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    @include('admin.components.input-text',
                                    ['name' => 'name','type' => 'text','label' => 'name','attrs'=> 'required'])
                                </div>
                                <div class="col-md-12">
                                    @include('admin.components.status',
                                    ['name' => 'status','label'=> 'Status','active' => 'Aktiv','passive' => 'Passiv',
                                    'attrs' => 'required'])
                                </div>
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-primary">
                                        Əlavə et
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
