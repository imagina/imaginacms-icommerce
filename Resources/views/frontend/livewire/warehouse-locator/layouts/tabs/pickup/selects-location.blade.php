<div class="form-row">

    <div class="form-group col-md-6">

        <label for="inputProvince">{{ trans('iprofile::addresses.form.state') }}
            <span class="text-danger">*</span>
        </label>
        <select id="inputProvince"
                class="form-control"
                wire:model="mapPickup.province">
            <option value="">{{ trans('iprofile::addresses.form.select_province') }}</option>
           
            @if(!is_null($provinces) && count($provinces)>0)
                @foreach($provinces as $province)
                    <option value="{{$province->id}}">{{ $province->name }}</option>
                @endforeach
            @endif
        </select>

    </div>

    <div class="form-group col-md-6">

        <label for="inputCity">{{ trans('iprofile::addresses.form.city') }}
            <span class="text-danger">*</span>
        </label>
        <select id="inputCity"
                class="form-control"
                wire:model="mapPickup.city"
                @if(is_null($mapPickup['province'])) disabled @endif>
            <option value="">{{ trans('iprofile::addresses.form.select_city') }}</option>
            @if(!is_null($cities) && count($cities)>0)
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{ $city->name }}</option>
                @endforeach
            @endif
        </select>

    </div>

</div>