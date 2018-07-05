@extends('layouts.master')
@section('content')
    <div class="container text-center py-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-secondary">
                    {{trans('icommerce::common.bulkload.massive_load')}}
                </h5>

                <h6 class="card-subtitle mb-2 text-muted">
                    {{trans('icommerce::common.bulkload.pro_cat_bran')}}
                </h6>
                <p class="card-text">
                    <input type="file" onchange="read_file.controller(this)">
                </p>
                <a class="btn btn-primary text-white">
                    <i class="fa fa-cloud-upload"></i>
                    {{trans('icommerce::common.bulkload.load_data')}}
                </a>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script type="text/javascript">
        var read_file = {
            controller: function(input){
                var oFile = $(input)[0].files[0];

                //var oFile = oEvent.target.files[0];
                var sFilename = oFile.name;
                // Create A File Reader HTML5
                var reader = new FileReader();

                // Ready The Event For When A File Gets Selected
                reader.onload = function(e) {
                    var data = e.target.result;
                    console.log(data);
                    var cfb = XLS.CFB.read(data, {type: 'binary'});
                    var wb = XLS.parse_xlscfb(cfb);

                    // Loop Over Each Sheet
                    wb.SheetNames.forEach(function (sheetName) {
                        // Obtain The Current Row As CSV
                        var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);
                        var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);

                        //$("#my_file_output").html(sCSV);
                        console.log(oJS)
                    });
                };

                // Tell JS To Start Reading The File.. You could delay this if desired
                reader.readAsBinaryString(oFile);
            }
        };

        function filePicked(oEvent) {
            console.log(oEvent.target);
            // Get The File From The Input
            var oFile = oEvent.target.files[0];
            var sFilename = oFile.name;
            // Create A File Reader HTML5
            var reader = new FileReader();

            // Ready The Event For When A File Gets Selected
            reader.onload = function(e) {
                var data = e.target.result;
                var cfb = XLS.CFB.read(data, {type: 'binary'});
                var wb = XLS.parse_xlscfb(cfb);
                // Loop Over Each Sheet
                wb.SheetNames.forEach(function(sheetName) {
                    // Obtain The Current Row As CSV
                    var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);
                    var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);

                    $("#my_file_output").html(sCSV);
                    console.log(oJS)
                });
            };

            // Tell JS To Start Reading The File.. You could delay this if desired
            reader.readAsBinaryString(oFile);
        }
    </script>
@stop

