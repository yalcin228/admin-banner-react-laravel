@extends('admin.layouts.app')
@section('title','Əlave et')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Banner/</span>Yeni banner əlavə et</h4>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <form action="{{route('banner.store')}}" method="POST">
                                @csrf

                                <div class="col-md-12">
{{--                                    <textarea id="ads" name="ads"--}}
{{--                                              class="form-control @error('ads') is-invalid @enderror" >{!! old('ads') !!}</textarea>--}}
                                    <input type="text" name="ads" class="form-control" value="{{old('ads')}}">
                                    @error('ads')
                                    <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="site" class="form-label">Saytlar</label>
                                        <select class="form-select site @error('site_id') is-invalid @enderror"  required name="site_id"
                                                id="site">
                                            <option value="" selected="selected">Seçin</option>
                                            @foreach ($sites as $site)
                                                <option value="{{ $site->id }}">{{$site->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('site_id')
                                    <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Yerlər</label>
                                        <select class="form-select @error('site_id') is-invalid @enderror" required name="category_id" id="category">
                                            <option value="" selected="selected">Seçin</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{$loop->iteration}}
                                                    - {{$category->place}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @error('category_id')
                                    <span class="">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <img src="" height="250" width="250" id="image" alt="place">
                                    </div>
                                </div>

                                {{--                                <div class="col-md-12">--}}
                                {{--                                    <div class="mb-3">--}}
                                {{--                                        <label for="sort" class="form-label">Sort</label>--}}
                                {{--                                        <input type="number" name="sort" required max="100" min="0"--}}
                                {{--                                               class="form-control  @error('sort') is-invalid @enderror" id="sort"--}}
                                {{--                                               value="{{ old('sort') }}"/>--}}
                                {{--                                        @error('sort')--}}
                                {{--                                        <div class="invalid-feedback">--}}
                                {{--                                            {{ $message }}--}}
                                {{--                                        </div>--}}
                                {{--                                        @enderror--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="col-md-12">
                                    @include('admin.components.status',
                                    ['name' => 'status','label'=> 'Status','active' => 'Aktiv','passive' => 'Passiv',
                                    'attrs' => 'required','selected' => $site->status])
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
@section('scripts')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            $('#site').on('change', function () {
                var site_id = this.value;

                $('#category').html('');
                $.ajax({
                    url: '{{ route('getCategories') }}',
                    data: {
                        site_id: site_id
                    },
                    type: 'get',
                    success: function (data) {
                        $('#category').html('<option value="">Kategoriya Secin</option>');
                        $.map(data.data, function (value, index) {
                            $('#category').append("<option value='" + value.id + "'>" + value.place + "</option>")
                        });

                    }
                });
            });

            $('#category').on('change', function () {
                var category_id = this.value;

                document.getElementById('image').src = '';
                $.ajax({
                    url: '{{route('getCategoryImage')}}',
                    data: {
                        category_id: category_id
                    },
                    type: 'get',
                    success: function (image) {
                        console.log(image.image.image);
                        document.getElementById('image').src = '/storage/site-category/' + image.image.image;
                    }
                });
            });

        });

        // var options = {
        //     filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        //     filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        //     filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        //     filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        // };
        //
        // CKEDITOR.replace('ads', options);

    </script>
@endsection
