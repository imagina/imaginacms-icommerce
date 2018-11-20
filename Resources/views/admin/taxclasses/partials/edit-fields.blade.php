<script type="text/javascript">
var countTr=0;
var taxRates=[];
var dataEdit="";
var taxRate="";
var based="";
var priority="";
</script>
<div class="box-body">
  <label>Tax Class title: </label>
  <input type="text" class="form-control" required name="name" id="name" value="{{$taxclass->name}}">
  <label>Description: </label>
  <input type="text" class="form-control" required name="description" id="description" value="{{$taxclass->description}}">
  <br>
  <h2>Tax rates</h2>
  <hr>
  <div class="row">
    <div class="col-md-3">
      <label for="taxRates">Tax rate</label>
      <select class="form-control" name="taxRate" id="taxRate">
        @foreach($taxrates as $key)
        <option value="{{$key->id}}">{{$key->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label for="based">Based on</label>
      <select class="form-control" name="based" id="based" >
        <option value="shipping">Shipping Address</option>
        <option value="payment">Payment Address</option>
        <option value="store">Store Address</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="based">Priority</label>
      <input type="number" name="priority" class="form-control" placeholder="Priority" id="priority">
    </div>
    <div class="col-md-3">
      <br>
      <button type="button" class="btn btn-primary add_taxRate" name="button"><i class="fa fa-plus-circle"></i></button>
    </div>
  </div>
  <br>
  <table class="table table-bordered" id="table_taxclasses">
    <thead>
      <th>Tax rate</th>
      <th>Based on</th>
      <th>Priority</th>
      <th></th>
    </thead>
    <tbody>
      @foreach($taxClassRates as $key)
      <tr id="tr{{$loop->index}}">
        <td>
          @foreach($taxrates as $key2)
            @if($key2->id==$key->taxrate_id)
              <input type="text" class="form-control" value="{{$key2->name}}" readonly>
              @break
            @endif
          @endforeach
        </td>
        <td><input type="text" class="form-control" value="@if($key->based=='shipping') Shipping Address @elseif($key->based=='payment') Payment Address @elseif($key->based=='store') Store Address @endif" readonly></td>
        <td><input type="text" class="form-control" value="{{$key->priority}}" readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow({{$loop->index}})" name="button"><i class="fa fa-minus-circle"></i></button></td>
      </tr>
      <script type="text/javascript">
      var taxRate={{$key->taxrate_id}};
      var based="{{$key->based}}";
      var priority={{$key->priority}};
      dataEdit = {taxRate,based,priority,countTr}
      countTr++;
      taxRates.push(dataEdit);
      </script>
      @endforeach
    </tbody>
  </table>
</div>
