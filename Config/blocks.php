<?php

$vAttributes = include(base_path() . '/Modules/Isite/Config/standardValuesForBlocksAttributes.php');

return [
  "productListItem" => [
    "title" => "ProductListItem",
    "systemName" => "icommerce::components.product-list-item",
    "nameSpace" => "Modules\Icommerce\View\Components\ProductListItem",
    "internal" => true,
    "attributes" => [
      "general" => [
        "title" => "general",
        "fields" => [
          "item" => [
            "name" => "item",
            "type" => "input",
            "props" => [
              "label" => "item"
            ]
          ],
          "itemListLayout" => [
            "name" => "itemListLayout",
            "type" => "select",
            "props" => [
              "label" => "itemListLayout",
              "options" => [
                ["label" => "product-list-item-layout-1", "value" => "product-list-item-layout-1"],
                ["label" => "product-list-item-layout-2", "value" => "product-list-item-layout-2"],
                ["label" => "product-list-item-layout-3", "value" => "product-list-item-layout-3"]
              ]
            ]
          ],
          "layout" => [
            "name" => "layout",
            "type" => "input",
            "props" => [
              "label" => "layout"
            ]
          ],
          "discountRibbonStyle" => [
            "name" => "discountRibbonStyle",
            "type" => "input",
            "props" => [
              "label" => "estilo de la cinta"
            ]
          ],
          "discountPosition" => [
            "name" => "discountPosition",
            "type" => "input",
            "props" => [
              "label" => "estilo de pocision",
            ]
          ],
          "imagePadding" => [
            "name" => "imagePadding",
            "type" => "input",
            "props" => [
              "label" => "padding de la imagen",
              "type" => "number"
            ]
          ],
          "imageBorder" => [
            "name" => "imageBorder",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "borde de la imagen",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "imageBorderColor" => [
            "name" => "imageBorderColor",
            "type" => "inputColor",
            "props" => [
              "label" => "color borde de la imagen"
            ]
          ],
          "imageBorderRadius" => [
            "name" => "imageBorderRadius",
            "type" => "input",
            "props" => [
              "label" => "radio borde de la imagen",
              "type" => "number"
            ]
          ],
          "imageAspect" => [
            "name" => "imageAspect",
            "type" => "",
            "props" => [
              "label" => "aspecto de la imagen"
            ]
          ],
          "externalPadding" => [
            "name" => "externalPadding",
            "type" => "input",
            "props" => [
              "label" => "padding externo",
              "type" => "number"
            ]
          ],
          "externalBorder" => [
            "name" => "externalBorder",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "borde externo",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "externalBorderRadius" => [
            "name" => "externalBorderRadius",
            "type" => "input",
            "props" => [
              "label" => "borde radio externo"
            ]
          ],
          "externalBorderColor" => [
            "name" => "externalBorderColor",
            "type" => "inputColor",
            "props" => [
              "label" => "color borde externo"
            ]
          ],
          "externalShadowOnHover" => [
            "name" => "externalShadowOnHover",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "sombra al pasar el mouse",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "externalShadowOnHoverColor" => [
            "name" => "externalShadowOnHoverColor",
            "type" => "inputColor",
            "props" => [
              "label" => "color de sombra externo"
            ]
          ],
          "addToCartIcon" => [
            "name" => "addToCartIcon",
            "type" => "input",
            "props" => [
              "label" => "añadir carta icon"
            ]
          ],
          "wishlistEnable" => [
            "name" => "wishlistEnable",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "lista de deseos habilitar",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "wishlistIcon" => [
            "name" => "wishlistIcon",
            "type" => "input",
            "props" => [
              "label" => "icono lista de deseos",
            ]
          ],
          "addToCartWithQuantityStyle" => [
            "name" => "addToCartWithQuantityStyle",
            "type" => "input",
            "props" => [
              "label" => "fondo forma del carrito"
            ]
          ],
          "withTextInAddToCart" => [
            "name" => "withTextInAddToCart",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "con texto de añadir a carrito",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "withIconInAddToCart" => [
            "name" => "withIconInAddToCart",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "con icono dentro de añadir a carrito",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "addToCartWithQuantity" => [
            "name" => "addToCartWithQuantity",
            "value" => "false",
            "type" => "select",
            "props" => [
              "label" => "añadir a el carrito cantidad",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "showButtonsOnMouseHover" => [
            "name" => "showButtonsOnMouseHover",
            "value" => "false",
            "type" => "select",
            "props" => [
              "label" => "mostrar botones al pasar mouse",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "buttonsLayout" => [
            "name" => "buttonsLayout",
            "type" => "input",
            "props" => [
              "label" => "botones del layout"
            ]
          ],
          "buttonsPosition" => [
            "name" => "buttonsPosition",
            "type" => "input",
            "props" => [
              "label" => "pocision de los botones"
            ]
          ],
          "contentAlign" => [
            "name" => "contentAlign",
            "type" => "input",
            "props" => [
              "label" => "alineacion del contenido"
            ]
          ],
          "contentExternalPaddingX" => [
            "name" => "contentExternalPaddingX",
            "type" => "input",
            "props" => [
              "label" => "padding contenido horizontal",
              "type" => "number"
            ]
          ],
          "contentExternalPaddingY" => [
            "name" => "contentExternalPaddingY",
            "type" => "input",
            "props" => [
              "label" => "padding contenido vertical",
              "type" => "number"
            ]
          ],
          "addToCartWithQuantityPaddingX" => [
            "name" => "addToCartWithQuantityPaddingX",
            "type" => "input",
            "props" => [
              "label" => "padding horizontal de añadir carrito ",
              "type" => "number"
            ]
          ],
          "addToCartWithQuantityPaddingY" => [
            "name" => "addToCartWithQuantityPaddingY",
            "type" => "input",
            "props" => [
              "label" => "padding vertical de añadir carrito",
              "type" => "number"
            ]
          ],
          "addToCartWithQuantityMarginBottom" => [
            "name" => "addToCartWithQuantityMarginBottom",
            "type" => "input",
            "props" => [
              "label" => "magen boton de añadir a carrito",
              "type" => "number"
            ]
          ],
          "contentTitleFontSize" => [
            "name" => "contentTitleFontSize",
            "type" => "input",
            "props" => [
              "label" => "tamaño letra titulo contenido",
              "type" => "number"
            ]
          ],
          "contentTitleMaxHeight" => [
            "name" => "contentTitleMaxHeight",
            "type" => "input",
            "props" => [
              "label" => "maximo tamaño titulo contenido",
              "type" => "number"
            ]
          ],
          "contentTitleNumberOfCharacters" => [
            "name" => "contentTitleNumberOfCharacters",
            "type" => "input",
            "props" => [
              "label" => "numero caracteristicas titulo contenido",
              "type" => "number"
            ]
          ],
          "contentTitleToUppercase" => [
            "name" => "contentTitleToUppercase",
            "value" => "false",
            "type" => "select",
            "props" => [
              "label" => "cambiar a mayuscula titulo contenido",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "contentCategoryEnable" => [
            "name" => "contentCategoryEnable",
            "value" => "false",
            "type" => "select",
            "props" => [
              "label" => "contenido de categoria habilitado",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "contentCategoryFontSize" => [
            "name" => "contentCategoryFontSize",
            "type" => "input",
            "props" => [
              "label" => "tamaño letra contenido categoria",
              "type" => "number"
            ]
          ],
          "contentCategoryToUppercase" => [
            "name" => "contentCategoryToUppercase",
            "value" => "true",
            "type" => "select",
            "props" => [
              "label" => "cambiar a mayuscula contenido categoria",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "contentPriceFontSize" => [
            "name" => "contentPriceFontSize",
            "type" => "input",
            "props" => [
              "label" => "tamaño letra del precio contenido",
              "type" => "number"
            ]
          ],
          "contentPriceFontWeight" => [
            "name" => "contentPriceFontWeight",
            "type" => "input",
            "props" => [
              "label" => "negrita de precio contenido"
            ]
          ],
          "bottomFontSize" => [
            "name" => "bottomFontSize",
            "type" => "input",
            "props" => [
              "label" => "tamaño letra boton",
              "type" => "number"
            ]
          ],
          "parentAttributes" => [
            "name" => "parentAttributes",
            "type" => "input",
            "props" => [
              "label" => "atributos padre"
            ]
          ],
          "productBackgroundColor" => [
            "name" => "productBackgroundColor",
            "type" => "inputColor",
            "props" => [
              "label" => "color fondo de producto"
            ]
          ],
          "ribbonBackgroundColor" => [
            "name" => "ribbonBackgroundColor",
            "type" => "inputColor",
            "props" => [
              "label" => "fondo de color de cinta"
            ]
          ],
          "ribbonTextColor" => [
            "name" => "ribbonTextColor",
            "type" => "inputColor",
            "props" => [
              "label" => "color texto de cinta"
            ]
          ],
          "contentTitleFontWeight" => [
            "name" => "contentTitleFontWeight",
            "type" => "input",
            "props" => [
              "label" => "negrita de contenido titulo"
            ]
          ],
          "contentCategoryFontWeight" => [
            "name" => "contentCategoryFontWeight",
            "type" => "input",
            "props" => [
              "label" => "negrita de contenido categoria"
            ]
          ],
        ]
      ]
    ]
  ]
];
