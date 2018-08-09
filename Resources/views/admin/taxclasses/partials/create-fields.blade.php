<div class="box-body">
  <label>Tax Class title: </label>
  <input type="text" class="form-control" required name="name" id="name" value="{{old('name')}}">
  <label>Description: </label>
  <input type="text" class="form-control" required name="description" id="description" value="{{old('description')}}">
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
    <tbody></tbody>
  </table>
</div>
