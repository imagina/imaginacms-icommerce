<!-- PAGINADOR -->
<div class="col-12 text-right">
    <nav aria-label="Page navigation example"
         v-if="pages > 1"
         class="float-right">
        <ul class="pagination" v-if="pages >= 2">
            <!-- btn go to the first page -->
            <li class="page-item">
                <a class="page-link"
                   v-on:click="change_page_limit(1,'first')"
                   title="first page">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <!-- btn back -->
            <li class="page-item" v-if="p_currence != 1">
                <a class="page-link"
                   v-on:click="change_page(false,'previous')"
                   title="back page">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>

            <!-- number pages  -->
            <li v-bind:class="[(num) == p_currence ? 'active' : false]"
                class="page-item"
                v-if="(num <= pages) && (num >= r_pages.first) && (num <= r_pages.latest)"
                v-for="num in r_pages.latest">
                <a  class="page-link"
                    v-on:click="[(num) == p_currence ? false : change_page(num)]">
                    @{{ num  }}
                </a>
            </li>

            <!-- btn next -->
            <li class="page-item" v-if="p_currence < pages">
                <a class="page-link"
                   v-on:click="change_page(false,'next')"
                   title="next page">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>

            <!-- btn go to the lastest page -->
            <li class="page-item">
                <a class="page-link"
                   v-on:click="change_page_limit(pages,'last')"
                   title="last page">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>