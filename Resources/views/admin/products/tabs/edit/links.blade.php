<div class="form-group">
	<label for="manufacturer_id">{{trans('icommerce::manufacturers.single')}}</label>
	<select class="form-control" id="manufacter_id" name="manufacter_id">
		<option value=""></option>
		@if(count($manufacturers)>0)
			@foreach ($manufacturers as $index => $manufacturer)
					<option value="{{$manufacturer->id}}" @if($manufacturer->id==$product->manufacter_id) selected @endif>{{$manufacturer->name}}</option>
			@endforeach
		@endif
	</select>
</div>

@php
	if(isset($product->tags) && count($product->tags)>0){
		$oldTag = array();
		foreach ($product->tags as $tag){
			array_push($oldTag,$tag->id);
		}
	}
@endphp

<div class="form-group">
	<label for="tags" style="width:100%;">{{trans('icommerce::tags.plural')}}</label>
	<select name="tags[]" class="form-control select2" multiple style="width:100%;">
		@foreach ($tags as $tag)
			<option value="{{$tag->id}}" @isset($oldTag) @if(in_array($tag->id, $oldTag)) selected @endif @endisset>{{$tag->title}}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="related_ids" style="width:100%;">{{trans('icommerce::products.table.related_products')}}</label>
	<select id="related_ids" name="related_ids[]" class="form-control" multiple style="width:100%;">
		@if(!empty($product->related_ids))
			@foreach ($product->related_ids as $product)
				<option value="{{$product->id}}" selected>{{$product->title}}</option>
			@endforeach
		@endif
	</select>
</div>

<link href="{{asset('modules/bcrud/vendor/select2/select2.css')}}" rel="stylesheet" type="text/css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="{{asset('modules/bcrud/vendor/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />

@push('js-stack')
       
    <script src="{{ asset('modules/bcrud/vendor/select2/select2.js') }}"></script>
    @if(locale()=="es")
    	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
    @endif
    <script>
        jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2_multiple box
                $('.select2').each(function (i, obj) {
                    if (!$(obj).data("select2"))
                    {
                        $(obj).select2({
                            tags : true,
                            allowClear: true
                        });
                    }
                });

                $("#related_ids").each(function (i, obj) {
                	if (!$(obj).hasClass("select2-hidden-accessible"))
            		{
	                	$(obj).select2({
	                		theme: 'bootstrap',
	                    	multiple: true,
	                    	placeholder: "{{trans('icommerce::products.table.search')}}",
	                    	minimumInputLength: "2",
	                    	language:"{{locale()}}",
	                    	ajax: {
		                        url: "{{route('admin.icommerce.product.searchProductsRelated')}}",
		                        dataType: 'json',
		                        quietMillis: 250,
		                        data: function (params) {
		                          	return {
                                		q: params.term, // search term
                                		page: params.page
                            		};
		                        },
		                       	processResults: function (data, params) {
								    params.page = params.page || 1;
								   

								   	return {
		                                results: $.map(data.data, function (item) {
		                                	
		                                	if (typeof item["title"] === "object"){
					                            titl = item["title"].{{locale()}};
					                        }else{
					                            titl = item["title"];
					                        }

		                                    return {
		                                        text: titl,
		                                        id: item["id"]
		                                    }

		                                }),
		                                more: data.current_page < data.last_page
		                            };
		                        },
		                        cache: true
	                    	},

	                	});
	                }
                });
        });
   	</script>
@endpush