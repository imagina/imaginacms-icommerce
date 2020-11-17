<nav aria-label="Page navigation example"  class="float-right">
    <ul class="pagination mb-0">
        <!-- btn go to the first page -->
        <li class="page-item" v-if="p_currence!=1">
            <a class="page-link" @click="changePage('first')" title="first page">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">{{trans('icommerce::common.pagination.previous')}}</span>
            </a>
        </li>

        <!-- btn back -->
        <li class="page-item" v-if="p_currence != 1">
            <a class="page-link" @click="changePage('back')"
               title="back page">
                <i class="fa fa-angle-left"></i>
            </a>
        </li>

        <!-- number pages  -->
        <li v-bind:class="[(num) == p_currence ? 'active' : false]" class="page-item"
            v-if="(num <= pages) && (num >= r_pages.first) && (num <= r_pages.latest)"
            v-for="num in r_pages.latest">
            <a class="page-link"
               v-on:click="[(num) == p_currence ? false : changePage('page',num)]">
                @{{ num }}
            </a>
        </li>

        <!-- btn next -->
        <li class="page-item" v-if="p_currence < pages">
            <a class="page-link" v-on:click="changePage('next')" title="next page">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>

        <!-- btn go to the lastest page -->
        <li class="page-item" v-if="p_currence!=r_pages.latest">
            <a class="page-link" v-on:click="changePage('last')" title="last page">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">{{trans('icommerce::common.pagination.next')}}</span>
            </a>
        </li>
    </ul>
</nav>
<!-- PAGINATE -->
