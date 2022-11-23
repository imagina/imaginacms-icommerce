<?php

$vAttributes = include(base_path() . '/Modules/Isite/Config/standardValuesForBlocksAttributes.php');

return [
  "productListItem" => [
    "title" => "Producto",
    "systemName" => "icommerce::components.product-list-item",
    "nameSpace" => "Modules\Icommerce\View\Components\ProductListItem",
    "internal" => true,
    "attributes" => [
          "general" => [
              "title" => "General",
              "fields" => [
                  "itemListLayout" => [
                      "name" => "itemListLayout",
                      "value" => "product-list-item-layout-1",
                      "type" => "select",
                      'columns' => 'col-12',
                      "props" => [
                          "label" => "itemListLayout",
                          "options" => [
                              ["label" => "product-list-item-layout-1", "value" => "product-list-item-layout-1"],
                              //["label" => "product-list-item-layout-2", "value" => "product-list-item-layout-2"],
                              //["label" => "product-list-item-layout-3", "value" => "product-list-item-layout-3"]
                          ]
                      ]
                  ],
                  "externalPadding" => [
                      "name" => "externalPadding",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado Externo (px)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
                  "externalBorderRadius" => [
                      "name" => "externalBorderRadius",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Borde Redondeado (px)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "50",
                      ]
                  ],
                  "externalBorder" => [
                      "name" => "externalBorder",
                      "value" => false,
                      "type" => "select",
                      "props" => [
                          "label" => "Borde Externo",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "externalBorderColor" => [
                      "name" => "externalBorderColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color Borde Externo"
                      ]
                  ],
                  "externalShadowOnHover" => [
                      "name" => "externalShadowOnHover",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => "Sombra Externa en hover",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "externalShadowOnHoverColor" => [
                      "name" => "externalShadowOnHoverColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color Sombra Externa"
                      ]
                  ],
                  "productBackgroundColor" => [
                      "name" => "productBackgroundColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color de fondo"
                      ]
                  ],
              ]
          ],
          "buttons" => [
              "title" => "Botones",
              "fields" => [
                  "buttonsLayout" => [
                      "name" => "buttonsLayout",
                      "value" => "borders",
                      'columns' => 'col-12',
                      "type" => "select",
                      "props" => [
                          "label" => "Estilo de Botones",
                          "options" => [
                              ["label" => "Bordes a los lados", "value" => "borders"],
                              ["label" => "Sin bordes", "value" => "without-borders"],
                              ["label" => "Botones Redondos", "value" => "rounded"],
                              ["label" => "Botones Semi-cuadrados", "value" => "semi-square"],
                              ["label" => "Botones Cuadrados", "value" => "square"],
                              ["label" => "Botones Outline Redondos", "value" => "outline rounded"],
                              ["label" => "Botones Outline Semi-cuadrados", "value" => "outline semi-square"],
                              ["label" => "Botones Outline Cuadrados", "value" => "outline square"]
                          ],
                      ],
                  ],
                  "buttonsPosition" => [
                      "name" => "buttonsPosition",
                      "value" => "in-content",
                      'columns' => 'col-12',
                      "type" => "select",
                      "props" => [
                          "label" => "Posición de Botones",
                          "options" => [
                              ["label" => "Dentro del Contenido", "value" => "in-content"],
                              ["label" => "Luego del Contenido Centrado", "value" => "after-content-center"],
                              ["label" => "Sobre la Foto Superior Izquierda", "value" => "top-left-in-photo"],
                              ["label" => "Sobre la Foto Superior Centrado", "value" => "top-center-in-photo"],
                              ["label" => "Sobre la Foto Superior Derecha", "value" => "top-right-in-photo"],
                              ["label" => "Sobre la Foto Inferior Izquierda", "value" => "bottom-left-in-photo"],
                              ["label" => "Sobre la Foto Inferior Izquierda en linea", "value" => "bottom-left-inline-in-photo"],
                              ["label" => "Sobre la Foto Inferior Centrado", "value" => "bottom-center-in-photo"],
                              ["label" => "Sobre la Foto Inferior Derecha", "value" => "bottom-right-in-photo"],
                              ["label" => "Sobre la Foto Inferior Derecha en linea", "value" => "bottom-right-inline-in-photo"],
                              ["label" => "Sobre la Foto Añadir Inferior Full con Wishlist", "value" => "bottoms-full-in-photo"],
                              ["label" => "Sobre la Foto Añadir Inferior Full y Wishlist Superior Centrado", "value" => "abf-wtc-in-photo"],
                          ],
                      ]
                  ],
                  "addToCartIcon" => [
                      "name" => "addToCartIcon",
                      "value" => "fa-shopping-cart",
                      "type" => "select",
                      "props" => [
                          "label" => "Icono para añadir al carrito",
                          "options" => [
                              ["label" => "fa-shopping-cart", "value" => "fa-shopping-cart"],
                              ["label" => "fa-shopping-bag", "value" => "fa-shopping-bag"],
                              ["label" => "fa-shopping-basket", "value" => "fa-shopping-basket"],
                              ["label" => "fa-cart-plus", "value" => "fa-cart-plus"]
                          ],
                      ]
                  ],
                  "wishlistEnable" => [
                      "name" => "wishlistEnable",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => " Mostrar botón lista de deseos (Wishlist)",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "wishlistIcon" => [
                      "name" => "wishlistIcon",
                      "value" => "fa-heart-o",
                      "type" => "select",
                      "props" => [
                          "label" => "Icono lista de deseos",
                          "options" => [
                              ["label" => "fa-heart-o", "value" => "fa-heart-o"],
                              ["label" => "fa-heart", "value" => "fa-heart"],
                          ],
                      ]
                  ],
                  "showButtonsOnMouseHover" => [
                      "name" => "showButtonsOnMouseHover",
                      "value" => false,
                      "type" => "select",
                      "props" => [
                          "label" => "Mostrar botones al pasar mouse",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "withTextInAddToCart" => [
                      "name" => "withTextInAddToCart",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => "Mostrar texto de añadir a carrito",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "withIconInAddToCart" => [
                      "name" => "withIconInAddToCart",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => "Mostrar icono dentro de añadir a carrito",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "addToCartWithQuantity" => [
                      "name" => "addToCartWithQuantity",
                      "value" => false,
                      "type" => "select",
                      "props" => [
                          "label" => "Añadir al carrito con cantidad",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "addToCartWithQuantityStyle" => [
                      "name" => "addToCartWithQuantityStyle",
                      "type" => "input",
                      "props" => [
                          "label" => "Fondo forma del carrito (revisar)"
                      ]
                  ],
                  "addToCartWithQuantityPaddingX" => [
                      "name" => "addToCartWithQuantityPaddingX",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado en X (px)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
                  "addToCartWithQuantityPaddingY" => [
                      "name" => "addToCartWithQuantityPaddingY",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado en Y (px)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
                  "addToCartWithQuantityMarginBottom" => [
                      "name" => "addToCartWithQuantityMarginBottom",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Margen Inferior (px)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
              ]
          ],
          "content" => [
              "title" => "Contenido",
              "fields" => [
                  "contentAlign" => [
                      "name" => "contentAlign",
                      "value" => "text-left",
                      "type" => "select",
                      "props" => [
                          "label" => "Alineación del Contenido",
                          //"options" => $vAttributes["align"]
                          "options" => [
                              ["label" => "Centrado", "value" => "text-center"],
                              ["label" => "Derecha", "value" => "text-right"],
                              ["label" => "Izquierda", "value" => "text-left"]
                          ],
                      ]
                  ],
                  "contentExternalPaddingX" => [
                      "name" => "contentExternalPaddingX",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado del contenido horizontal",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
                  "contentExternalPaddingY" => [
                      "name" => "contentExternalPaddingY",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado del contenido vertical",
                          "type" => "number",
                          "min" => "0",
                          "max" => "20",
                      ]
                  ],
                  "contentTitleFontSize" => [
                      "name" => "contentTitleFontSize",
                      "value" => "14",
                      "type" => "input",
                      "props" => [
                          "label" => "Tamaño letra (Titulo)",
                          "type" => "number"
                      ]
                  ],
                  "contentTitleToUppercase" => [
                      "name" => "contentTitleToUppercase",
                      "value" => false,
                      "type" => "select",
                      "props" => [
                          "label" => "Convertir a Mayúsculas (Titulo)",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "contentTitleMaxHeight" => [
                      "name" => "contentTitleMaxHeight",
                      "value" => "18",
                      "type" => "input",
                      "props" => [
                          "label" => "Altura Mínima/Máxima (Titulo)",
                          "type" => "number",
                          "min" => "0",
                          "max" => "100",
                      ]
                  ],
                  "contentTitleNumberOfCharacters" => [
                      "name" => "contentTitleNumberOfCharacters",
                      "value" => "100",
                      "type" => "input",
                      "props" => [
                          "label" => "Número caracteres (Titulo)",
                          "type" => "number"
                      ]
                  ],
                  "contentTitleFontWeight" => [
                      "name" => "contentTitleFontWeight",
                      "value" => "normal",
                      "type" => "select",
                      "props" => [
                          "label" => "Negrita (Titulo)",
                          //"options" => $vAttributes["fontWeight"]
                          "options" => [
                              ["label" => "Texto en negrita", "value" => "bold"],
                              ["label" => "Texto en negrita (relativo al elemento principal)", "value" => "bolder"],
                              ["label" => "Texto de peso normal", "value" => "normal"],
                              ["label" => "Texto más ligero (en relación con el elemento principal)", "value" => "lighter"]
                          ],
                      ]
                  ],
                  "contentCategoryEnable" => [
                      "name" => "contentCategoryEnable",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => "Mostrar categoria",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "contentCategoryFontSize" => [
                      "name" => "contentCategoryFontSize",
                      "value" => "10",
                      "type" => "input",
                      "props" => [
                          "label" => "Tamaño letra (Categoria)",
                          "type" => "number"
                      ]
                  ],
                  "contentCategoryToUppercase" => [
                      "name" => "contentCategoryToUppercase",
                      "value" => true,
                      "type" => "select",
                      "props" => [
                          "label" => "Convertir a Mayúsculas (Categoria)",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "contentCategoryFontWeight" => [
                      "name" => "contentCategoryFontWeight",
                      "value" => "normal",
                      "type" => "select",
                      "props" => [
                          "label" => "Negrita (Categoria)",
                          //"options" => $vAttributes["fontWeight"]
                          "options" => [
                              ["label" => "Texto en negrita", "value" => "bold"],
                              ["label" => "Texto en negrita (relativo al elemento principal)", "value" => "bolder"],
                              ["label" => "Texto de peso normal", "value" => "normal"],
                              ["label" => "Texto más ligero (en relación con el elemento principal)", "value" => "lighter"]
                          ],
                      ]
                  ],
                  "contentPriceFontSize" => [
                      "name" => "contentPriceFontSize",
                      "value" => "10",
                      "type" => "input",
                      "props" => [
                          "label" => "Tamaño letra (Precio)",
                          "type" => "number"
                      ]
                  ],
                  "contentPriceFontWeight" => [
                      "name" => "contentPriceFontWeight",
                      "value" => "normal",
                      "type" => "select",
                      "props" => [
                          "label" => "Negrita (Precio)",
                          //"options" => $vAttributes["fontWeight"]
                          "options" => [
                              ["label" => "Texto en negrita", "value" => "bold"],
                              ["label" => "Texto en negrita (relativo al elemento principal)", "value" => "bolder"],
                              ["label" => "Texto de peso normal", "value" => "normal"],
                              ["label" => "Texto más ligero (en relación con el elemento principal)", "value" => "lighter"]
                          ],
                      ]
                  ],
              ]
          ],
          "discount" => [
              "title" => "Descuento",
              "fields" => [
                  "discountRibbonStyle" => [
                      "name" => "discountRibbonStyle",
                      "value" => "flag",
                      "type" => "select",
                      "props" => [
                          "label" => "Estilo para el descuento",
                          //"options" => $vAttributes["ribbonStyle"]
                          "options" => [
                              ["label" => "Bandera", "value" => "flag"],
                              ["label" => "Circulo", "value" => "circle"],
                              ["label" => "Cuadrado", "value" => "square"]
                          ],
                      ]
                  ],
                  "discountPosition" => [
                      "name" => "discountPosition",
                      "value" => "top-right",
                      "type" => "select",
                      "props" => [
                          "label" => "Posición del descuento",
                          //"options" => $vAttributes["ribbonPosition"]
                          "options" => [
                              ["label" => "Superior Derecha", "value" => "top-right"],
                              ["label" => "Superior Izquierda", "value" => "top-left"]
                          ],
                      ]
                  ],
                  "ribbonBackgroundColor" => [
                      "name" => "ribbonBackgroundColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color de fondo de cinta"
                      ]
                  ],
                  "ribbonTextColor" => [
                      "name" => "ribbonTextColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color texto de cinta"
                      ]
                  ],
              ]
          ],
          "image" => [
              "title" => "Imagen",
              "fields" => [
                  "productAspect" => [
                      "name" => "productAspect",
                      "value" => "1-1",
                      "type" => "select",
                      "props" => [
                          "label" => "Aspecto de fotografía",
                          //"options" => $vAttributes["imageAspectProduct"]
                          "options" => [
                              ["label" => "Aspect 1:1", "value" => "1-1"],
                              ["label" => "Aspect 4:3", "value" => "4-3"]
                          ],
                      ]
                  ],
                  "imagePadding" => [
                      "name" => "imagePadding",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Espaciado de Imagen",
                          "type" => "number",
                          "min" => "0",
                      ]
                  ],
                  "imageBorder" => [
                      "name" => "imageBorder",
                      "value" => false,
                      "type" => "select",
                      "props" => [
                          "label" => "Borde Externo",
                          //"options" => $vAttributes["booleanValidation"]
                          "options" => [
                              ["label" => "Si", "value" => true],
                              ["label" => "No", "value" => false]
                          ]
                      ]
                  ],
                  "imageBorderColor" => [
                      "name" => "imageBorderColor",
                      "type" => "inputColor",
                      "props" => [
                          "label" => "Color borde"
                      ]
                  ],
                  "imageBorderRadius" => [
                      "name" => "imageBorderRadius",
                      "value" => "0",
                      "type" => "input",
                      "props" => [
                          "label" => "Borde Redondeado",
                          "type" => "number",
                          "min" => "0"
                      ]
                  ],
                  "imageObjectFit" => [
                      "name" => "imageObjectFit",
                      "value" => "contain",
                      "type" => "select",
                      "props" => [
                          "label" => "Ajuste de Imagen",
                          "options" => $vAttributes["imageObject"]
                      ]
                  ],
              ]
          ]
      ]
  ]
];
