<div class="box-body">
  <label>Tax name: </label>
  <input type="text" class="form-control" required name="name" id="name" value="{{$taxrates->name}}">
  <label>Tax rate: </label>
  <input type="number" class="form-control" required name="rate" id="rate" value="{{$taxrates->rate}}">
  <label>Type: </label>
  <select class="form-control" name="type">
    <option value="P" @if($taxrates->type=="P") selected @endif>Percentage</option>
    <option value="F" @if($taxrates->type=="F") selected @endif>Fixed Amount</option>
  </select>
  <label>Customer Group</label>
  <input type="checkbox" name="customer" value="1" @if($taxrates->customer) checked="checked" @endif>
  <br>
  <label>Geo Zone</label>
  <select class="form-control" name="geozone_id">
    @foreach($geozones as $key)
    <option value="{{$key->id}}" @if($key->id==$taxrates->geozone_id) selected @endif>{{$key->name}}</option>
    @endforeach
  </select>
  <br>
</div>
