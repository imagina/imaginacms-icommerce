<div class="option option-{{$option->id}} mb-4">
	@php($isExpanded = count(array_intersect($option->values ? $option->values->pluck("id")->toArray() : [],$this->selectedOptionValues)))


	<div class="title">
		<a data-toggle="collapse" href="#collapseOption-{{$option->id}}" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}"
		   aria-controls="collapseOption-{{$option->id}}" class="{{$isExpanded ? '' : 'collapsed'}}">
	  		
	  		<h5 class="p-3 border-top border-bottom">
	  			<i class="fa fa angle float-right" aria-hidden="true"></i>
	  			{{$option->description}}
	  		</h5>
	  		
  		</a>
	</div>

	<div class="content position-relative">
		<div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapseOption-{{$option->id}}">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-option-values">

				  	<ul>

				  		@foreach($option->values ?? [] as $value)

				  			<div class="form-check">
						  		<input class="form-check-input" type="checkbox" value="{{$value->id}}" name="optionValues{{$value->id}}" id="optionValues-{{$value->id}}" wire:model="selectedOptionValues" >
							  	<label class="form-check-label" for="optionValues{{$value->id}}">
							    	{{$value->description}}
							  	</label>
							</div>

				  		@endforeach
				  	</ul>

		  		</div>

		  	</div>
		  </div>
		</div>

	</div>

	

</div>