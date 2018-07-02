<div class="form-group">
    <label for="pfile">{{trans('icommerce::products.table.file product')}}</label>

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

});

</script>

@endpush