<div class="option option-{{$option->id}}">

	
	<div class="title">
		<a data-toggle="collapse" href="#collapseOption-{{$option->id}}" role="button" aria-expanded="false" aria-controls="collapseOption-{{$option->id}}">
	  		<div class="d-flex justify-content-between align-items-center">
	  			<h5 class="text-secondary">{{$option->description}}</h5>
	  			<i class="fa fa-arrow-right text-secondary" aria-hidden="true"></i>
	  		</div>
	  		<hr>
  		</a>
	</div>

	<div class="content position-relative">
		<div class="collapse" id="collapseOption-{{$option->id}}">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-option-values">

				  	@if($option->optionValues && count($option->optionValues)>0)
				  		@foreach($option->optionValues as $index => $value)

				  			@php
				  				/*
				  				$check="";
				  				if(!empty($selectedOptionValues)){
				  					if(in_array($value->id, $selectedOptionValues)){
				  						$check="checked";
				  					}
				  				}
								*/
				  			@endphp
				  			<div class="form-check">
						  		<input class="form-check-input" type="checkbox" value="{{$value->id}}" name="optionValues[]" id="optionValues-{{$value->id}}" wire:model="selectedOptionValues.{{$index}}">
							  	<label class="form-check-label" for="optionValues{{$value->id}}">
							    	{{$value->description}}
							  	</label>
							</div>

				  		@endforeach
				  	@endif

		  		</div>

		  	</div>
		  </div>
		</div>

	</div>

</div>