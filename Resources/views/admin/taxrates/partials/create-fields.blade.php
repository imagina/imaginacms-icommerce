<div class="box-body">
  <label>Tax name: </label>
  <input type="text" class="form-control" required name="name" id="name" value="{{old('name')}}">
  <label>Tax rate: </label>
  <input type="number" class="form-control" required name="rate" id="rate" value="{{old('rate')}}">
  <label>Type: </label>
  <select class="form-control" name="type">
    <option value="P">Percentage</option>
    <option value="F">Fixed Amount</option>
  </select>
  <label>Customer Group</label>
  <input type="checkbox" name="customer" value="1">
  <br>
  <label>Geo Zone</label>
  <select class="form-control" name="geozone_id">
    @foreach($geozones as $key)
    <option value="{{$key->id}}">{{$key->name}}</option>
    @endforeach
  </select>
  <br>
</div>
