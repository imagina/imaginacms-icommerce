<div id="subProduct">

<table id="tsubProduct" class='table table-dinamic'>
	<thead>
		<tr>
			<th>{{trans('icommerce::products.table.title')}}</th>
			<th>Sku</th>
			<th>{{trans('icommerce::products.table.price')}}</th>
			<th>{{trans('icommerce::products.table.quantity')}}</th>
			<th>{{trans('icommerce::products.table.weight')}}</th>
			<th>{{trans('icommerce::products.table.order_weight')}}</th>
			<th>{{trans('icommerce::products.table.image')}}</th>
		</tr> 
	</thead> 

	<tbody>
	</tbody>

	<tfoot>
		<tr>
			<td colspan='6'></td>
			<td class='text-left'>
				<button type='button' data-id-op='' class='btn btn-primary btn-add-dinamic'>
					<i class='fa fa-plus-circle'></i>
				</button>
			</td>
		</tr>
	</tfoot>


</table>


</div>

@section('scripts')
    @parent

    <style type="text/css">

    #subProduct table tbody tr td{
    	vertical-align: middle;
    }

    #subProduct table tbody tr td img{
    	max-width: 100%;
    	max-width: 80px;
    }

    #subProduct table tbody tr td .imgInp{
    	margin-top: 7px;
    }

    #subProduct table tbody tr td .remove{
    	margin-left: 10px;
    }

    </style>

@stop

@push('js-stack')

<script type="text/javascript">

$(function(){ 

	var counter2 = 0;
	

	$("#tsubProduct").on('click',".btn-add-dinamic", function(){
		
		var newRow2 = $("<tr>");
        var cols2 = "";
        //var idSubProduct = "subp"+counter2;
        	
        cols2 += '<td>'+createInputTextS('subpTitle[]','required')+'</td>';
        cols2 += '<td>'+createInputTextS('subpSku[]')+'</td>';
        cols2 += '<td>'+createInputFloatS('subpPrice[]','required')+'</td>';
        cols2 += '<td>'+createInputNumberS('subpQuantity[]')+'</td>';
        cols2 += '<td>'+createInputFloatS('subpWeight[]')+'</td>';
        cols2 += '<td>'+createInputNumberS('subpOrderWeight[]')+'</td>';
        cols2 += '<td>'+createInputImageS('subpImage[]','',counter2)+'</td>';
        cols2 += '<td><button type="button" class="btn-delete-dinamic btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

        newRow2.append(cols2);
        $("#tsubProduct").append(newRow2);
        counter2++;

	});

	$("#tsubProduct").on('click',".btn-delete-dinamic", function(){
		$(this).closest("tr").remove();
	});

	function createInputTextS(name,req=''){
		htmlInputTextS = "<input type='text' name='"+name+"' class='form-control' "+req+"/>";
		return htmlInputTextS;
	}

	function createInputFloatS(name,req=''){
		htmlInputFloatS = "<input type='number' name='"+name+"' class='form-control' min='0' step='0.01'"+req+"/>";
		return htmlInputFloatS;
	}

	function createInputNumberS(name,req=''){

		htmlInputNumberS = "<input type='number' name='"+name+"' class='form-control' min='0'"+req+"/>";
		return htmlInputNumberS;

	}

	function createInputImageS(name,req='',counter2){
		
  		htmlImageIni1 = "<img id='prev"+counter2+"' src='{{url("modules/bcrud/img/default.jpg")}}'/>";
  		htmlImageIni2 = "<input type='file' id='filetst"+counter2+"' class='imgInp' name='"+name+"' data-id-c='"+counter2+"'/>";

  		htmlOtro = "<input type='hidden' id='hiddenSubP"+counter2+"' name='hiddenSubImg[]'/>";
  		htmlImgDel = "<div class='btn btn-default btn-sm remove' data-id-c='"+counter2+"'>X</div>";

  		htmImageS = htmlImageIni1+htmlImgDel+htmlImageIni2+htmlOtro;

  		return htmImageS;
	}

	function readURL(input,id) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
		    reader.onload = function(e) {
		      $('#prev'+id).attr('src', e.target.result);
		      $("#hiddenSubP"+id).val(reader.result);
		    }
		    reader.readAsDataURL(input.files[0]);
		}
	}

	$("#tsubProduct").on("change",'.imgInp',function() {
	  	readURL(this,$(this).data("id-c"));
	});

	$("#tsubProduct").on("click",'.remove',function() {
	  	idi = $(this).data("id-c");

	  	$("#prev"+idi).attr('src','{{url("modules/bcrud/img/default.jpg")}}');
	  	$("#hiddenSubP"+idi).val("");
	  	$("#filetst"+idi).val("");

	});

});

</script>

@endpush