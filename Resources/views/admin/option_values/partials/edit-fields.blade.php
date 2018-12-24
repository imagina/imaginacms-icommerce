@php
$op = array('required' => 'required');
$opSelect = array('id' => 'selType');
$normalSelectArray = ['text'=>'Text','background'=>'Background','image'=>'Image'];
@endphp
<div class="box-body row">
  <div class="col-xs-12">

    @include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
    {!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,$option_value,$op) !!}
    {!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors,$option_value,$op) !!}
    {!! Form::normalSelect('type', trans('icommerce::options.form.type'), $errors, $normalSelectArray,$option_value,$opSelect) !!}
    <input type="hidden" name="option_id" value="{{$option_value->option_id}}">
  </div>
</div>
<div class="box-body" id="options-text" style="display:none">
  {!! Form::normalInput('text',trans('icommerce::option_values.table.text'), $errors,$option_value->options) !!}
</div>
<div class="box-body" style="display: none;" id="options-color">
  {!! Form::normalInputOfType('color','background',trans('icommerce::option_values.table.hexcolor'),$errors,$option_value->options) !!}
</div>
<div class="box-body text-center" style="display: none;" id="options-image">
  <div id="image">
    <div class="bgimg-profile">

      @if(isset($option_value->options->image)&&!empty($option_value->options->image))
      <!-- <img id="mainImage" class="img-fluid" src="{{ url($option_value->options->image) }}"> -->
      <img id="mainImage"
      class="image profile-user-img  img-responsive"
      width="100%"
      src="{{url($option_value->options->image)}}?v={{str_random(4)}}"/>
      @else
      <img id="mainImage"
      class="image profile-user-img img-responsive"
      width="100%"
      src="https://ecommerce.imagina.com.co/modules/bcrud/img/default.jpg"/>
      @endif
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
        value="{{$option_value->options->image??''}}"
        required>
      </label>
    </div>
  </div>
</div>
</div>
@push('js-stack')

<script type="text/javascript">
$(function(){
  if("{{$option_value->type}}"=="image"){
    $( "#options-image" ).show();
    $( "#options-color" ).hide();
  }else if("{{$option_value->type}}"=="background"){
    $( "#options-image" ).hide();
    $( "#options-color" ).show();
  }else if("{{$option_value->type}}"=="text" || "{{$option_value->type}}"==null || "{{$option_value->type}}"==""){
    $( "#options-image" ).hide();
    $( "#options-text" ).show();
    $( "#options-color" ).hide();
  }
  $( "#selType" ).change(function() {
    var op = $(this).val();
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
      $( "#options-text" ).show();
      $( "#options-image" ).hide();
      $( "#options-color" ).hide();
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function () {

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
});
</script>

<script src="{{ asset('modules/bcrud/vendor/cropper/dist/cropper.min.js') }}"></script>
<script>

function image_caller() {
  console.log('Image caller function');
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
            console.log(this.result);
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

@endpush
