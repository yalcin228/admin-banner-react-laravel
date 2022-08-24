@extends('admin.layouts.app')
@section('title','Sayt Siyahısı')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sayt/</span>Siyahı</h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="">Cədvəl</h5>
                        <a href="{{route('sites.create')}}" class="btn btn-success">Əlavə et </a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="table-dark">
                            <tr>
                                <th>№</th>
                                <th>Ad</th>
                                <th>Status</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach($sites as $site)
                                <tr>
                                    <td>{{($loop->iteration - $sites->perPage()) + ($sites->currentPage() * $sites->perPage()) }}</td>
                                    <td>{{$site->name}}</td>
                                    <td>
                                        <input data-id="{{$site->id}}" class="toggle-class" type="checkbox"
                                               data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                               data-on="Active" data-off="Passive" {{ $site->status ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <a href="{{route('sites.edit',$site)}}"
                                           class="btn btn-sm btn-primary">
{{--                                            <i class="fa fa-edit"></i>--}}
                                            <i class="bx bx-edit-alt me-1"></i>
                                        </a>
                                        <button data-link="{{ route('sites.destroy', $site) }}"
                                                class="btn btn-sm btn-danger delete">
{{--                                            <i class="fa fa-trash"></i>--}}
                                            <i class="bx bx-trash me-1"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$sites->links()}}
                    </div>
                </div> <!-- end card-box -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.delete').on('click', function () {
            let link = $(this).data('link');
            let tr = $(this).parents('tr');

            swal({
                title: "Məlumat silmək istəyirsizmi?",
                text: "Məlumatı sildiyiniz zaman geri dönüşü olmayacaq!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Bəli, Silinsin",
                cancelButtonText: 'Xeyr',
                closeOnConfirm: true,
            }).then((response) => {
                console.log(response);
                if (response.value) {
                    $.ajax({
                        url: link,
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: () => {
                            Swal.fire('Məlumat silindi', '', 'success')
                            tr.remove()
                        },
                        errors: () => {
                            Swal.fire('Nəsə xəta baş verdi', '', 'error')
                        }
                    })
                }
            });
        });

        $(function() {
            $('.toggle-class').change(function() {
                let status = $(this).prop('checked') == true ? 1 : 0;
                let id = $(this).data('id');
                let url = 'change-status';
                let data = {
                    'status': status,
                    'id': id
                };
                $.get(url, data).then(response=>{
                    swal(
                        response.message,
                        response.title,
                        response.situation,
                    )
                })
            })
        });

        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if(session()->has('success'))
            toastr.success('{{ session()->get('success') }}');
            @endif
        });

    </script>
@endsection
