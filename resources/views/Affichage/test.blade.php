<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="col-md-6">
        <h4>Importation cv</h4>
        <form action="{{ route('upload.uploadCv')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            {{-- <label for="file">Etapes</label> --}}
            <input type="file" class="form-control-file" id="file" name="cv">
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
    
    @if(session('success'))
    <p>{{ session('success') }}</p>
@endif
</body>
</html>