<div class="filters-range-price pb-4">

    <div class="filter-order">

        <a class="item mb-3" data-toggle="collapse" href="#rangeP" role="button" aria-expanded="true"
           aria-controls="rangeP">
            <h5 class="p-3 d-block font-weight-bold cursor-pointer mb-0 border-top border-bottom">
                <i class="fa angle float-right" aria-hidden="true"></i>
                {{trans('icommerce::common.range.title')}}
            </h5>
        </a>

        <div class="collapse multi-collapse show mb-2" id="rangeP">
            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item border-0 py-0">
                    <div class="custom-control custom-radio" @click="filter_price(0,100000)">
                        <input   type="radio" name="rangeP" class="custom-control-input" id="checkRange1">
                        <label class="custom-control-label" for="checkRange1">$0.00 - $100.000</label>
                    </div>
                </li>
                <li class="list-group-item border-0 py-0">
                    <div class="custom-control custom-radio" @click="filter_price(100000,200000)">
                        <input   type="radio" name="rangeP"  class="custom-control-input"  id="checkRange2">
                        <label class="custom-control-label" for="checkRange2">$100.000 - $200.000</label>
                    </div>
                </li>
                <li class="list-group-item border-0 py-0">
                    <div class="custom-control custom-radio" @click="filter_price(200000,300000)">
                        <input   type="radio" name="rangeP"  class="custom-control-input"  id="checkRange3">
                        <label class="custom-control-label" for="checkRange3">$200.000 - $300.000</label>
                    </div>
                </li>
            </ul>
        </div>
        
    </div>

</div>
