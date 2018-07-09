<div id="orderHistory" class="col-xs-12" >
		<div class="panel panel-default">

		  	<div class="panel-heading">{{trans('icommerce::orders.table.order history')}}</div>
		  
		 	<div class="panel-body">

		 		<ul class="nav nav-tabs">
  					<li class="active"><a data-toggle="tab" href="#history">{{trans('icommerce::orders.table.history')}}</a></li>
  					<li><a data-toggle="tab" href="#additional">{{trans('icommerce::orders.table.additional')}}</a></li>
				</ul>

				<div class="tab-content">

					<div id="history" class="tab-pane fade in active">

					    <table id="infor-history" class="table table-bordered">
				    		<th>{{trans('icommerce::orders.table.date added')}}</th>
				    		<th>{{trans('icommerce::orders.table.comment')}}</th>
				    		<th>{{trans('icommerce::orders.table.status')}}</th>
				    		<th>{{trans('icommerce::orders.table.customer notified')}}</th>
				    		
				    		

				    		@foreach ($order->order_history as $history)
				    			
				    			<tr>
					    			<td>{{-- {{icommerce_formatDate($history->created_at,"d/m/y H:m:s")}}</td> --}}
					    			{{$history->created_at}}</td>
					    			<td>{{$history->comment}}</td>
					    			<td>
					    				@foreach ($order_status->lists() as $index => $orsta)
					    					@if($index == $history->status) 
					    						{{$orsta}}
					    					@endif
							    		@endforeach
					    			</td>
					    			<td>
						    			@if ($history->notify==0)
						    				NO
						    			@else
						    				{{trans('icommerce::products.table.yes')}}
						    			@endif
					    			</td>
				    			</tr>
				    			
				    		@endforeach
				    		
				    	</table>

				    	<br>
				    	<h4>{{trans('icommerce::orders.table.add order history')}}</h4>
				    	<hr>

				    	<div class="form-group row">

						    <label for="status" class="col-sm-2 text-right">{{trans('icommerce::orders.table.status')}}</label>
						    <div class="col-sm-10">
						    	<select class="form-control" id="newstatus" name="newstatus">
							    	@foreach ($order_status->lists() as $index => $ts)
							    		<option value="{{$index}}" @if($index==$order->status) selected @endif >{{$ts}}</option>
							    	@endforeach
							    </select>
						    </div>

						</div>

						<div class="form-group row">

						    <label for="notified" class="col-sm-2 text-right">{{trans('icommerce::orders.table.customer notify')}}</label>
						    <div class="col-sm-10">
						    	 <select class="form-control" id="notified" name="notified">
						    		<option value="0" selected>NO</option>
						    		<option value="1">{{trans('icommerce::orders.table.yes')}}</option>
						    	</select>
						    </div>

						</div>

						<div class="form-group row">

						    <label for="comment" class="col-sm-2 text-right">{{trans('icommerce::orders.table.comment')}}</label>
						    <div class="col-sm-10">
						    	 <textarea class="form-control" rows="5" id="comment"></textarea>
						    </div>

						</div>

						<div class="row">
							<div class="col-xs-12">
								<button id="addhistory" type="button" class="btn btn-primary pull-right" data-loading-text="Loading...">{{trans('icommerce::orders.button.add history')}}</button>
							</div>
						</div>

					 </div>

					 
				  	<div id="additional" class="tab-pane fade">

				    	<table id="infor-additional" class="table table-bordered">
				    		<th colspan="2">Browser</th>
				    		<tr>
				    			<td style="width:15%;">IP Address</td>
				    			<td>{{$order->ip}}</td>
				    		</tr>
				    		<tr>
				    			<td style="width:15%;">User Agent</td>
				    			<td>{{$order->user_agent}}</td>
				    		</tr>
				    	</table>

				  	</div>

				</div>
    			
  			</div>

		</div>
</div>

@push('js-stack')

<script type="text/javascript">

$(function(){ 

	$('#addhistory').on('click', function() {

			var token = $('meta[name="token"]').attr('value');
			var url = '{{route('admin.icommerce.order_history.addHistory')}}';
  			var orderID = {{$order->id}};
  			var newStatus = $("#newstatus").val();// Select
  			var notify = $("#notified").val();// Select
  			var comment = $("#comment").val();

  			var newStatusText = $("#newstatus option:selected").text();
  			var notifyText = $("#notified option:selected").text();

            $.ajax({
                type: "POST",
                url: url,
                dataType: "JSON",
                data:{orderID:orderID,newStatus:newStatus,notify:notify,comment:comment,newStatusText:newStatusText},
                headers: {'X-CSRF-TOKEN': token},
                
                beforeSend: function(){ 
                    $("#addhistory").button('loading');
                },
              
                success: function(data) {
                	
                    if(data['status'] == 'success'){
                        console.log('success');

                        var date = " --- ";
                        var newRow = $("<tr>");
        				var cols = "";

        				cols += '<td>'+data['date']+'</td>';
        				cols += '<td>'+comment+'</td>';
        				cols += '<td>'+newStatusText+'</td>';
        				cols += '<td>'+notifyText+'</td> ';

        				newRow.append(cols);
        				$("#infor-history").append(newRow);

                    }

                    $("#addhistory").button('reset');
                    
                },
                error: function(data)
                {	
                	$("#addhistory").button('reset');
                    console.log('Error:', data);
                    alert("{{trans('icommerce::order_history.messages.error add history')}}")
                   
                }
            })

	});

});

</script>

@endpush