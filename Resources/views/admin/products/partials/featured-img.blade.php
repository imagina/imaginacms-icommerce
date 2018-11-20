<div class="featured-img">

	<div data-preview="#{{$name}}" data-aspectRatio="0" data-crop="{{$crop}}" class="form-group image col-md-12">
		<div>
			<label>{{trans('icommerce::products.table.featured image')}}</label>	
		</div>

     	<div class="row">
	        <div class="col-sm-6" style="margin-bottom: 20px;">

	        	@if(isset($action) && ($action=="update") && isset($product->options->mainimage))
	        		<img id="mainImage" src="{{url($product->options->mainimage)}}">
	        	@else
                    <img id="mainImage" src="{{url("modules/bcrud/img/default.jpg")}}">
	        	@endif
	        </div>

        	@if($crop)
	        <div class="col-sm-3">
	            <div class="docs-preview clearfix">
	                <div id="{{$name}}" class="img-preview preview-lg">
	                    <img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
	                </div>
	            </div>
	        </div>
	        @endif

    	</div>

    	<div class="btn-group">
	        <label class="btn btn-primary btn-file">
	            {{ trans('bcrud::crud.choose_file') }} <input type="file" accept="image/*" id="uploadImage">
	            <input type="hidden" id="hiddenImage" name="mainimage">
	        </label>
	        @if($crop)
	        	<button class="btn btn-default" id="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>
	        	<button class="btn btn-default" id="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>
	        	<button class="btn btn-default" id="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>
	        	<button class="btn btn-default" id="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>
	        	<button class="btn btn-warning" id="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>
	        @endif
	        <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
    	</div>


    </div>
	
</div>
 
 @section("scripts")
    @parent
<link href="{{ asset('modules/bcrud/vendor/cropper/dist/cropper.min.css') }}" rel="stylesheet" type="text/css" />
<style>
            .hide {
                display: none;
            }
            .image .btn-group {
                margin-top: 10px;
            }
            img {
                max-width: 100%; /* This rule is very important, please do not ignore this! */
            }
            .img-container, .img-preview {
                width: 100%;
                text-align: center;
            }
            .img-preview {
                float: left;
                margin-right: 10px;
                margin-bottom: 10px;
                overflow: hidden;
            }
            .preview-lg {
                width: 263px;
                height: 148px;
            }

            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
</style>
@stop
 
@push('js-stack')
   
    <script src="{{ asset('modules/bcrud/vendor/cropper/dist/cropper.min.js') }}"></script>
    
    <script>
            jQuery(document).ready(function($) {
                // Loop through all instances of the image field
                $('.form-group.image').each(function(index){
                    // Find DOM elements under this form-group element
                    var $mainImage = $(this).find('#mainImage');
                    var $uploadImage = $(this).find("#uploadImage");
                    var $hiddenImage = $(this).find("#hiddenImage");
                    var $rotateLeft = $(this).find("#rotateLeft")
                    var $rotateRight = $(this).find("#rotateRight")
                    var $zoomIn = $(this).find("#zoomIn")
                    var $zoomOut = $(this).find("#zoomOut")
                    var $reset = $(this).find("#reset")
                    var $remove = $(this).find("#remove")
                    // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                    var options = {
                        viewMode: 2,
                        checkOrientation: false,
                        autoCropArea: 1,
                        responsive: true,
                        preview : $(this).attr('data-preview'),
                        aspectRatio : $(this).attr('data-aspectRatio')
                    };
                    var crop = $(this).attr('data-crop');

                    // Hide 'Remove' button if there is no image saved
                    if (!$mainImage.attr('src')){
                        $remove.hide();
                    }
                    // Initialise hidden form input in case we submit with no change
                    $urlimg=$mainImage.attr('src').split('?');
                    $hiddenImage.val($urlimg[0]);


                    // Only initialize cropper plugin if crop is set to true
                    if(crop){

                        $remove.click(function() {
                            $mainImage.cropper("destroy");
                            $mainImage.attr('src','');
                            $hiddenImage.val('');
                            $rotateLeft.hide();
                            $rotateRight.hide();
                            $zoomIn.hide();
                            $zoomOut.hide();
                            $reset.hide();
                            $remove.hide();
                        });
                    } else {

                        $(this).find("#remove").click(function() {
                            $mainImage.attr('src','');
                            $hiddenImage.val('');
                            $remove.hide();
                        });
                    }

                    $uploadImage.change(function() {
                        var fileReader = new FileReader(),
                                files = this.files,
                                file;

                        if (!files.length) {
                            return;
                        }
                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {
                            fileReader.readAsDataURL(file);
                            fileReader.onload = function () {
                                $uploadImage.val("");
                                if(crop){
                                    $mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
                                    // Override form submit to copy canvas to hidden input before submitting
                                    $('form').submit(function() {
                                        var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL(file.type);
                                        $hiddenImage.val(imageURL);
                                        return true; // return false to cancel form action
                                    });
                                    $rotateLeft.click(function() {
                                        $mainImage.cropper("rotate", 90);
                                    });
                                    $rotateRight.click(function() {
                                        $mainImage.cropper("rotate", -90);
                                    });
                                    $zoomIn.click(function() {
                                        $mainImage.cropper("zoom", 0.1);
                                    });
                                    $zoomOut.click(function() {
                                        $mainImage.cropper("zoom", -0.1);
                                    });
                                    $reset.click(function() {
                                        $mainImage.cropper("reset");
                                    });
                                    $rotateLeft.show();
                                    $rotateRight.show();
                                    $zoomIn.show();
                                    $zoomOut.show();
                                    $reset.show();
                                    $remove.show();

                                } else {
                                    $mainImage.attr('src',this.result);
                                    $hiddenImage.val(this.result);
                                    $remove.show();
                                }
                            };
                        } else {
                            alert("Please choose an image file.");
                        }
                    });

                });
            });
    </script>

@endpush