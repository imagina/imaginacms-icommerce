<style>
    .checkout-tabs .cursor-pointer {
        cursor: pointer;
    }
    .checkout-tabs .guest {
        position: relative;
    }
    .checkout-tabs .guest:before {
        width: 100%;
        height: 100%;
        background-color: transparent;
        content: '';
        position: absolute;
    }
    .checkout-tabs .form-control {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        height: auto !important;
    }
    .checkout-tabs .ckeckout-subtitle {
        font-size: 1.125rem;
        color: var(--primary);
    }
    .checkout-tabs .item_carting-product-name {
        font-size: 0.938rem;
    }
    .checkout-tabs .item_carting-product-price {
        font-size: 0.875rem;
        font-weight: 500;
    }
    .checkout-tabs label {
        font-weight: 600;
        font-size: 14px;
    }
    .checkout-tabs .quantity-group {
        width: 100px;
    }
    .checkout-tabs .quantity-group .input-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    .checkout-tabs .quantity-group .input-group .btn-outline-primary {
        color: #444;
        background-color: #D9D9D9;
        border-color: #D9D9D9;
        font-weight: bold;
    }
    .checkout-tabs .quantity-group .input-group .btn-outline-primary:hover {
        color: #444;
        background-color: #c6c6c6;
        border-color: #c0bfbf;
    }
    .checkout-tabs .quantity-group .input-group .border-primary {
        border-color: #D9D9D9 !important;
        background-color: #D9D9D9 !important;
        font-weight: bold;
        text-align: center;
    }
    .checkout-tabs .cart-remove .fa {
        font-size: 15px;
        display: flex;
        cursor: pointer;
    }
    .checkout-tabs .wizard-checkout .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    .checkout-tabs .wizard-checkout .nav-tabs > li > a {
        color: #777;
        border: 0;
        font-size: 0.9375rem;
    }
    .checkout-tabs .wizard-checkout .nav-tabs > li > a .round-tab {
        display: inline-flex;
        background-color: #777;
        color: #fff;
        width: 40px;
        height: 40px;
        font-size: 0.9375rem;
        font-weight: bold;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
    }
    .checkout-tabs .wizard-checkout .nav-tabs > li.active > a, .checkout-tabs .wizard-checkout .nav-tabs > li.active > a:hover, .checkout-tabs .wizard-checkout .nav-tabs > li.active > a:focus {
        color: var(--primary);
        font-weight: 600;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }
    .checkout-tabs .wizard-checkout .nav-tabs > li.active > a .round-tab, .checkout-tabs .wizard-checkout .nav-tabs > li.active > a:hover .round-tab, .checkout-tabs .wizard-checkout .nav-tabs > li.active > a:focus .round-tab {
        background-color: var(--primary);
    }
    @media (max-width: 1200px) {
        .checkout-tabs .wizard-checkout .nav-tabs > li > a .round-tab {
            display: flex;
            margin: 0 auto 0.5rem auto;
        }
        .checkout-tabs .wizard-checkout .nav-tabs > li > a {
            text-align: center;
            padding: 0;
        }
    }
    .checkout-tabs .wizard-checkout .card-customer .border-top-dotted {
        display: none;
    }
    .checkout-tabs .wizard-checkout .collapse.show {
        border-top: 1px solid var(--primary);
    }
    .checkout-tabs .wizard-checkout .next-step {
        background-color: var(--primary);
        border-color: var(--primary);
        min-height: 38px;
    }
    .checkout-tabs .wizard-checkout .start-step, .checkout-tabs .wizard-checkout .prev-step {
        min-height: 38px;
    }
    .checkout-tabs .ckeckout-subtitle-primary {
        background-color: var(--primary);
        color: #fff;
        text-align: center;
        padding: 0.5rem 1rem;
        margin: 0.5rem 0;
        font-size: 1.2rem;
    }
    .checkout-tabs .checkout-login input[type="submit"], .checkout-tabs .checkout-register input[type="submit"] {
        display: block;
        text-align: center;
        margin: 0 auto 20px auto !important;
        font-size: 13px;
    }
    .checkout-tabs #imgProfile img {
        height: 150px;
        width: auto;
        object-fit: contain;
        border-radius: 0.25rem;
    }
    .custom-title-alert {
      text-align: left;
    }
    /***/
    .checkout-tabs .card-number-text {
      flex-flow: nowrap;
    & .number-check {
        background-color: var(--primary);
        color: #ffffff;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-weight: bold;
      }
    }

    .checkout-tabs .card-header .image {
      max-height: 90px; width: auto; max-width: 60%; object-fit: contain;
    }
    .checkout-tabs .product-title {
      color: var(--primary) !important;
    }
    .checkout-tabs .quantity-selector input[type=number]::-webkit-outer-spin-button,
    .checkout-tabs .quantity-selector input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    .checkout-tabs .quantity-selector input[type=number] {
      -moz-appearance:textfield !important;
    }
    .checkout-tabs .quantity-field {
      text-align: center;
      height: 25px !important;
      border: 1px solid rgba(82, 81, 81, 16%);
      box-sizing: border-box;
      margin: 0;
      outline: none;
      padding: 0 10px;
      line-height: 25px;
      font-size: 12px;
      font-weight: bold;
      width: 75px;
    }
    .checkout-tabs .quantity-selector .button-minus {
      border-radius: 24px 0 0 24px;
    }
    .checkout-tabs .quantity-selector .button-plus {
      border-radius: 0 24px 24px 0;
    }
    .checkout-tabs .quantity-selector .button-minus,
    .checkout-tabs .quantity-selector .button-plus {
      font-size: 10px;
      color: var(--primary);
      border: 1px solid rgba(82, 81, 81, 16%);
      background: transparent;
      box-sizing: border-box;
      margin: 0;
      outline: none;
      padding: 0 10px;
      text-align: center;
      height: 25px;
      line-height: 25px;
      flex: unset;
    &  i {
         pointer-events: none;
       }
    }
    .checkout-tabs .price-text {
      font-size: 12px;
    }
    .checkout-tabs .img-product-cart {
      color: var(--primary);
      font-size: 10px;
    }
    .checkout-tabs #customerData {
      text-align: center;
    & #imgProfile {
        margin-bottom: 1rem !important;
      }
    }
    .checkout-tabs .text-quantity {
      font-size: 13px
    }
    .checkout-tabs .button-remove {
      width: 20px;
      position: absolute;
      right: -7px;
      top: 0;
    & .cart-remove {
        font-size: 1rem;
      }
    }
    .checkout .btn-link, .checkout .btn-link:hover {
      color: var(--primary) !important;
    }
    .checkout-tabs .text-title .title {
      font-size: 2rem;
    }
    .checkout-tabs .btn-primary-ecommerce {
      background-color: var(--primary);
      border-color: var(--primary);
      color: #fff;
    }
</style>