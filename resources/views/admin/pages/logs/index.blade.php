@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Loglar</h4>
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h5 class="">Loglar</h5>
            </div>
              <div class="card-body">
                <form
                action="{{ route('getModuleSearch',['module'=> 'Log','viewFile'=>'index','pathFile'=>'logs','path' => 'pages.logs','mainPath'=>'admin'])}}"
                method="GET">
                @csrf

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>İstifadəçi adı</th>
                        <th>Info</th>
                        <th>Əməliyyat</th>
                        <th>Modul</th>
                        <th>Ip</th>
                        <th>Tarix</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                    </thead>
                    <tr>
                        <td><input type="text" class="form-control" placeholder="İd" name="id"
                                   value="{{request()->input('id')}}"></td>
                        <td><select class="form-control" name="admin">
                                <option value="">Seçin</option>
                                @foreach($admins as $result)
                                    <option value="{{$result->id}}">{{$result->username}}</option>
                                @endforeach
                            </select></td>
                        <td><input type="text" class="form-control" placeholder="Info" name="info"
                                   value="{{request()->input('info')}}">
                        </td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control" placeholder="IP" name="ip"
                                   value="{{request()->input('ip')}}"></td>
                        <td>
                            <div class="form-group mb-0">
                                <input id="dateTimeFlatpickr" name="date" value="{{request()->input('date')}}"
                                       class="form-control flatpickr flatpickr-input" type="date"
                                       placeholder="Vaxtı Seç.." readonly="readonly">
                            </div>
                        </td>

                        <td>
                            <button class="btn btn-warning btn-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-search text-center">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </td>

                    </tr>

                    @foreach($results as $result)
                        <tr>
                            <td>{{$result->id}}</td>
                            <td>{{$result->admin?->username ?? ''}}</td>
                            <td>ID: {!! $result->info !!}</td>
                            <td>{{$result->action}}</td>
                            <td>{{$result->module ?? ''}}</td>
                            <td>{{$result->ip}}</td>
                            <td style="width: 170px">{{($result->created_at)->format('d-m-Y | G:i')}}</td>
                            <td class="text-center">
                                <ul class="table-controls">
                                </ul>
                            </td>

                        </tr>
                    @endforeach
                </table>
                <div class="card-footer bg-white">
                    {{ $results->appends(request()->all())->links() }}
                </div>
            </form>
              </div>
          </div> <!-- end card-box -->
      </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    var f2 = flatpickr(document.getElementById('dateTimeFlatpickr'), {
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>
@endsection