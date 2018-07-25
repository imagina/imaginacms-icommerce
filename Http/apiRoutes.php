<?php

use Illuminate\Routing\Router;

/** @var Router $router
$router->bind('page', function ($id) {
    return app(\Modules\Page\Repositories\PageRepository::class)->find($id);
});
*/



$router->group(['prefix' => 'icommerce'], function (Router $router) {

    /* CARTING */
    $router->get('items_cart', [
        'as' => 'icommerce.api.get.cart',
        'uses' => 'CartController@get_cart',
    ]);

    $router->post('add_cart', [
        'as' => 'icommerce.api.cart.index',
        'uses' => 'CartController@add_cart',
    ]);

    $router->post('clear_cart', [
        'as' => 'icommerce.api.clear.cart',
        'uses' => 'CartController@clear_cart',
    ]);

    $router->post('delete_item', [
        'as' => 'icommerce.api.delete.item.cart',
        'uses' => 'CartController@delete_item',
    ]);

    $router->post('delete_all', [
        'as' => 'icommerce.api.delete.all.cart',
        'uses' => 'CartController@delete_all',
    ]);

    $router->post('update_item', [
        'as' => 'icommerce.api.update.item.cart',
        'uses' => 'CartController@update',
    ]);

   //shipping
    $router->post('shipping_methods', [
        'as' => 'icommerce.api.shipping.methods',
        'uses' => 'CartController@shippingMethods',
    ]);

    /*SEARCHER*/
    $router->get('product_search', [
        'as' => 'icommerce.api.product.search',
        'uses' => 'ProductController@products_search',
    ]);


    /*PRODUCT CATEGORY*/
    $router->get('products/{category}', [
        'as' => 'icommerce.api.products.category',
        'uses' => 'ProductController@products_category',
    ]);

    /*PRODUCT DETALS OF THE WEEK*/
    $router->get('detals/{category}', [
        'as' => 'icommerce.api.products.detals',
        'uses' => 'ProductController@detals_category',
    ]);

    /*PRODUCT*/
    $router->get('product/{id}', [
        'as' => 'icommerce.api.product',
        'uses' => 'ProductController@product_id',
    ]);

    /*PRODUCT FREESHIPPING*/
    $router->get('products_freeshipping', [
        'as' => 'icommerce.api.products.freeshipping',
        'uses' => 'ProductController@products_freeshipping',
    ]);

    /*PRODUCT BY MANUFACTURER*/
    $router->get('products_manufacturer', [
        'as' => 'icommerce.api.products.manufacturer',
        'uses' => 'ProductController@products_by_manufacturer',
    ]);

    /* ADD ITEM TO WISH LIST */
    $router->post('wishlist_add', [
        'as' => 'icommerce.api.wishlist.add',
        'uses' => 'WishListController@addWishList',
    ]);

    /* GET WISH LIST */
    $router->get('wishlist_user', [
        'as' => 'icommerce.api.wishlist.user',
        'uses' => 'WishListController@getWishList',
    ]);

    /* DELETE ITEM TO WISH LIST */
    $router->post('wishlist_delete', [
        'as' => 'icommerce.api.wishlist.delete',
        'uses' => 'WishListController@deleteWishList',
    ]);

    /*PRODUCT COMMENTS*/
    $router->get('product_comments/{id}', [
        'as' => 'icommerce.api.product.comments',
        'uses' => 'ProductController@comments_product',
    ]);

    $router->group(['prefix'=>'v2/'],function(Router $router){

        $router->group(['prefix'=>'categories'],function(Router $router){

            $router->get('/',[
                'as' => 'icommerce.api.categories',
                'uses' => 'CategoryControllerV2@products',
            ]);

            $router->get('{id}/products',[
                'as' => 'icommerce.api.categories.products',
                'uses' => 'CategoryControllerV2@products',
            ]);

            $router->post('/',[
                'as'=>'icommerce.api.catedories.store',
                'uses' => 'CategoryControllerV2@store',
            ]);

            $router->put('{id}',[
                'as'=>'icommerce.api.catedories.update',
                'uses' => 'CategoryControllerV2@update',
            ]);
            $router->delete('{id}',[
                'as'=>'icommerce.api.catedories.delete',
                'uses' => 'CategoryControllerV2@delete',
            ]);

        });


        //products
        $router->group(['prefix'=>'products'],function(Router $router){

            $router->get('/',[
                'as' => 'icommerce.api.products',
                'uses' => 'ProductControllerV2@products',
            ]);
            $router->post('/',[
                'as'=>'icommerce.api.products.store',
                'uses' => 'ProductControllerV2@store',
            ]);

            $router->put('{id}',[
                'as'=>'icommerce.api.products.update',
                'uses' => 'ProductControllerV2@update',
            ]);
            $router->delete('{id}',[
                'as'=>'icommerce.api.products.delete',
                'uses' => 'ProductControllerV2@delete',
            ]);
        });
    });






});


