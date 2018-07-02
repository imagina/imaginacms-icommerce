<div id="manufacturer"
     class="card border-0 card-items mb-3"
     v-if="products_manufacturer.length >= 1">
    <div class="card-header text-uppercase bg-primary  py-2 px-3 text-white">
        MANUFACTURER
    </div>

    <ul id="list-manufacturer" class="list-group list-group-flush">
        <li class="list-group-item border-0 pl-4">
            <i class="fa fa-angle-double-right text-primary"
               style="margin-left: -12px"></i>
            <a  v-on:click="filter_manufacturer()"
                v-bind:class="manufacturer ? '' : 'text-primary'"
                style="cursor: pointer">
                All
            </a>
        </li>
        <li class="list-group-item border-0 pl-4"
            v-bind:class="[index > 3 ? 'item-hide' : false]"
            v-bind:style="[index > 3 ? {display:'none'} : false]"
            v-for="(item,index) in products_manufacturer">
            <i class="fa fa-angle-double-right text-primary"
               style="margin-left: -12px"></i>
            <a v-on:click="filter_manufacturer(item.id)"
               v-bind:class="manufacturer === item.id ? 'text-primary' : ''"
               style="cursor: pointer">
                @{{ item.name }}
            </a>
        </li>
        <!-- boton togle -->
        <div class="text-center pt-2" v-if="products_manufacturer.length > 4">
            <i class="view-more-manufacturer text-primary
                  fa fa-angle-double-down
                  font-weight-bold"
               aria-hidden="true"
               style="cursor: pointer"
               onclick="toggle_list(this)"
               title="desplegar">
            </i>
        </div>
    </ul>
</div>

@section('scripts')
    @parent
    <script>
        function toggle_list(item) {
            $('#list-manufacturer').find('.item-hide').slideToggle();


            if ($(item).hasClass('fa-angle-double-down')){
                $(item).addClass('fa-angle-double-up');
                $(item).removeClass('fa-angle-double-down');
            }else{
                $(item).addClass('fa-angle-double-down');
                $(item).removeClass('fa-angle-double-up');
            }
        }
    </script>
@stop