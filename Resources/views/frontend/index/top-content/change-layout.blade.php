<div class="change-layout d-flex align-items-center">
	<label>
		{{trans('icommerce::frontend.index.views')}}:
	</label>
	<div class="types-columns ml-1">
		<i wire:click="changeLayout('four')" class="fa fa-th-large fa-2x mx-1 cursor-pointer {{$mainLayout=='four' ? 'text-primary' : 'four'}}" aria-hidden="true"></i>
		<i wire:click="changeLayout('three')" class="fa fa-square-o fa-2x mx-1 cursor-pointer {{$mainLayout=='three' ? 'text-primary' : ''}}" aria-hidden="true"></i>
		<i wire:click="changeLayout('one')" class="fa fa-align-justify fa-2x mx-1 cursor-pointer {{$mainLayout=='one' ? 'text-primary' : ''}}" aria-hidden="true"></i>
	</div>
	
</div>