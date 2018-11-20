@include('icommerce::admin.products.partials.featured-img',['crop' => 0,'name' => 'mainimage','action' => 'update'])

<div class="clearfix"></div>
<br>
<div class="galleryModal col-xs-12">
	<div>
		<label>{{ trans('icommerce::products.gallery.title') }} </label>
	</div>

	<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
      	{{ trans('icommerce::products.gallery.edit gallery') }}
	</button>	
</div>