
  {!! Form::open(['route' => ['admin.icommerce.address.update', $address->id], 'method' => 'put']) !!}
  <div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
        @include('partials.form-tab-headers')
        <div class="tab-content">
          <?php $i = 0; ?>
          @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
            <?php $i++; ?>
            <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
              @include('icommerce::admin.addresses.partials.edit-fields', ['lang' => $locale])
            </div>
          @endforeach
          
          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.icommerce.address.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
          </div>
        </div>
      </div> {{-- end nav-tabs-custom --}}
    </div>
  </div>
  {!! Form::close() !!}

@push('js-stack')

@endpush
