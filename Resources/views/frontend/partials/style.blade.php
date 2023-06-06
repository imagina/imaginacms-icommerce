<!-- Filter styles -->
<style>

    .filter-categories .list-group-item .icon-collapsable .angle:before {
        content: "\f105";
    }
    .filter-categories .list-group-item .icon-collapsable[aria-expanded="true"] .angle:before {
        content: "\f107";
    }
    .filter-categories .list-group-item .category-icon {
        display: inline-block;
    }
    .filter-categories .list-group-item .link-desktop {
        position: relative;
        height: 30px;
    }
    .filter-categories .list-group-item .link-desktop .text-href {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }
    .filter-categories .list-group-item .link-desktop .icon-collapsable {
        display: flex;
        justify-content: flex-end;
        height: 100%;
        align-items: center;
    }
    .filter-categories .list-group-item .link-movil {
        position: relative;
    }
    .filter-categories .list-group-item .link-movil .text-collapsable {
        display: block;
    }
    .filter-categories .list-group-item .link-movil .icon-href {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }
    .filter-categories-style-1 .item, .filter-categories-style-1 .category-icon {
        display: none;
    }
    .filter-categories-style-1 .list-group-item {
        padding: 0 !important;
    }
    .filter-categories-style-1 .list-group-item a {
        color: #333333;
    }
    .filter-categories-style-1 .list-group-item a:hover {
        color: var(--primary) !important;
        font-weight: bold !important;
    }
    .filter-categories-style-1 .list-group-item.level-0 {
        padding: 0;
        border: 0;
    }
    .filter-categories-style-1 .list-group-item.level-0 > .link-desktop {
        padding-left: 38px;
    }
    .filter-categories-style-1 .list-group-item.level-0 > .link-desktop .icon-collapsable {
        justify-content: flex-start;
        font-weight: bold;
        font-size: 20px;
    }
    .filter-categories-style-1 .list-group-item.level-0 > .link-desktop .text-href {
        left: 35px !important;
    }
    .filter-categories-style-1 .list-group-item.level-0 .link-movil .icon-href {
        right: 10px;
    }
    .filter-categories-style-1 .list-group-item.level-0 .link-desktop, .filter-categories-style-1 .list-group-item.level-0 .link-movil {
        font-size: 1rem;
        background-color: #f0f0f0;
        font-weight: 400;
        border-radius: 0 20px 0 0;
        margin-bottom: 1rem;
        padding: 1rem;
        border: 0;
        height: 56px;
    }
    .filter-categories-style-1 .list-group-item.level-0 .link-desktop .text-href, .filter-categories-style-1 .list-group-item.level-0 .link-movil .text-href {
        left: 15px;
    }
    .filter-categories-style-1 .list-group-item.level-0 .link-childless {
        font-size: 1rem;
        background-color: #f0f0f0;
        font-weight: 400;
        border-radius: 0 20px 0 0;
        margin-bottom: 1rem;
        padding: 1rem;
        border: 0;
        height: 56px;
    }
    .filter-categories-style-1 .list-group-item.level-0 .multi-collapse {
        margin-bottom: 0.5rem;
    }
    .filter-categories-style-1 .list-group-item.level-1 {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-movil .text-collapsable {
        padding: 0.7rem 1rem;
        height: 45px;
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-movil .text-collapsable:before {
        color: var(--primary);
        content: "•";
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-desktop, .filter-categories-style-1 .list-group-item.level-1 .link-movil {
        padding: 0;
        background-color: #fff;
        font-size: 16px;
        margin-bottom: 0;
        padding-right: 1rem;
        height: 45px;
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-desktop .text-href .angle:before, .filter-categories-style-1 .list-group-item.level-1 .link-movil .text-href .angle:before {
        content: none;
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-desktop .text-href:before, .filter-categories-style-1 .list-group-item.level-1 .link-movil .text-href:before {
        color: var(--primary);
        content: "•";
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-childless {
        background-color: #fff;
        font-size: 16px;
        margin-bottom: 0;
        padding: 0.5rem 1rem;
        height: 45px;
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-childless .angle:before {
        content: none;
    }
    .filter-categories-style-1 .list-group-item.level-1 .link-childless:before {
        color: var(--primary);
        content: "•";
    }
    @media (max-width: 768px) {
        .filter-categories-style-1 .list-group-item.level-1 .link-childless {
            padding-top: 0.7rem !important;
        }
    }
    .filter-categories-style-1 .list-group-item.level-1:last-child {
        border-bottom: 0;
    }
    .filter-categories-style-1 .list-group-item.level-2 {
        border-bottom: 0;
        padding-left: 15px !important;
    }
    .filter-categories-style-1 .list-group-item.level-2 .link-childless:before {
        content: "-";
    }
    .filter-categories-style-2 .item {
        display: none;
    }
    .filter-categories-style-2 .list-group .list-group-item {
        background-color: transparent;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 {
        margin-bottom: 20px;
        padding: 0;
        border: 0;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-desktop {
        font-size: 22px;
        background-color: var(--secondary);
        border-radius: 100px;
        height: 66px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-desktop .icon-collapsable {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 66px;
        border-radius: 100px;
        padding-right: 15px;
        color: #fff;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-desktop .text-href {
        color: #fff;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-desktop .text-href img {
        background-color: var(--secondary);
        border: 3px solid var(--secondary);
        border-radius: 50%;
        width: 66px;
        height: 66px;
        object-fit: none;
        position: absolute;
        top: -33px;
        left: 0;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-desktop .text-href span {
        left: 75px;
        position: absolute;
        top: -13px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil {
        display: block;
        position: relative;
        font-size: 22px;
        background-color: var(--secondary);
        border-radius: 100px;
        border-bottom: 0;
        height: 66px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil a {
        color: #fff;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil img {
        background-color: var(--secondary);
        border: 3px solid var(--secondary);
        border-radius: 50%;
        width: 66px;
        height: 66px;
        object-fit: none;
        position: absolute;
        top: 0;
        left: 0;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .icon-collapsable {
        align-items: baseline;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .text-collapsable {
        position: absolute;
        left: 0;
        top: 0;
        height: 66px;
        display: flex;
        align-items: center;
        padding-bottom: 5px;
        width: 100%;
        border-radius: 100px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .text-collapsable span {
        padding-left: 75px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .text-href {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        width: 225px;
        height: 66px;
        display: flex;
        align-items: center;
        padding-bottom: 5px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .text-href span {
        padding-left: 75px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-movil .icon-href {
        right: 15px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0.category-selected > .link-desktop, .filter-categories-style-2 .list-group > .list-group-item.level-0.category-selected > .link-childless {
        background-color: var(--primary);
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0.category-selected > .link-desktop img, .filter-categories-style-2 .list-group > .list-group-item.level-0.category-selected > .link-childless img {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-childless {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        background-color: var(--secondary);
        color: #fff;
        border-radius: 100px;
        font-size: 22px;
        padding: 20px 20px 20px 75px;
    }
    .filter-categories-style-2 .list-group > .list-group-item.level-0 > .link-childless img {
        background-color: var(--secondary);
        border: 3px solid var(--secondary);
        border-radius: 50%;
        width: 66px;
        height: 66px;
        object-fit: none;
        position: absolute;
        top: 0;
        left: 0;
    }
    .filter-categories-style-2 .list-group .level-1 .link-desktop .text-href:before, .filter-categories-style-2 .list-group .level-1 .link-movil .text-href:before, .filter-categories-style-2 .list-group .level-1 .link-desktop .text-collapsable:before, .filter-categories-style-2 .list-group .level-1 .link-movil .text-collapsable:before {
        color: var(--primary);
        content: "•";
    }
    .filter-categories-style-2 .list-group .level-1 .link-desktop a, .filter-categories-style-2 .list-group .level-1 .link-movil a {
        color: #333333;
        font-weight: 500;
    }
    .filter-categories-style-2 .list-group .level-1 .link-desktop a:hover, .filter-categories-style-2 .list-group .level-1 .link-movil a:hover {
        color: var(--primary);
    }
    .filter-categories-style-2 .list-group .level-1 .link-desktop .icon-href, .filter-categories-style-2 .list-group .level-1 .link-movil .icon-href {
        right: 10px;
    }
    .filter-categories-style-2 .list-group .level-1 .link-childless {
        color: #333333;
        font-weight: 500;
    }
    .filter-categories-style-2 .list-group .level-1 .link-childless:hover {
        color: var(--primary);
    }
    .filter-categories-style-2 .list-group .level-2 {
        border: 0;
    }
    .filter-categories-style-2 .list-group .level-2 .link-childless {
        height: 20px;
    }
    .filter-categories-style-2 .list-group .level-2 .link-childless:before {
        content: "-";
    }
    .filter-categories-style-2 .list-group .level-2 .link-desktop, .filter-categories-style-2 .list-group .level-2 .link-movil {
        height: 20px;
    }
    .filter-categories-style-2 .list-group .level-2 .link-desktop .text-href:before, .filter-categories-style-2 .list-group .level-2 .link-movil .text-href:before, .filter-categories-style-2 .list-group .level-2 .link-desktop .text-collapsable:before, .filter-categories-style-2 .list-group .level-2 .link-movil .text-collapsable:before {
        content: "-";
    }
    .filter-categories-style-2 .list-group .level-3 .link-childless:before {
        content: none;
    }
    .filter-categories-style-2 .list-group .level-3 .link-desktop .text-href:before, .filter-categories-style-2 .list-group .level-3 .link-movil .text-href:before, .filter-categories-style-2 .list-group .level-3 .link-desktop .text-collapsable:before, .filter-categories-style-2 .list-group .level-3 .link-movil .text-collapsable:before {
        content: none;
    }


    .filter-manufacturers .no-results {
        line-height: 1;
    }


    .filter-range-prices .ui-state-active {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>


<!-- nav-header styles -->
<style>
    .nav-header .account-menu .dropdown-item {
        color: #333333;
        font-weight: 500;
    }
    .nav-header li {
        position: relative;
    }
    .nav-header .nav-link {
        font-size: 12px;
        color: #fff;
    }
    .nav-header .nav-link:before {
        content: "";
        height: 16px;
        width: 1px;
        background-color: #037230;
        position: absolute;
        top: 10px;
        right: 0;
    }
    .nav-header .nav-link .cart {
        width: 22px;
    }
    .nav-header .nav-link .cart .quantity {
        width: 18px;
        height: 18px;
        position: absolute;
        border-radius: 50%;
        right: 7px;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.688rem;
        font-weight: bold;
    }
    .nav-header .nav-link .heart {
        width: 20px;
    }
    .nav-header .nav-link svg .cls-1 {
        fill: #fff;
    }

</style>

<!-- index styles -->
<style>
    #content_index_commerce .sticky-top-content {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        z-index: 1000;
        border-bottom: 1px solid #eee;
    }
    #content_index_commerce .sticky-top-content .total-products {
        display: none;
    }
    #content_index_commerce .options-product-list-mobile .total-products {
        text-align: left;
    }
    #content_index_commerce .options-product-list-mobile .change-layout {
        margin-top: 0px !important;
    }
    #content_index_commerce .options-product-list-mobile .filter-order-by .custom-control label {
        font-size: 1rem;
    }
    #content_index_commerce .options-product-list-mobile .products-menu {
        width: 100%;
    }
    #content_index_commerce .options-product-list-mobile .products-menu__item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        width: 33.33%;
        height: 64px;
        font-size: 14px;
        background-color: #fff;
        border: 0;
        padding: 0 10px;
    }
    #content_index_commerce .options-product-list-mobile .products-menu__item:not(:last-child):after {
        position: absolute;
        content: '';
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        right: 0;
        width: 1px;
        height: 80%;
        background-color: rgba(0, 0, 0, 0.3);
    }
    #content_index_commerce .options-product-list-mobile .products-menu__item--layouts .types-columns .active {
        display: none;
    }
    #content_index_commerce .options-product-list-mobile .products-menu__item--filters .fa {
        transform: rotate(-90deg);
    }
    #content_index_commerce .options-product-list-mobile .item-options {
        display: none;
        position: fixed;
        top: 62px;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        overflow: hidden;
        padding: 20px 15px;
        z-index: 99;
    }
    #content_index_commerce .options-product-list-mobile .item-options.show {
        display: block;
    }
    #content_index_commerce .options-product-list-mobile .item-options__title {
        font-size: 18px;
        font-weight: 700;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 15px;
        min-height: 40px;
    }
    #content_index_commerce .options-product-list-mobile .item-options__close {
        position: absolute;
        top: 12px;
        right: 12px;
        color: rgba(0, 0, 0, 0.4);
        font-size: 22px;
        line-height: 0;
    }
    #content_index_commerce .options-product-list-mobile .item-options__close:focus {
        box-shadow: none;
    }
    #content_index_commerce .options-product-list-mobile .item-options .filter-order-by {
        margin-left: 20px;
    }
    @media (max-width: 768px) {
        #content_index_commerce .product-list .total-products {
            text-align: center;
        }
        #content_index_commerce .product-list .filter-order-by {
            float: left;
        }
        #content_index_commerce .product-list .change-layout {
            float: right;
            margin-top: -58px;
            flex-direction: column;
            align-items: initial !important;
        }
    }

</style>

<!-- show styles -->
<style>
    #content_show_commerce .information .price {
        font-size: 2.25rem;
    }
    #content_show_commerce #icommerce_let_me_know_when_product_is_av .productName {
        display: none;
    }
    #content_show_commerce input.quantity {
        max-width: 100px;
    }
    #content_show_commerce .bg-image .img-mini {
        width: 67px;
        padding: 2px;
    }
    #content_show_commerce .bg-image .img-mini img {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }
    #content_show_commerce .bg-image .img-big {
        background-color: #d2d2d2;
        padding: 1px;
    }
    #content_show_commerce .bg-image .img-big img {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }
    @media (max-width: 336px) {
        #content_show_commerce .bg-image .img-mini {
            display: inline-block;
            margin-left: 5px;
        }
    }
    #content_show_commerce .btn-comprar svg {
        width: 20px;
        fill: white;
    }

</style>