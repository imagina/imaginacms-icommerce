<?php

return [
  'icommerce' => 'Ecommerce',
  'home' => [
    'title' => 'Home',
    'details' => 'DETAILS',
  ],
  'button' => [
    'update' => 'Update',
  ],
  'sidebar' => [
    'products' => 'Products',
    'shipping' => 'Shipment',
    'paymentsanddiscount' => 'Payment methods and discounts'
  ],
  'table' => [
  ],
  'form' => [
  ],
  'formFields' => [
    'mode' => 'Mode',
    'minimum Amount' => 'Minimum amount',
    'maximum Amount' => 'Maximum amount',
    'excludedUsersForMaximumAmount' => 'Excluded users for maximum amount',
  ],
  'pages' => [
    'index' => 'Index Page',
    'checkout' => 'Checkout Page',
    'labelDefaultTypeCustomer' => 'Buy as a guest user by default',
  ],
  'filters' => [
    'title' => 'Filters',
    'categories' => [
      'group' => 'Filter Categories',
      'title' => 'Title'
    ],
    'priceRange' => [
      'group' => 'Filter Price Range',
      'step' => 'Step'
    ],
    'priceList' => [
      'group' => 'Price Lists'
    ],
  ],
  'messages' => [
    'title is required' => 'The title is required',
    'title min 2' => 'The title must contain a minimum of two characters',
    'description is required' => 'Description is required',
    'description min 2' => 'The description must contain a minimum of two characters',
    'no products' => 'There are no products available',
    'field required' => 'This field is required',
    'min 2 characters' => 'Minimum of 2 characters',
  ],
  'validation' => [
    'maximumAmount' => "The order total exceed the maximum amount available (:maximumAmount) for this payment method",
    'maximumAmount' => "The order total must be greater than: (:maximumAmount) for this payment method"
  ],
  'status' => [
    'draft' => 'Draft',
    'pending' => 'Pending Review',
    'published' => 'Published',
    'unpublished' => 'On hold',
  ],
  'status_text' => 'Status',
  'download' => 'Download',
  'image' => 'Picture',
  'categories' => 'Categories:',
  'title' => 'Title',
  'slug' => 'Permanent link:',
  'description' => 'Description',
  'status' => 'Status',
  'minimum Amount' => 'Minimum amount',
  'date' => 'Date and Time',
  'optional' => '(Optional)',
  'summary' => 'Summary',
  'content' => 'Contents',
  'select' => 'Select an option',
  'author' => 'Author',
  'default_category' => 'Main Category',
  'admin_notes' => 'Administration Notes',
  'created_at' => 'Creation date',
  'parent' => 'Higher',
  'settings' => [
    'couponsQuantity' => 'Amount of Coupons',
    'couponAvailable' => 'Activate Coupon',
    'codeLenght' => 'Code Length (Excludes Prefix, Suffix and Separators)',
    'couponFormat' => 'Coupon Format',
    'alphanumeric' => 'Alphanumeric',
    'numeric' => 'Numeric',
    'alphabetic' => 'Alphabetical',
    'codePrefix' => 'Prefix (If necessary)',
    'codeSufix' => 'Suffix (If necessary)',
    'dashEvery' => 'Dash each character x - Ahem: If the number is 3 the code would be xxx-xxx-xxx',
    'tax' => 'Tax',
    'orderitemsTax' => 'Rate in OrderItems',
    'emails' => 'Webmaster Email',
    'usersToNotify' => 'Users to Notify',
    'fromemail' => 'Email',
    'countryTax' => 'Country where the rate will be applied',
    'countryDefault' => 'Country by Default',
    'countryFreeshipping' => 'Country with free shipping of Products',
    'product-per-page' => 'Products by page',
    'customIndexTitle' => 'Title Page Index',
    'customIndexDescription' => 'Page Index - Description',
    'filterRangePricesStep' => 'Price Range Filter - Step',
    'daysEnabledForNewProducts' => 'days enabled for new products ',
    'customIndexContactLabel' => 'Title for Contact Button',
    'customCheckoutTitle' => 'Title for Checkout',
    'icommerceCartQuoteForm' => 'Quote Form',
    'letMeKnowProductIsAvailableForm' => 'Let me know when the product is available Form',
    'chatByOrderEnable' => 'Enable chat by order',
    'productImageBorder' => 'Image border',
    'productImageBorderColor' => 'Image border color',
    'productImageBorderRadius' => 'Image border radius',
    'productExternalPadding' => 'External Padding',
    'productExternalBorder' => 'External border',
    'productExternalBorderRadius' => 'External border radius',
    'productExternalBorderColor' => 'External border color',
    'productExternalShadowOnHover' => 'External shadow on mousehover',
    'productExternalShadowOnHoverColor' => 'External shadow on mousehover color',
    'productWithTextInAddToCart' => 'Enable Text in add to Cart button',
    'productWithIconInAddToCart' => 'Enable Icon un add to cart button',
    'productShowButtonsOnMouseHover' => 'Show button on mouse Hover',
    'productContentExternalPaddingX' => 'Padding in X to the Content',
    'productContentExternalPaddingY' => 'Padding in Y to the Content',
    'productAddToCartWithQuantityPaddingX' => 'Padding in X to the add to cart with quantity',
    'productAddToCartWithQuantityPaddingY' => 'Padding in Y to the add to cart with quantity',
    'productAddToCartWithQuantityMarginBottom' => 'Margin bottom to the add to cart with quantity',
    'productContentTitleFontSize' => 'Title font size',
    'productContentTitleToUppercase' => 'Enable Title uppercase',
    'productContentCategoryFontSize' => 'Category font size',
    'productContentCategoryToUppercase' => 'Enable Category uppercase',
    'productContentCategoryEnable' => 'Show Category',
    'productContentPriceFontSize' => 'Price font size',
    'productContentTitleNumberOfCharacters' => 'Title number of characters',
    'productContentTitleMaxHeight' => 'Min/Max height title',
    'productWishlistEnable' => 'Enable wishlist button',
  
    'tenant' => [
      'group' => 'Tenants',
      'tenantWithCentralData' => 'Entities with central data',
      'entities' => [
        'products' => 'Products',
        'categories' => 'Categories',
        'carts' => 'Carts',
        'paymentMethods' => 'Payment Methods',
        'shippingMethods' => 'Shipping Methods',
        'orders' => 'Orders',
      ],
    ],
    'product' => [
      'group' => 'Product',
      'layout' => 'Product Layout',
      'minimumQuantityToNotify' => 'Minimum quantity to notify low stock',
      'showButtonToQuoteInStore' => 'Show button to quote in store',
      'addToCartQuoteButtonAction' => 'Add to quote button action',
      'addToCartButtonAction' => 'Add to cart button action',
      'showButtonThatGeneratesPdfOfTheCart' => 'Show button that generates a PDF of the cart',
      'showReviewsProduct' => 'Show product reviews',
      'showRatingProduct' => 'Show product rating',
      'showRatingInReviewsProduct' => 'Show rating in product reviews',
    ],
    'product-price-list-enable' => 'Enable',
    'product-add-to-cart-with-quantity' => 'Add to Cart with quantity (Product Item)',
    'cart' => [
      'group' => 'Cart',
      'canAddIsCallProductsIntoCart' => 'Can Add Is Call Products Into Cart'
    ]
  ],
  'settingHints' => [
    'emails' => "Type the email and press enter key"
  ],
  'uri' => 'icommerce',
  'emailSubject' => [
    'failed' => 'Failed transaction',
    'complete' => 'Complete transaction',
    'refunded' => 'Transaction declined',
    'pending' => 'Pending transaction',
    'history' => 'Order Status',
  ],
  'emailIntro' => [
    'failed' => 'Payment System report: Transaction Failed',
    'complete' => 'Payment System report: Transaction Completed',
    'refunded' => 'Payment System report: Transaction Rejected',
    'pending' => 'Payment System report: Transaction Pending',
    'history' => 'El estado de la orden ha cambiado',
  ],
  'emailMsg' => [
    'order' => 'Order',
    'success' => 'Was proccessed successfully',
    'articles' => 'Articles',
    'comment' => 'Comment',
    'orderurl' => 'If you wish to see your order status at any time, please go to the next link: '
  ],
  'payuSubject' => [
    'signError' => 'Payment System report: Signature Error',
  ],
  'payuIntro' => [
    'signError' => 'Payment System report: Signature Error',
  ],
  'sort' => [
    'title' => 'Order by',
    'all' => 'All',
    'name_a_z' => 'Name (A - Z)',
    'name_z_a' => 'Name (Z - A)',
    'price_low_high' => 'Price: lower to higher',
    'price_high_low' => 'Price: higher to lower',
    'recently' => 'More Recently',
  ],
  'range' => [
    'title' => 'Price Range',
  ],
  'product-type' => [
    'title' => 'Product Type',
    'searchable' => 'Searchable',
    'affordable' => 'Afrrodable'
  ],
  'pagination' => [
    'previous' => 'Previous',
    'next' => 'Next',
  ],
  'featured_recommended' => [
    'quick_view' => 'QUICK VIEW',
    'featured' => 'FEATURED',
    'recommended' => 'RECOMMENDED',
  ],
  'search' => [
    'go' => 'GO',
    'no_results' => 'No results',
    'see_all' => 'See all results ...',
    'search_result' => 'Search result for',
  ],
  'related' => [
    'page' => 'RELATED PAGE',
    'unknown' => 'Lorem ipsum dolor sit amet1',
  ],
  'bulkload' => [
    'massive_load' => 'Bulk Load',
    'pro_cat_bran' => 'Products - Categories - Brands',
    'load_data' => 'Load data',
  ],
  'email' => [
    'subject' => 'Transaction Status:',
    'intro' => 'Payment System Report',
    'msg' => [
      'order' => 'Order',
      'success' => 'processed',
      'articles' => 'Articles',
      'comment' => 'Comment',
      'orderurl' => 'If you want to check the status of your order at any time please go to the link: '
    ],
  ],

  'social' => [
    'share' => 'Share'
  ],

  'offers' => [
    'title' => 'Offers'
  ]

];
