<script>
     @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script type="text/javascript">
                toastr.error("{{$error}}");
            </script>
        @endforeach
    @endif

    @if(session('error'))
        <script type="text/javascript">
            toastr.error("{{session('error')}}");
        </script>
    @endif

    @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }

            toastr.success("{{ session('success') }}");
         @endif
</script>