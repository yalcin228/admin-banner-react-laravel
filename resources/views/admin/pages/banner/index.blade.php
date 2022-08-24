@extends('admin.layouts.app')
@section('title','Banner Siyahısı')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Banner/</span>Siyahı</h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="">Cədvəl</h5>
                        <a href="{{route('banner.create')}}" class="btn btn-success">Əlavə et </a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="table-dark">
                            <tr>
                                <th>№</th>
                                <th>Sayt</th>
{{--                                <th>Sort</th>--}}
                                <th>Yer</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{($loop->iteration - $banners->perPage()) + ($banners->currentPage() * $banners->perPage()) }}</td>
                                    <td>{{$banner->sites?->name}}</td>
{{--                                    <td>{{$banner->sort}}</td>--}}
                                    <td>
                                        <img height="150" width="150" src="/storage/site-category/{{$banner->sites->place->image ?? 'salam.jpg'}}" alt="{{$banner->sites->place->image  ?? 'salam.jpg'  }}">
                                    </td>
                                    <td>
                                        <a href="{{route('banner.edit',$banner)}}"
                                           class="btn btn-sm btn-primary">
                                            <i class="bx bx-edit-alt me-1"></i>
                                        </a>
                                        <button data-link="{{ route('banner.destroy', $banner) }}"
                                                class="btn btn-sm btn-danger delete">
                                            <i class="bx bx-trash me-1"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$banners->links()}}
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

        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if(session()->has('success'))
            toastr.success('{{ session()->get('success') }}');
            @endif
        });
    </script>
@endsection
