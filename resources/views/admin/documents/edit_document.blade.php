@extends('layouts.admin_layout')
@section('title', 'Editar Documento')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Documentos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/sections') }}">Documentos</a></li>
                        <li class="breadcrumb-item active">Editar Documento</li>
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
                            <h3 class="card-title">Editar Documento</h3>
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
                        <form role="form" method="post"
                            action="{{ route('dashboard.documents.edit', $documentDetail['id'] )}}"
                            name="updateDocument" id="updateDocument" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Seleccione Categoria</label>
                                    <select name="categoryId" id="categoryId" class="form-control" style="width: 100%;">
                                        <option <?php if($documentDetail['category_id']===1) echo 'selected="selected"'
                                            ; ?> value="1">Documentos Generales</option>
                                        <option <?php if($documentDetail['category_id']===2) echo 'selected="selected"'
                                            ; ?> value="2">Convocatorias</option>
                                        <option <?php if($documentDetail['category_id']===3) echo 'selected="selected"'
                                            ; ?> value="3">Normativas</option>
                                    </select>
                                    <input type="hidden" name="currentCategoryId"
                                        value="{{ $documentDetail['category_id'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Titulo Documento</label>
                                    <input type="text" class="form-control" placeholder="Ingrese Nombre"
                                        id="documentTitle" name="documentTitle" value="{{ $documentDetail['title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Descripción</label>
                                    <textarea class="form-control" rows="3" name="documentDescription"
                                        id="documentDescription" placeholder="Ingrese Descripcion"
                                        style="margin-top: 0px; margin-bottom: 0px; height: 93px;">{!! $documentDetail['description'] !!}</textarea>
                                </div>
                                <div class="form-group" id="documentsFile">
                                    <label class="control-label">Subir Archivos</label>
                                    <div class="controls">
                                        <div class="needsclick dropzone" id="document-dropzone">
                                        </div>
                                        <br>
                                        <input type="hidden" name="currentFiles">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
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
      var uploadedDocumentMap = {}
      Dropzone.options.documentDropzone = {
         url: '{{ route('documents.storeMedia') }}',
         maxFilesize: 15, // MB
         addRemoveLinks: true,
         acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
         headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
         },
         success: function(file, response) {
            $('form').append('<input type="hidden" name="files[]" value="' + response.name + '">')
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
            $('form').find('input[name="files[]"][value="' + name + '"]').remove()
         },
         init: function() {
            @if (isset($files))
               var files =
               {!! json_encode($files) !!}
               for (var i in files) {
               var file = files[i]
               console.log(file);
               file = {
               ...file,
               width: 226,
               height: 324
               }
               this.options.addedfile.call(this, file)
               this.options.thumbnail.call(this, file,'https://firebasestorage.googleapis.com/v0/b/url-short-286413.appspot.com/o/pdf-128.png?alt=media&token=2c85269d-2f5b-4c86-9400-4f1a1c65927d')
               file.previewElement.classList.add('dz-complete')

               $('form').append('<input type="hidden" name="files[]" value="' + file.file_name + '">')
               }
            @endif
         }
      }
</script>
@endsection
