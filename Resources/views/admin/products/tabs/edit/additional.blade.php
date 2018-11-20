@php
	
	$metatitle = isset($product->options->meta_title) ? $product->options->meta_title : '';
	$metadescription = isset($product->options->meta_description) ? $product->options->meta_description : '';
	$metakeyword = isset($product->options->meta_keyword) ? $product->options->meta_keyword : '';

@endphp

<div class="form-group ">
	<label for="meta_title">Meta Title</label>
	<input placeholder="Meta Title" name="meta_title" type="text" value="{{$metatitle}}" id="meta_title" class="form-control">
</div>
<div class="form-group">
  <label for="meta_description">Meta Description</label>
  <textarea class="form-control" rows="5" id="meta_description" name="meta_description">{{$metadescription}}</textarea>
</div>
<div class="form-group ">
	<label for="meta_keywords">Meta Keywords</label>
	<input placeholder="Meta Keywords" name="meta_keyword" type="text" value="{{$metakeyword}}" id="meta_keyword" class="form-control">
</div>