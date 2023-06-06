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

</style>