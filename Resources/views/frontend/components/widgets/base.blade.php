<div class="widget">
	
	<div class="title">
        <a data-toggle="collapse" href="#collapse{{$id}}" role="button" 
        aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapse{{$id}}" class="{{$isExpanded ? '' : 'collapsed'}}">
            <h5 class="p-3 border-top border-bottom">
                <i class="fa angle float-right" aria-hidden="true"></i>
                {{$title}}
            </h5>
		</a>
	</div>

	<div class="content position-relative my-3">
		<div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapse{{$id}}">
			{{$content}}
		</div>
	</div>


</div>