@extends('layouts.master')
@section('content')
    <div class="container text-center py-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-secondary">
                    Carga Masiva
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    Productos - categorias - marcas
                </h6>
                <p class="card-text">
                    <input type="file" onchange="read_file.controller(this)">
                </p>
                <a class="btn btn-primary text-white">
                    <i class="fa fa-cloud-upload"></i>
                    Cargar datos
                </a>


                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quick Example</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" enctype='multipart/form-data' action="{{route('admin.icommerce.bulkload.import')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" id="exampleInputFile" name="importfile">

                                <p class="help-block">compatible files CSV, XLSX</p>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>







            </div>
        </div>

    </div>


@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

@stop

