@extends('layouts.admin_layout')
@section('title', 'Actualizar Datos')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Configuración de la Compañia</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Editar Datos de la Compañía</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="post" action="{{ route('dashboard.company')}}" name="createArticle" id="createArticle"
                        enctype="multipart/form-data">@csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre de La Compañía</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName"
                                        value="{{$companyData->name}}" placeholder="Ingrese Titulo">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dirección de La Compañía</label>
                                    <input type="text" class="form-control" id="companyAddress" name="companyAddress"
                                        value="{{$companyData->companyInfo->company_address}}"
                                        placeholder="Ingrese Direccion">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Teléfono de La Compañía</label>
                                    <input type="text" class="form-control" id="companyPhone" name="companyPhone"
                                        value="{{$companyData->companyInfo->company_phone}}"
                                        placeholder="Ingrese Telefono">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre del Año Actual</label>
                                    <input type="text" class="form-control" id="yearName" name="yearName"
                                        value="{{$companyData->companyInfo->year_name ?? ''}}"
                                        placeholder="Nombre del año actual">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Correo de la Compañia</label>
                                    <input type="text" class="form-control" id="companyEmail" name="companyEmail"
                                        value="{{$companyData->redirect_first_image}}" placeholder="Ingrese Direccion">
                                    <input type="hidden" name="currentRedirectModal"
                                        value="{{$companyData->redirect_first_image}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Horario de oficina prescencial</label>
                                    <div class="row">
                                        <div class="input-group date col" id="datetimepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#datetimepicker" name="fromPresencial" />
                                            <div class="input-group-append" data-target="#datetimepicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                        <div class="input-group date col" id="datetimepicker2" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#datetimepicker2" name="toPrescencial" value="12:38 AM" />
                                            <div class="input-group-append" data-target="#datetimepicker2"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Horario de oficina virtual</label>
                                   <div class="row">
                                        <div class="input-group date col" id="datetimepicker3" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#datetimepicker3" name="fromVirtual" />
                                            <div class="input-group-append" data-target="#datetimepicker3"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                        <div class="input-group date col" id="datetimepicker4" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#datetimepicker4" name="toVirtual" />
                                            <div class="input-group-append" data-target="#datetimepicker4"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Horario de whatsapp</label>
                                    <input type="text" class="form-control" id="companyEmail" name="companyEmail"
                                        value="{{$companyData->redirect_first_image}}" placeholder="Ingrese Direccion">
                                    <input type="hidden" name="currentRedirectModal"
                                        value="{{$companyData->redirect_first_image}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Logo de La Compañía <small>(jpeg, png, jpg, gif,
                                            svg)</small></label>
                                    <input type="file" class="form-control" onchange="preview_image(event)"
                                        name="companyImage" id="companyImage">
                                    <img style="margin-top: 10px;" class="img-fluid" id="output_image"
                                        src="{{$companyData->companyInfo->url_company}}" />
                                    <input type="hidden" name="currentCompanyImage"
                                        value="{{$companyData->companyInfo->url_company}}">
                                </div>
                                <h4>Configuracion SEO</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">Logo MINEDU <small>(jpeg, png, jpg, gif,
                                            svg)</small></label>
                                    <input type="file" class="form-control" onchange="preview_image2(event)"
                                        name="companyCamapignImage" id="companyCamapignImage">
                                    <img style="margin-top: 10px;" class="img-fluid" id="output_image2"
                                        src="{{$companyData->companyInfo->url_logo}}" />
                                    <input type="hidden" name="currentCamapignImage"
                                        value="{{$companyData->companyInfo->url_logo}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Ícono Compañía <small>(solo PNG)</small></label>
                                    <input type="file" class="form-control" onchange="preview_image3(event)"
                                        name="companyIcon" id="companyIcon">
                                    <img style="margin-top: 10px;" class="img-fluid" id="output_image3"
                                        src="{{$companyData->companyInfo->url_icon}}" />
                                    <input type="hidden" name="currentCompanyIcon"
                                        value="{{$companyData->companyInfo->url_icon}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Imagen Modal<small>(jpeg, png, jpg, gif,
                                            svg)</small></label>
                                    <input type="file" class="form-control" onchange="preview_image5(event)"
                                        name="modalImage" id="modalImage">
                                    <img style="margin-top: 10px;" class="img-fluid" id="output_image5"
                                        src="{{$companyData->first_image}}" />
                                    <input type="hidden" name="currentModalImage" value="{{$companyData->first_image}}">
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Título para SEO</label>
                                    <input type="text" class="form-control" placeholder="Ingrese Titulo"
                                        id="companySeoTitle" value="{{$companyData->companySeo->title}}"
                                        name="companySeoTitle">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Descripción para SEO</label>
                                    <textarea class="form-control" name="companySeoDescription"
                                        id="companySeoDescription" placeholder="Ingrese Descripcion"
                                        style="margin-top: 0px; margin-bottom: 0px; height: 93px;">{{$companyData->companySeo->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Insertar Imagen para SEO</label>
                                    <input type="file" class="form-control" onchange="preview_image4(event)"
                                        name="companySeoImage" id="companySeoImage">
                                    <img style="margin-top: 10px;" class="img-fluid" id="output_image4"
                                        src="{{$companyData->companySeo->url_image}}" />
                                    <input type="hidden" name="currentCompanySeoImage"
                                        value="{{$companyData->companySeo->url_image}}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                </div>
                <!-- /.row -->
                <div class="card-footer">
                    <div class="form-actions">
                        <input type="submit" value="Actualizar Configuración" class="btn btn-info">
                    </div>
                </div>
                </form>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<!-- /.content -->
<script>
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

    function preview_image2(event)
    {
        var reader = new FileReader();
        reader.onload = function()
        {
        var output = document.getElementById('output_image2');
        output.src = reader.result;
        output.width = 400;
        output.width = 300

        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function preview_image3(event)
    {
        var reader = new FileReader();
        reader.onload = function()
        {
        var output = document.getElementById('output_image3');
        output.src = reader.result;
        output.width = 400;
        output.width = 300

        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function preview_image4(event)
    {
        var reader = new FileReader();
        reader.onload = function()
        {
        var output = document.getElementById('output_image4');
        output.src = reader.result;
        output.width = 400;
        output.width = 300

        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function preview_image5(event)
    {
        var reader = new FileReader();
        reader.onload = function()
        {
        var output = document.getElementById('output_image5');
        output.src = reader.result;
        output.width = 400;
        output.width = 300

        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</div>
@endsection
