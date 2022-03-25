@extends('layouts.admin_layout')
@section('title', 'Agregar Convocatoria')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Convocatorias</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.documents.index') }}">Convocatorias</a>
                        </li>
                        <li class="breadcrumb-item active">Agregar Convocatoria</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Agregar Convocatoria</h3>
                        </div>
                        <!-- /.card-header -->

                        @if ($errors->any())
                        <div class="alert alert-danger" style="margin-top: 10px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('dashboard.announcement.create')}}"
                            name="addSection" id="addSection" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Seleccione Categoria</label>
                                    <select name="categoryId" id="categoryId" class="form-control">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->titulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Titulo Convocatoria</label>
                                    <input type="text" class="form-control" placeholder="Ingrese Nombre"
                                        id="announcementTitle" name="announcementTitle">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Descripción</label>
                                    <textarea class="form-control" rows="3" name="announcementDescription"
                                        id="announcementDescription" placeholder="Ingrese Descripcion"
                                        style="margin-top: 0px; margin-bottom: 0px; height: 93px;"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Documentos</label>
                                    <div class="needsclick dropzone" id="document-dropzone">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
</div>
@push('script')
<script>
    var uploadedDocumentMap = {}
Dropzone.options.documentDropzone = {
url: '{{ route('announcement.storeMedia') }}',
maxFilesize: 15, // MB
addRemoveLinks: true,
acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
headers: {
'X-CSRF-TOKEN': "{{ csrf_token() }}"
},
success: function(file, response) {
$('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')
uploadedDocumentMap[file.name] = response.name
},
removedfile: function(file) {
file.previewElement.remove()
var name = ''
if (typeof file.file_name !== 'undefined') {
name = file.file_name
} else {
name = uploadedDocumentMap[file.name]
}
$('form').find('input[name="file[]"][value="' + name + '"]').remove()
}
}
</script>
@endpush
<script type='text/javascript'>
    function preview_image(event)
      {
       var reader = new FileReader();
       reader.onload = function()
       {
        var output = document.getElementById('output_image');
        output.src = reader.result;
        output.width = 400;
        output.width = 300

       }
       reader.readAsDataURL(event.target.files[0]);
      }
</script>
@endsection
