@extends('layouts.master')

@section('content-header')
<h1>
  {{ trans('icommerce::taxclasses.title.create taxclass') }}
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
  <li><a href="{{ route('admin.icommerce.taxclass.index') }}">{{ trans('icommerce::taxclasses.title.taxclasses') }}</a></li>
  <li class="active">{{ trans('icommerce::taxclasses.title.create taxclass') }}</li>
</ol>
@stop

@section('content')
<!-- {!! Form::open(['route' => ['admin.icommerce.taxclass.store'], 'method' => 'post']) !!} -->
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <div class="tab-content">
        @include('icommerce::admin.taxclasses.partials.create-fields')
        <div class="box-footer">
          <button type="button" onclick="storeTaxClass()" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
          <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.icommerce.taxclass.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
      </div>
    </div> {{-- end nav-tabs-custom --}}
  </div>
</div>
<!-- {!! Form::close() !!} -->
@stop

@section('footer')
<a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
<dl class="dl-horizontal">
  <dt><code>b</code></dt>
  <dd>{{ trans('core::core.back to index') }}</dd>
</dl>
@stop

@push('js-stack')
<script type="text/javascript">
var countTr=0;
var taxRates=[];
function removeRow(num){
  $('#tr'+num).remove();
  for(var i=0;i<taxRates.length;i++){
    if(taxRates[i]['countTr']==num){
      taxRates.splice(i,1);
      break;
    }//if
  }//for
}//removeRow
$('.add_taxRate').on("click", function() {
  var taxRate=$('#taxRate').val();
  var based=$('#based').val();
  var priority=$('#priority').val();
  if(priority=="")
    alertify.error("You must enter the priority");
  else{
    var taxRateText=$('#taxRate option:selected').text();
    var basedText=$('#based option:selected').text();
    var data = {taxRate,based,priority,countTr}
    taxRates.push(data);
    var cols = "<tr id='tr"+countTr+"'>";
    cols += '<td><input type="text" class="form-control" value="'+taxRateText+'" readonly></td>';
    cols += '<td><input type="text" class="form-control" value="'+basedText+'" readonly></td>';
    cols += '<td><input type="text" class="form-control" value="'+priority+'" readonly></td>';
    cols += '<td><button type="button" class="btn btn-danger" onclick="removeRow('+countTr+')" name="button"><i class="fa fa-minus-circle"></i></button></td>';
    cols += "</tr>";
    countTr++;
    $("#table_taxclasses tbody").append(cols);
    // console.log(taxRates);
  }
});//addRow
function storeTaxClass(){
  var name=$('#name').val();
  var description=$('#description').val();
  if(name==""){
    alertify.error('You must enter a name');
  }else if(description==""){
    alertify.error('You must enter a description');
  }else if(taxRates.length==0){
    alertify.error('You need to build at least one tax rate');
  }else{
    var token="{{csrf_token()}}";
    $.ajax({
      url:"{{url('/backend/icommerce/taxclasses')}}",
      type:'POST',
      headers:{'X-CSRF-TOKEN': token},
      dataType:"json",
      data:{name:name,description:description,taxrates:taxRates},
      success:function(data){
        if(data.success==1){
          $('#name').val("");
          $('#description').val("");
          taxRates=[];
          $("#table_taxclasses tbody").empty();
          alertify
          .alert(""+data.message, function(){
            window.location.replace("{{url('/backend/icommerce/taxclasses')}}");
            // alertify.message('OK');
          });
          // alert('Geozone successfully saved');
        }
      },
      statusCode: {
        422: function(dataError){
          // console.log(dataError);
          var error=JSON.parse(dataError.responseText);
          // console.log(error);//parse string to json responseText
          $.each( error.errors, function( key, value ) {
            // alert( key + ": " + value );
            // alert(value);
            alertify.error(""+value);
          });
        }
      },
      error:function(jqXHR, textStatus, errorThrown){
        // alert(jqXHR.status);
        // alert(textStatus);
        // alert(errorThrown);
      }
    });
  }
}//storeTaxClass()
</script>
<script type="text/javascript">
$( document ).ready(function() {
  $(document).keypressAction({
    actions: [
      { key: 'b', route: "<?= route('admin.icommerce.taxclass.index') ?>" }
    ]
  });
});
</script>
<script>
$( document ).ready(function() {
  $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
  });
});
</script>
@endpush
