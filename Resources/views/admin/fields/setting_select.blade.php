@php
    if(isset($dbSettings[$settingName]) && $dbSettings[$settingName]->plainValue){
        $countryIso = $dbSettings[$settingName]->plainValue;
    }else{
        $countryIso = "";
    }  
@endphp

<label>{!! trans($moduleInfo['description']) !!}</label>

<div class="select">
    <div class="form-group">
      <select class="form-control" id="{{$moduleInfo['name']}}" name="{{$settingName}}">
        <option value="0">{!! trans("icommerce::common.select") !!}</option>
      </select>
    </div>
</div>

@push('js-stack')

<script type="text/javascript">
    
$(function(){ 
    
    url = "https://ecommerce.imagina.com.co/api/ilocations/allmincountries";

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        headers: {'X-CSRF-TOKEN': token},
        success: function(data) {
            //console.log(data);
            var sel = $("#{{$moduleInfo['name']}}");
            var cIso = "{{$countryIso}}";
            //sel.empty();
            for (var i=0; i<data.length; i++) {

                if(data[i].iso_2==cIso)
                    var yeh = "selected";
                else
                    var yeh = "";

                sel.append('<option value="' + data[i].iso_2 + '"'+yeh+'>' + data[i].name +'</option>');
                
            }
        }
    })            
    .error( function(data) {
        console.log(data);
    });


});

</script>


@endpush