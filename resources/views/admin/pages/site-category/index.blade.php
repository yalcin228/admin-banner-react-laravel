@extends('admin.layouts.app')
@section('title','Sayt Kateqoriyası')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Site Kateqoriyalar</h4>
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h5 class="">Site Kateqoriyalar</h5>
              <a href="{{ route("site-category.create") }}" class="btn btn-success">Yeni Site Kateqori</a>
            </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Site Adı</th>
                                <th>Reklam</th>
                                <th>Yer</th>
                                <th>Növ</th>
                                <th>Status</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ( $items as $item )
                            <tr id="js-delete-site-category-{{ $item->id }}">
                                <td><strong>{{ $item->id }}</strong></td>
                                <td>{{ $item->sites?->name }}</td>
                                <td>
                                    <img src="{{ asset('storage/site-category/'.$item->image) }}" style="height: 80px;width:80px;" alt="{{ $item->sites?->name }}">
                                </td>
                                <td>{{ $item->place }}</td>
                                <td>{{ $item->type }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'deactive' ? 'danger' : 'info'}}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('site-category.edit', $item->id) }}" class="btn btn-xs btn-small btn-primary"><i class="bx bx-edit-alt me-1"></i></a>
                                    <a href="javascript:void(0)" data-id="{{$item->id}}" class="js-delete-site-category btn btn-xs btn-danger"> <i class="bx bx-trash me-1"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-footer bg-white">
                        {!! $items->links() !!}
                    </div>
                </div>
          </div> <!-- end card-box -->
      </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
     $(document).on('click', '.js-delete-site-category', function () {
        var id = $(this).data('id');
        swal({
            title: "Məlumat silmək istəyirsizmi?",
            text: "Məlumatı sildiyiniz zaman geri dönüşü olmayacaq!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Bəli, Silinsin",
            cancelButtonText: 'Xeyr',
            closeOnConfirm: true,
        }).then((willDelete) => {
            if (willDelete.value) {
              let url = "{{ route('site-category.destroy',"+ id") }}";
              let data = {id:id}
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: 'site-category/'+id,
                    data: data,
                    success: function (response) {
                        swal(response.message, response.title, response.situation);
                        if (response.status == 200) {
                            $('#js-delete-site-category-' + id).remove();
                        }
                    },
                });
            }
        });
    });

    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });
  </script>
@endsection
