<input type="hidden" id="hiddenFileDel" name="hiddenFileDel" value="0">

<div class="form-group">
    <label for="pfile">{{trans('icommerce::products.table.file product')}}</label>
    @if(isset($product->options->mainfile))
    	<div id="pfile-product" class="alert alert-success" role="alert">
            <button type="button" class="close" aria-label="Close" id="pfile-delete">
                <span aria-hidden="true">&times;</span>
            </button>
    		<a href="{{url($product->options->mainfile)}}" target="_blank" style="text-decoration: none;">{{url($product->options->mainfile)}}</a>
           
    	</div>
    @endif
    <input type="file" class="form-control-file" id="pfile" name="pfile" aria-describedby="fileHelp">
    <button id="btnReset" type="button" class="btn btn-warning btn-xs">Reset</button>
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
    <small id="fileHelp" class="form-text text-muted">
        {{trans('icommerce::products.table.file product formats')}}: PDF -
    	{{trans('icommerce::products.table.file product size max')}}: 2MB
    </small>

</div>

@push('js-stack')

<script type="text/javascript">

$(function(){ 

    $('#btnReset').on('click', function(e){
        $('#pfile').val("");
    });

    $('#pfile-delete').on('click', function(e){
        $('#pfile-product').hide(500);
        $('#hiddenFileDel').val(1);
    });

});

</script>

@endpush

