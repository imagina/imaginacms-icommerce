<div class="block-owl-carousel">,
    <x-isite::carousel.owl-carousel
        id="relatedProductsShow"
        repository="Modules\Icommerce\Repositories\ProductRepository"
        :params="['filter' => ['categories' => $product->categories->pluck('id'),'ids'=>$product->relatedProducts->pluck('id')],'take' => 20]"
        :margin="10"
        :navText="['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa fa-angle-right\'></i>']"
        :title="trans('icommerce::products.title.related')"
        :loop="false"
        :responsive="[0 => ['items' =>  2],640 => ['items' => 3],992 => ['items' => 4]]"/>
</div>
