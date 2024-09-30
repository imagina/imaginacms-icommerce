@auth
<div class='card mb-0 border-0'>
  <div class='d-block'>
    
    @php
      $mainImage=\Modules\Iprofile\Entities\Field::where('user_id',Auth::user()->id)->where('name','mainImage')->first()
    
    @endphp
    <div id="imgProfile" class="mb-5 text-center">
      @if($mainImage)
        <img id="mainImage" class="img-fluid rounded-circle bg-white" src="{{ url($mainImage->value) }}" alt="Logo">
      @else
        <img id="mainImage" class="img-fluid rounded-circle bg-white" src="{{url('modules/iprofile/img/default.jpg')}}" alt="Logo">
      
      @endif
    </div>
  
  </div>
  <div class='d-block'>
    {{ trans('icommerce::customer.logged.name') }}<strong> {{$user != null ? $user->present()->fullname : ''}}</strong>
  </div>
  <div class='d-block'>
    {{ trans('icommerce::customer.logged.email') }} <strong>{{$user != null ? $user->email: ''}}</strong>
  </div>

</div>
@endauth