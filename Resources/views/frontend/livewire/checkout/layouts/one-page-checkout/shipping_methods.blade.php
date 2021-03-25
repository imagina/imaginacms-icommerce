<div class="card card-block p-3 shippingMethods mb-3">
  <div class="row">
    <div class="col">
      <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
          {{$step}}
        </div>
        <h3 class="d-flex align-items-center h5">
          {{ trans('icommerce::shippingmethods.title.shippingmethods') }}

        </h3>
        @if($errors->has('shippingMethod'))
          <br/>
          <span class="alert alert-danger" role="alert">{{ $errors->first('shippingMethod') }}</span>
        @endif
      </div>
      
      <table id="shippingList" class="table my-2">
        <tbody>
        @foreach($shippingMethods as $key => $shippingMethod)
        <tr class="shipping-item">
          <td >
            <div
              class="card-header collapsed bg-white border-0"
              role="tab"
              id="headingOne">
              <label class="mb-0">
                <input type="radio"
                       data-parent="#shippingList" data-toggle="collapse"
                       data-target="#shipping{{$key}}" aria-expanded="true"
                       aria-controls="shipping{{$key}}"
                       wire:model="shippingMethodSelected" value="{{$shippingMethod->id}}">
                <a class="card-title">
                  {{ ucfirst($shippingMethod->title)}}
                </a>
              </label>
            </div>
            <div id="shipping{{$key}}" class="collapse" role="tabpanel" aria-labelledby="shipping{{$key}}">
              <div class="card-block">
                {{$shippingMethod->description}}
              </div>
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
      <input type="hidden" name="shipping_method" id="shipping_method" :value="shipping_method">
      <input type="hidden" name="shipping_code" id="shipping_code" :value="shipping_method">
      <input type="hidden" name="shipping_amount" id="shipping_amount" :value="shipping_amount">
      <input type="hidden" name="shipping_value" id="shipping_value" value="">
    </div>
  </div>
</div>
