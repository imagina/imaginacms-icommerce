@include('icommerce::admin.products.partials.featured-img',['crop' => 0,'name' => 'mainimage','action' => 'create'])

<div class="clearfix"></div>
<br>
<div class="galleryModal col-xs-12">
	<div>
		<label>{{ trans('icommerce::products.gallery.title') }} </label>
	</div>

	<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
      	{{ trans('icommerce::products.gallery.add gallery') }}
	</button>	
</div>




{{--
<div class="clearfix"></div>
<br>

<div class="gallery col-xs-12">
	 @mediaMultiple('gallery')
</div>
--}}