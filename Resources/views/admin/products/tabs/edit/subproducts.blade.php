<div id="subProduct">

<table id="tsubProduct" class='table table-dinamic'>
	<thead>
		<tr>
			<th>{{trans('icommerce::products.table.title')}}</th>
			<th>Sku</th>
			<th>{{trans('icommerce::products.table.price')}}</th>
			<th>{{trans('icommerce::products.table.quantity')}}</th>
			<th>{{trans('icommerce::products.table.weight')}}</th>
			<th>{{trans('icommerce::products.table.image')}}</th>
		</tr> 
	</thead> 

	<tbody>
	@php
		$counter2 = 0;
	@endphp
	
	@foreach ($product->children as $children)
		<tr>
			<td hidden="true">
				<input type='text' name='subpId[]' class="subpId" value="{{$children->id}}"/>
			</td>

			<td>
				<input type='text' name='subpTitle[]' class='form-control' value="{{$children->title}}" required/>
			</td>
			<td>
				<input type='text' name='subpSku[]' class='form-control' value="{{$children->sku}}"/>
			</td>
			<td>
				<input type='number' name='subpPrice[]' class='form-control' value="{{$children->price}}" min='0' step='0.01' required/>
			</td>
			<td>
				<input type='number' name='subpQuantity[]' class='form-control' value="{{$children->quantity}}" min='0'/>
			</td>
			<td>
				<input type='number' name='subpWeight[]' class='form-control' value="{{$children->weight}}" min='0' step='0.01' required/>
			</td>
			<td>
				@if(isset($children->options) && isset($children->options->mainimage))
					<img id='prev{{$counter2}}' src='{{url($children->options->mainimage)}}'/>
					<div class='btn btn-default btn-sm remove' data-id-c='{{$counter2}}'>X</div>
					<input type='file' id='filetst{{$counter2}}' class='imgInp' name='subpImage[]' data-id-c='{{$counter2}}'/>
					<input type='hidden' id='hiddenSubP{{$counter2}}' name='hiddenSubImg[]' value="{{url($children->options->mainimage)}}"/>
				@else
					<img id='prev{{$counter2}}' src='{{url("modules/bcrud/img/default.jpg")}}'/>
					<div class='btn btn-default btn-sm remove' data-id-c='{{$counter2}}'>X</div>
					<input type='file' id='filetst{{$counter2}}' class='imgInp' name='subpImage[]' data-id-c='{{$counter2}}'/>
					<input type='hidden' id='hiddenSubP{{$counter2}}' name='hiddenSubImg[]'/>
				@endif
			</td>
			<td>
				<button type="button" class="btn-delete-dinamic2 btn btn-danger"><i class="fa fa-minus-circle"></i></button>
			</td>
		</tr>

		@php
			$counter2++;
		@endphp
	@endforeach

	</tbody>

	<tfoot>
		<tr>
			<td colspan='5'></td>
			<td class='text-left'>
				<button type='button' data-id-op='' class='btn btn-primary btn-add-dinamic2'>
					<i class='fa fa-plus-circle'></i>
				</button>
			</td>
		</tr>
	</tfoot>


</table>

<div id="cap" style="display: none;">
	<div class="loading-del">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
		<span class="sr-only">Loading...</span>
	</div>
</div>

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

    #cap{
    	background: rgba(255,71,0,0.13);
    	position: absolute;
    	width: 100%;
    	height: 100%;
    	z-index: 9999;
    	top: 0;
    	left: 0;
    }

    #cap .loading-del{
    	position: absolute;
    	top: 50%;
    	left: 50%;
    	transform: translate(-50%, -50%);
    }

    </style>

@stop


@push('js-stack')

<script type="text/javascript">

$(function(){ 

	var counter2 = {{$counter2}};
	
	$("#tsubProduct").on('click',".btn-add-dinamic2", function(){
		
		var newRow2 = $("<tr>");
        var cols2 = "";
       
 
        cols2 += '<td>'+createInputTextS('subpTitle[]','required')+'</td>';
        cols2 += '<td>'+createInputTextS('subpSku[]')+'</td>';
        cols2 += '<td>'+createInputFloatS('subpPrice[]','required')+'</td>';
        cols2 += '<td>'+createInputNumberS('subpQuantity[]')+'</td>';
        cols2 += '<td>'+createInputFloatS('subpWeight[]')+'</td>';
        cols2 += '<td>'+createInputImageS('subpImage[]','',counter2)+'</td>';
        cols2 += '<td><button type="button" class="btn-delete-dinamic2 btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

        newRow2.append(cols2);
        $("#tsubProduct").append(newRow2);
        counter2++;

	});

	$("#tsubProduct").on('click',".btn-delete-dinamic2", function(){
		
		var token = $('meta[name="token"]').attr('value');
		var idSubP = $(this).parents('tr').find('.subpId').val();
		var bandDel = 1;

		if($.isNumeric(idSubP)){

			url = '{{ url('backend/icommerce/products/deleteSubproduct') }}' + '/' + idSubP;
  
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                headers: {'X-CSRF-TOKEN': token},
                beforeSend: function(){ 
                    $("#cap").css("display","block");
                },
                success: function(data) {
                    if(data['status'] == 'success'){
                        console.log('success');
                    } 
                    $("#cap").css("display","none");
                },
                error: function(data)
                {
                	bandDel = 0;
                	$("#cap").css("display","none");
                    console.log('Error:', data);
                    alert("{{trans('icommerce::products.messages.error delete product')}}")
                }
            })
		}

		if(bandDel==1)
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
	  	$("#hiddenSubP"+idi).val("{{url("modules/bcrud/img/default.jpg")}}");
	  	$("#filetst"+idi).val("");

	});



});

</script>

@endpush