@php
    $width      = 'col-md-'.( $width ?? '12' );
    $name       =  $name ?? 'name';
    $src        =  $src  ?? '';
    $class      =  $class ?? null;
@endphp

<style>
     .center {
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .form-input {
            width:350px;
            padding:20px;
            background:#fff;
            box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
                    3px 3px 7px rgba(94, 104, 121, 0.377);
        }
        .form-input input {
            display:none;
        }

        .form-input label {
            display:block;
            width:45%;
            height:45px;
            margin-left: 25%;
            line-height:50px;
            text-align:center;
            background:#1172c2;
            color:#fff;
            font-size:15px;
            font-family:"Open Sans",sans-serif;
            text-transform:Uppercase;
            font-weight:600;
            border-radius:5px;
            cursor:pointer;
        }
</style>

<div class="center {{ $class }}">
    <div class="form-input">
        {{-- preview image --}}
        <div class="preview">
            <img id="file-ip-1-preview" style="width: 300px; max-height:300px;" src="{{ $src != '' ? asset('storage/site-category/'.$src) : ' ' }}" alt="">
        </div>
        {{-- input box --}}
        <label for="file-ip-1">Upload Image</label>
        <input type="file" id="file-ip-1" name="{{ $name }}"  accept="image/*" onchange="showPreview(event);">
    </div>
    @error($name)
        <div class="invalid-feedback" style="display: block;position: absolute;left: 68%;top: 81%;">
            {{ $message }}
        </div>
    @enderror
</div>

<script>
       function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>