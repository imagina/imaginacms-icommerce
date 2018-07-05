{!! Form::normalInput('sku','Sku', $errors,$product) !!}

{!! Form::normalInputOfType('number','quantity', trans('icommerce::products.table.quantity'), $errors,$product,$opQuantity) !!}

<div class="form-group">
	<label for="stock_status">Stock Status</label>
	<select class="form-control" id="stock_status" name="stock_status">
		@foreach ($stockstatus->lists() as $index => $ts)
				<option value="{{$index}}" @if($index==$product->stock_status) selected @endif >{{$ts}}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="shipping" style="margin-right: 5px">{{trans('icommerce::products.table.shipping')}}</label>

	<label class="radio-inline"><input type="radio" name="shipping" value="1" @if($product->shipping==1)checked="checked" @endif>
		{{trans('icommerce::products.table.yes')}}
	</label>
	<label class="radio-inline"><input type="radio" name="shipping" value="0" @if($product->shipping==0)checked="checked" @endif>NO</label>	
	
</div>


{!! Form::normalInputOfType('number','price', trans('icommerce::products.table.price'), $errors,$product,$opPrice) !!}

<div class="form-group">
	<label for="freeshipping" style="margin-right: 5px">Freeshipping</label>
	{!! Form::normalCheckbox('freeshipping',trans('icommerce::products.table.freeshipping'), $errors,$product) !!}
</div>

{!! Form::normalInputOfType('date','date_available', trans('icommerce::products.table.date available'), $errors, $product) !!}

{!! Form::normalInputOfType('number','weight', trans('icommerce::products.table.weight'), $errors,$product,$opFloat) !!}

{!! Form::normalInputOfType('number','length', trans('icommerce::products.table.length'), $errors,$product,$opFloat) !!}

{!! Form::normalInputOfType('number','width', trans('icommerce::products.table.width'), $errors,$product,$opFloat) !!}

{!! Form::normalInputOfType('number','height', trans('icommerce::products.table.height'), $errors,$product,$opFloat) !!}

<div class="form-group">
	<label for="substract" style="margin-right: 5px">{{trans('icommerce::products.table.substract')}}:</label>

	<label class="radio-inline"><input type="radio" name="substract" value="1" @if($product->substract==1)checked="checked" @endif>
		{{trans('icommerce::products.table.yes')}}
	</label>
	<label class="radio-inline"><input type="radio" name="substract" value="0" @if($product->substract==0)checked="checked" @endif>NO</label>	

</div>

{!! Form::normalInputOfType('number','minimum', trans('icommerce::products.table.minimum'), $errors,$product,$opMinimum) !!}

{!! Form::normalInput('reference',trans('icommerce::products.table.reference'), $errors,$product) !!}