<input type="hidden" id="optionsPSave" name="optionsPSave">

<div class="form-group">
	<select id="selOptions" name="selOptions" class="form-control">
		<option value="null">{{trans('icommerce::options.messages.select')}}</option>
		@foreach($options as $i => $option)
			<option value="{{$option->id}}" data-type="{{$option->type}}" data-description="{{$option->description}}">{{$option->description}}</option>
		@endforeach
	</select>
</div>

<div id="optionsProduct">
	<div class="col-sm-2">
		<ul id="opul" class="nav nav-pills nav-stacked">

		</ul>
	</div>

	<div class="col-sm-10">
		<div class="tab-content">

		</div>
	</div>
</div>

@section('scripts')
    @parent

    <style type="text/css">

    #opul .fa-minus-circle{
    	position: absolute;
    	right: 0;
    	top: -5px;
    	z-index: 1;
    	cursor: pointer;
    }

    #optionsProduct .tab-content table tbody tr td{
    	vertical-align: middle;
    }

    </style>

@stop

@push('js-stack')



<script type="text/javascript">



$(function(){

	var act="active",cont=0;
	var miz = $("#optionsProduct .nav"), mder = $("#optionsProduct .tab-content");

	var vOptionValues = '{!!$optionValues!!}';
	var objOptionValues = jQuery.parseJSON(vOptionValues);
	var vOptionsChild = '{!!$optionsChildren!!}';
	var objOptionChild = jQuery.parseJSON(vOptionsChild);

	var trans = 0;

	@if ($entity->translationEnabled())
		trans = 1;
		languaj = '{{locale()}}';
	@endif

	$( "#selOptions" ).change(function() {
	if($(this).val()!="null"){

		valideActive();

		var type = $(this).find(':selected').data('type');
		var optionid = $(this).val();
		var desc = $(this).find(':selected').data('description');
		var iditem = "op"+cont;

		html = "<li class='active' id=t"+iditem+" data-id-right='"+iditem+"' data-id-option='"+optionid+"' data-type-option='"+type+"'><i data-ge='"+iditem+"'class='fa fa-minus-circle closed'></i> <a data-toggle='tab' href='#"+iditem+"'>"+desc+"</a></li>";


		miz.append(html);

		html = "";
		htmlini = "<div id='"+iditem+"' class='tab-pane fade in active'>";
		htmlend = "</div>";

		if(type=="text"){
			htmlRequired = createRequired(iditem,'vrequired');
			htmlText = createText(iditem,'vtext');
			html = htmlini+htmlRequired+htmlText+htmlend;
			// htmlMultiple = createMultiple(iditem,optionid);
			// html = htmlini+htmlRequired+htmlMultiple+htmlend;
			mder.append(html);
		}

		if(type=="textarea"){
			htmlRequired = createRequired(iditem,'vrequired');
			htmlTextArea = createTextArea(iditem,'vtextarea');
			html = htmlini+htmlRequired+htmlTextArea+htmlend;
			mder.append(html);
		}

		if(type=="select" || type=="checkbox" || type=="radio" ){
			htmlRequired = createRequired(iditem,'vrequired');
			htmlMultiple = createMultiple(iditem,optionid);
			html = htmlini+htmlRequired+htmlMultiple+htmlend;
			mder.append(html);
		}

		cont++;

	}
	});



	$("#opul").on('click',".closed", function(){
		var idgral = $(this).data('ge');
		var delTabiz = "t"+$(this).data('ge');

		$("#"+delTabiz).remove();
		$("#"+idgral).remove();

	});

	var counter = 0;

	$(".tab-pane").on('click',".btn-add-dinamic", function(){

		var idtable = "#tb"+$(this).data('id-op');
		var newRow = $("<tr>");
        var cols = "";

        var optionid = $(idtable).data('option-id');

        cols += createSelectOptions("tableSOption",optionid);
        cols += createInputNumber("tableQuantity");
        cols += createSelecSustract("tableSustract");
        cols += '<td>'+createSelectPrefix("tablePricePrefix")+createInputFloat("tablePrice","")+'</td>';
        cols += '<td>'+createSelectPrefix("tableWeightPrefix")+createInputFloat("tableWeight","")+'</td>';
        cols += '<td>'+createSelectChildOptions("tableSOptionChild",optionid)+'</td>';
        cols += '<td><button type="button" class="btn-delete-dinamic btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

        newRow.append(cols);
        $(idtable).append(newRow);

        counter++;

	});

	$(".tab-pane").on('click',".btn-delete-dinamic", function(){
		$(this).closest("tr").remove();
	});

	function valideActive(){
		if($("#optionsProduct .nav li").hasClass("active")){
			$( "#optionsProduct .nav li.active" ).removeClass("active");
		}

		if($("#optionsProduct .tab-content .tab-pane ").hasClass("active")){
			$("#optionsProduct .tab-content .tab-pane.active").removeClass("active");
			$("#optionsProduct .tab-content .tab-pane.in").removeClass("in");
		}
	}

	function createRequired(iditem,name){

		htmliniR = "<div class='form-group'>";
		htmlendR ="</div>";

		hmtllabel = "<label for='req"+iditem+"'>{{trans('icommerce::products.table.required')}}</label>"
		htmlselectini = "<select name='"+name+"' class='form-control'>";
		htmlselectend = "</select>";

		htmloptions = "<option value='0'>NO</option><option value='1'>{{trans('icommerce::products.table.yes')}}</option>";

		html = htmliniR+hmtllabel+htmlselectini+htmloptions+htmlselectend+htmlendR;

		return html;
	}

	function createText(iditem,name){

		htmliniT = "<div class='form-group'>";
		htmlendT ="</div>";

		htmllabelT = "<label for='intext"+iditem+"'>{{trans('icommerce::products.table.txt')}}</label>";

		htmlTextT =  "<input type='text' name='"+name+"' id='intext"+iditem+"' class='form-control' required />";

		htmlT = htmliniT+htmllabelT+htmlTextT+htmlendT;

		return htmlT;
	}

	function createTextArea(iditem,name){

		htmliniTa = "<div class='form-group'>";
		htmlendTa ="</div>";

		htmllabelTa = "<label for='intext"+iditem+"'>{{trans('icommerce::products.table.txt')}}</label>";

		htmlTextTa =  "<textarea rows='5' name='"+name+"' id='intext"+iditem+"' class='form-control' required></textarea>";

		htmlTa = htmliniTa+htmllabelTa+htmlTextTa+htmlendTa;

		return htmlTa;

	}

	function createMultiple(iditem,optionid){
		htmliniMu = "<table class='table table-dinamic' id='tb"+iditem+"' data-option-id='"+optionid+"'>";
		htmlendMu="</table>";

		htmlHeaderMu = "<thead><tr><th>{{trans('icommerce::product_option_values.table.option')}}</th><th>{{trans('icommerce::product_option_values.table.quantity')}}</th><th>{{trans('icommerce::product_option_values.table.substract')}}</th><th>{{trans('icommerce::product_option_values.table.price')}}</th><th>{{trans('icommerce::product_option_values.table.weight')}}</th><th>{{trans('icommerce::products.table.options')}}</th><th></th></tr> </thead> <tbody></tbody>";

		htmlFooterMu = "<tfoot><tr><td colspan='6'></td><td class='text-left'><button type='button' data-id-op='"+iditem+"' class='btn btn-primary btn-add-dinamic'><i class='fa fa-plus-circle'></i></button></td></tr></tfoot>";

		htmlMul = htmliniMu+htmlHeaderMu+htmlFooterMu+htmlendMu;

		return htmlMul;
	}

	function createSelectOptions(name,optionid){

		htmlSOIni = "<td><select name='"+name+"' class='form-control'>";
		htmlSOEnd = "</select></td>";
		htmlSOoptions = "";

		$.each(objOptionValues , function() {
			htmlOpInd = "";
			opValueDes = "";
			if(optionid==this['option_id']){
				if(trans==1){
					opValueDes = this['description'][languaj];
				}else{
					opValueDes = this['description'];
				}
				htmlOpInd="<option value='"+this['id']+"'>"+opValueDes+"</option>";
			}
    		htmlSOoptions+=htmlOpInd;
  		});

		htmlSelectOptions = htmlSOIni+htmlSOoptions+htmlSOEnd;

		return htmlSelectOptions;
	}
	function createSelectChildOptions(name,optionid){

		htmlSOIni = "<select name='"+name+"' class='form-control'>";
		htmlSOEnd = "</select>";
		htmlSOoptions = "<option value='0'>{{trans('icommerce::products.table.select option')}}</option>";
		var option_child_id=0;
		for(var i=0;i<objOptionChild.length;i++){
			// console.log(objOptionChild[i]);
			if(objOptionChild[i].parent_id==optionid){
				option_child_id=objOptionChild[i].id;
				// console.log(objOptionChild[i].id);
				$.each(objOptionValues , function() {
					htmlOpInd = "";
					opValueDes = "";
					if(option_child_id!=0 && option_child_id==this['option_id']){
						if(trans==1){
							opValueDes = this['description'][languaj];
						}else{
							opValueDes = this['description'];
						}
						htmlOpInd="<option value='"+this['id']+"'>"+opValueDes+"</option>";
					}
					htmlSOoptions+=htmlOpInd;
				});
				// break;
			}
		}//for get option child


		htmlSelectOptions = htmlSOIni+htmlSOoptions+htmlSOEnd;
		// htmlSelectOptions="<label>dasda</label>";
		return htmlSelectOptions;
	}

	function createInputNumber(name){

		htmlInputNumber = "<td><input type='number' name='"+name+"' class='form-control' min='0' /></td>";
		return htmlInputNumber;

	}

	function createSelecSustract(name){
		htmlSSIni = "<td><select name='"+name+"' class='form-control'>";
		htmlSSEnd = "</select></td>";
		htmlSSoptions = "<option value='0'>NO</option><option value='1' selected>{{trans('icommerce::products.table.yes')}}</option>";

		htmlSelectSustract = htmlSSIni+htmlSSoptions+htmlSSEnd;

		return htmlSelectSustract;
	}

	function createSelectPrefix(name){
		htmlSPIni = "<select name='"+name+"' class='form-control'>";
		htmlSPEnd = "</select>";
		htmlSPoptions = "<option value='+' selected>+</option><option value='-'>-</option>";

		htmlSelectPrefix = htmlSPIni+htmlSPoptions+htmlSPEnd;

		return htmlSelectPrefix;
	}

	function createInputFloat(name,req){
		htmlInputFloat = "<input type='number' name='"+name+"' class='form-control' min='0' step='0.01'"+req+"/>";
		return htmlInputFloat;
	}

	$( ".content form" ).submit(function(e) {

		jsonObj = [];

		$('#opul li').each(function(i)
		{
			var dOptionId = $(this).data('id-option');
			var dOptionType = $(this).data('type-option');
			var contentDerId = "#"+$(this).data('id-right');
			var valuesObj = [];

			var selectRequired = $(contentDerId+" select[name='vrequired']").val();
			item = {};
			item ["option_id"] = dOptionId;
			item ["required"] = parseInt(selectRequired,10);

			if(dOptionType=="text"){
				item ["value"] = $(contentDerId+" input[name='vtext']").val();
			}

			if(dOptionType=="textarea"){
				item ["value"] = $(contentDerId+" textarea[name='vtextarea']").val();
			}

			if(dOptionType=="select" || dOptionType=="checkbox" || dOptionType=="radio"){
				item ["value"] = "";

				var tableDi = contentDerId+" .table-dinamic tbody tr";
				var valuesObj = [],checkRows = 0;

				$(tableDi).each(function(g)
				{
					var tSOption = $(this).find("select[name='tableSOption']").val();
					var tSOptionChild = $(this).find("select[name='tableSOptionChild']").val();
					var tQuantity = $(this).find("input[name='tableQuantity']").val();
					var tSustract = $(this).find("select[name='tableSustract']").val();
					var tPricePrefix = $(this).find("select[name='tablePricePrefix']").val();
					var tPrice = $(this).find("input[name='tablePrice']").val();
					var tWeightPrefix = $(this).find("select[name='tableWeightPrefix']").val();
					var tWeight = $(this).find("input[name='tableWeight']").val();
					/////Acá agregar option adicional
					if(tWeight==""){
						tWeight = 0;
					}

    				optionItems = {};

    				optionItems["option_id"] = dOptionId;
			    	optionItems["option_value_id"] = parseInt(tSOption,10);
			    	optionItems["children_option_value_id"] = parseInt(tSOptionChild,10);
			    	optionItems['quantity'] = parseInt(tQuantity,10);
			    	optionItems['substract'] = parseInt(tSustract,10);
			    	optionItems['price'] = parseFloat(tPrice);
			    	optionItems['price_prefix'] = tPricePrefix;
			    	optionItems['points'] = 0;
			    	optionItems['points_prefix'] = "+";
			    	optionItems['weight'] = parseFloat(tWeight);
			    	optionItems['weight_prefix'] = tWeightPrefix;

			    	valuesObj.push(optionItems);

			    	checkRows++;

				});

				if(checkRows==0){
					alert("{{trans('icommerce::product_option_values.messages.alert multiples')}}");
					e.preventDefault();
					return false;
				}

			}

			item ["optionValues"] = valuesObj;

        	jsonObj.push(item);

		});

		$("#optionsPSave").val(JSON.stringify(jsonObj));

		//console.log(jsonObj);e.preventDefault();return false;
	});

});

</script>

@endpush

{{--
@include('icommerce::admin.products.partials.vue-options')
--}}
