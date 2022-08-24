@extends('admin.layouts.app')
@section('title','Redaqtə et')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sayt/</span>Redaktə et</h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <form action="{{route('sites.update',$site)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    @include('admin.components.input-text',
                                    ['name' => 'name','type' => 'text','label' => 'name','attrs'=> 'required','value'=> $site->name])
                                </div>
                                <div class="col-md-12">
                                    @include('admin.components.status',
                                    ['name' => 'status','label'=> 'Status','active' => 'Aktiv','passive' => 'Passiv',
                                    'attrs' => 'required','selected' => $site->status])
                                </div>
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-primary">
                                        Redaktə et
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
