<div class="filter-order text-right">
    <div class="d-inline-block text-primary">
        <b>Sort By</b>
    </div>
    <div class="d-inline-block" style="width: 200px">
        <select class="form-control form-control-sm"
                v-model="order_check"
                v-on:change="order_by()">
            <option value="all" selected>All</option>
            {{--<option value="rating">Rating</option>--}}
            <option value="nameaz">Name (A - Z)</option>
            <option value="nameza">Name (Z - A)</option>
            <option value="lowerprice">Price: Low to Hig</option>
            <option value="higherprice">Price Hig to Low</option>
        </select>
    </div>
</div>