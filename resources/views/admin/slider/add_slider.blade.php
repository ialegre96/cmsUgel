@extends('layouts.admin_layout')
@section('title', 'Agregar Slider')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Slider</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('dashboard/slider') }}">Slider</a></li>
                        <li class="breadcrumb-item active">Agregar Slider</li>
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
                            <h3 class="card-title">Agregar Slider</h3>
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
                        <form role="form" method="post" action="{{ route('dashboard.slider.create')}}" name="addSlider"
                            id="addSlider" enctype="multipart/form-data">@csrf
                            <div class="card-body">
                                <div class="control-group">
                                    <label class="control-label">Banner Image</label>
                                    <div class="controls">
                                        <input type="file" class="form-control" name="sliderImage"
                                            onchange="preview_image(event)">
                                        <br>
                                        <img class="img-fluid" style="margin-top: 10px;" id="output_image" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="showCaption" id="showCaption"
                                        aria-label="Mostrar Texto en Slide">
                                    <label for="showCaption">Mostrar Texto en Slider</label>
                                </div>
                                <div class="control-group captionSlider" style="display: none">
                                    <h3>Contenido del Texto</h3>
                                    <div class="form-group">
                                        <label for="titleCaption">Titulo de Texto</label>
                                        <input type="text" class="form-control" name=" titleCaption" id="titleCaption"
                                            placeholder="Ingrese titulo">
                                    </div>
                                    <div class="form-group">
                                        <label for="subTitleCaption">Subtitulo</label>
                                        <input type="text" class="form-control" name=" subTitleCaption"
                                            id="subTitleCaption" placeholder="Ingrese Subtitulo">
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
