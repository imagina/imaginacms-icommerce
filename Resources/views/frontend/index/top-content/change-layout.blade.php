<div class="change-layout d-flex align-items-center">
	<label>
		{{trans('icommerce::frontend.index.views')}}:
	</label>
	<div class="types-columns ml-1">
		@foreach(config("asgard.icommerce.config.layoutIndexOptions") as  $layoutOption)
			<i wire:click="changeLayout('{{$layoutOption['name']}}')" class="{{$layoutOption['icon']}} mx-1 cursor-pointer {{$mainLayout==$layoutOption['name'] ? 'text-primary' : $layoutOption['name']}}" aria-hidden="true"></i>
		@endforeach
	</div>
	
</div>