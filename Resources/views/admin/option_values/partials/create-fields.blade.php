@php
	$op = array('required' => 'required');
    $opSelect = array('id' => 'selType');
    $normalSelectArray = ['text'=>'Text','background'=>'Background','image'=>'Image'];
@endphp
<div class="box-body row">


	<div class="col-xs-12">

		@include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
		{!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,null,$op) !!}
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors,null,$op) !!}
		{!! Form::normalSelect('type', trans('icommerce::options.form.type'), $errors, $normalSelectArray,null,$opSelect) !!}
    <input type="hidden" name="option_id" value="{{$option->id}}">
	</div>
</div>
<div class="box-body" id="options-text">
  {!! Form::normalInput('text',trans('icommerce::option_values.table.text'), $errors,null) !!}
</div>
		<div class="box-body" style="display: none;" id="options-color">
			{!! Form::normalInputOfType('color','background',trans('icommerce::option_values.table.hexcolor'),$errors) !!}
		</div>
		<div class="box-body text-center" style="display: none;" id="options-image">
			<div id="image">
		    <div class="bgimg-profile">
		            <img id="mainImage"
		                 class="image profile-user-img img-responsive"
		                 width="100%"
		                 src="https://ecommerce.imagina.com.co/modules/bcrud/img/default.jpg"/>
		    </div>
		    <div class="btn-group bt-upload">
		      <br>
		        <label class="btn btn-primary btn-file">
		            <i class="fa fa-picture-o"></i> {{trans('icommerce::option_values.form.select_image')}}
		            <input
		                    type="file" accept="image/*" id="mainimage"
		                    name="mainimage"
		                    value="mainimage"
		                    class="form-control" style="display:none;">
		            <input
		                    type="hidden"
		                    id="hiddenImage"
		                    name="mainimage"
		                    value=""
		                    required>
		        </label>
		    </div>
			</div>
		</div>
@push('js-stack')

    <script type="text/javascript">
        $(function(){
            $( "#selType" ).change(function() {
                var op = $(this).val();
								console.log(op);
								if(op=="image"){
									$( "#options-image" ).show();
									$( "#options-text" ).hide();
									$( "#options-color" ).hide();
								}
								else if(op=="background"){
									$( "#options-image" ).hide();
									$( "#options-text" ).hide();
									$( "#options-color" ).show();
								}else{
									$( "#options-image" ).hide();
									$( "#options-color" ).hide();
									$( "#options-text" ).show();
								}
            });
        });
    </script>

		<script src="{{ asset('modules/bcrud/vendor/cropper/dist/cropper.min.js') }}"></script>
		<script>
		$('#image').each(function (index) {
				// Find DOM elements under this form-group element
				var $mainImage = $(this).find('#mainImage');
				var $uploadImage = $(this).find("#mainimage");
				var $hiddenImage = $(this).find("#hiddenImage");
				//var $remove = $(this).find("#remove")
				// Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
				var options = {
						viewMode: 2,
						checkOrientation: false,
						autoCropArea: 1,
						responsive: true,
						preview: $(this).attr('data-preview'),
						aspectRatio: $(this).attr('data-aspectRatio')
				};


				// Hide 'Remove' button if there is no image saved
				if (!$mainImage.attr('src')) {
						//$remove.hide();
				}
				// Initialise hidden form input in case we submit with no change
				//$.val($mainImage.attr('src'));

				// Only initialize cropper plugin if crop is set to true

				$uploadImage.change(function () {
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
										$mainImage.attr('src', this.result);
										$hiddenImage.val(this.result);
										$('#hiddenImage').val(this.result);

								};
						} else {
								alert("Por favor seleccione una imagen.");
						}
				});

		});

		</script>

@endpush
