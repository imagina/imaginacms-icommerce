@php
	$op = array('required' => 'required');
    $opSelect = array('id' => 'selType');
    $normalSelectArray = ['text'=>'Text','textarea'=>'Textarea','select'=>'Select','radio'=>'Radio','checkbox'=>'Checkbox'];
@endphp

<div class="box-body row">
	@if ($entity->translationEnabled())
		<input type="hidden" name="locale" value={{App::getLocale()}}>
	@endif

	<div class="col-xs-12">

		@include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
		{!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,null,$op) !!}
		{!! Form::normalSelect('type', trans('icommerce::options.form.type'), $errors, $normalSelectArray,null,$opSelect) !!}
		<div class="form-group dropdrown">
			<label for="parentOption">{{trans('icommerce::options.form.parent_option')}}</label>
			<select class="form-control" name="parent_id" id="parent_option">
				<option value="0">{{trans('icommerce::options.form.select parent option')}}</option>
				@foreach($parentOptions as $option)
				<option value="{{$option->id}}">{{$option->description}}</option>
				@endforeach
			</select>
		</div>
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors) !!}
	</div>
</div>

<!-- /.box-header -->
<div id="options-multiple" class="box-body" style="display: none;">

	<div class="box-header with-border">{{ trans('icommerce::option_values.title.option_values') }}</div>

    <div class="table">
        <table class="data-table table table-bordered table-hover">
            <thead>
                <tr>
                    <th>{{ trans('icommerce::option_values.form.name') }}</th>
                    <th>{{ trans('icommerce::option_values.form.image') }}</th>
                    <th>{{ trans('icommerce::option_values.form.sort_order') }}</th>
                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                </tr>
            </thead>
            <tbody class="items">

            </tbody>
            <tfoot>
			    <tr>
					<td colspan="3"></td>
					<td>
						<button class="btn btn-success btn-flat add_field_button"><i class="fa fa-pencil"></i></button>
					</td>
                </tr>
            </tfoot>
        </table>
        <!-- /.box-body -->
    </div>

</div>
<!-- /.box -->

@section('scripts')
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

    <script type="text/javascript">
        $(function(){
            $( "#selType" ).change(function() {
                var op = $(this).val();
                if(op!="text" && op!="textarea"){
                   $( "#options-multiple" ).show();
                }else{
                    $( "#options-multiple" ).hide();
                }
            });
        });
    </script>

     {{-- YOUR JS HERE --}}
    <script src="{{ asset('modules/bcrud/vendor/cropper/dist/cropper.min.js') }}"></script>
    <script>

        function image_caller() {

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
        };
    </script>

    <script>
        $(document).ready(function () {

            var max_fields = 100;
            var wrapper = $(".items");
            var add_button = $(".add_field_button");
            var fieldHTML =
                '<tr>'
                +
                    '<td>'
                +
                        '<div class="form-group">'
                +
                            '<input type="text" class="form-control" value="" name="description_value[]" id="description" placeholder="Option Value Name" required>'
                +
                        '</div>'
                +
                    '</td>'
                +
                    '<td>'
                +
                        '<div data-preview="#mainimage" data-aspectRatio="0" data-crop="0" class="form-group col-md-12 image">'
                +
                            '<div>'
                +
                                '<label>Imágen</label>'
                +
                            '</div>'
                +
                            '<div class="row">'
                +
                                '<div class="col-sm-6" style="margin-bottom: 20px;">'
                +
                                    '<img id="mainImage" src="https://ecommerce.imagina.com.co/modules/bcrud/img/default.jpg">'
                +
                                '</div>'
                +
                                '<div class="col-sm-3">'
                +
                                    '<div class="docs-preview clearfix">'
                +
                                        '<div id="mainimage" class="img-preview preview-lg">'
                +
                                            '<img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -62.875px; margin-top: -18.4922px; transform: none;">'
                +
                                        '</div>'
                +
                                    '</div>'
                +
                                '</div>'
                +
                            '</div>'
                +
                            '<div class="btn-group">'
                +
                                '<label class="btn btn-primary btn-file" onclick="image_caller()">'
                +
                                    'choose_file'
                +
                                    '<input type="file" accept="image/*" id="uploadImage" class="hide">'
                +
                                    '<input type="hidden" id="hiddenImage" name="mainimage[]" value="https://ecommerce.imagina.com.co/modules/bcrud/img/default.jpg">'
                +
                                '</label>'
                +
                                '<button class="btn btn-default" id="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>'
                +
                                '<button class="btn btn-default" id="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>'
                +
                                '<button class="btn btn-default" id="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>'
                +
                                '<button class="btn btn-default" id="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>'
                +
                                '<button class="btn btn-warning" id="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>'
                +
                                '<button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>'
                +
                            '</div>'
                +
                        '</div>'
                +
                    '</td>'
                +
                    '<td>'
                +
                        '<input type="number" class="form-control" value="" name="sort_order_value[]" id="sort_order" placeholder="Sort Order">'
                +
                    '</td>'
                +
                    '<td>'
                +
                        '<button class="btn btn-danger btn-flat remove_field"><i class="fa fa-trash"></i></button>'
                +
                    '</td>'
                +
                '</tr>'
                ;

            var x = 1;

            $(add_button).unbind( "click" );

            $(add_button).click(function(e){
                e.preventDefault();
                if(x < max_fields){
                    x++;
                    $(wrapper).append(fieldHTML);
                }
            });

            $(wrapper).on("click",".remove_field", function(e){
                e.preventDefault();
                $(this).parents('tr').remove();
                x--;
            })
        });
    </script>

@endpush
