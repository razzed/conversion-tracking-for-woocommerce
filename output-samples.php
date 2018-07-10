<?php
/**
 * @package conversion-tracking-for-woocommerce
 * @subpackage samples
 * @author kent
 * @copyright &copy; 2018 Market Acumen, Inc.
 */

die("Nope.");
?>
<script>
/* conversion-tracking-for-woocommerce */
(function (w) {
w.WCPAYLOAD = {
    "type": "checkout",
    "cart": {
        "is_empty": false,
        "coupons": [
            "promo2018"
        ],
        "subtotal": 239.97,
        "total": 0,
        "shipping": 0,
        "taxes": 0,
        "currency": "USD",
        "items": [
            {
                "id": 1005,
                "name": "Large Widget",
                "link": "https:\/\/www.example.com\/product\/widget\/?attribute_select-a-size=Large",
                "description": "",
                "price": 99.99,
                "variation_id": 1005,
                "quantity": 1,
                "tax": 0,
                "total": 0
            },
            {
                "id": 1000,
                "name": "Small Widget",
                "link": "https:\/\/www.example.com\/product\/widget\/?attribute_select-a-size=Small",
                "description": "",
                "price": 69.99,
                "variation_id": 1000,
                "quantity": 2,
                "tax": 0,
                "total": 0
            }
        ]
    },
    "customer": {
        "id": 7,
        "email": "letitia@example.com",
        "name_first": "Letitia",
        "name_last": "Doe"
    }
};
}(window));
</script>

<script>
/* conversion-tracking-for-woocommerce */
(function (w) {
w.WCPAYLOAD = {
    "order": {
        "id": "1028",
        "total": 0,
        "subtotal": 99.99,
        "shipping": 0,
        "taxes": 0,
        "coupons": [
            "promo2018"
        ],
        "items": [
            {
                "id": 1005,
                "name": "Large Widget",
                "link": "https:\/\/www.example.com\/product\/widget\/?attribute_select-a-size=Large",
                "description": "",
                "price": 99.99,
                "quantity": 1,
                "variation_id": 1005,
                "subtotal": 99.99,
                "total": 0,
                "tax": 1
            }
        ]
    },
    "payment": {
        "currency": "USD",
        "method": ""
    },
    "customer": {
        "id": 7,
        "email": "raoul@example.com",
        "name_first": "Raoul",
        "name_last": "Fakelastname"
    },
    "type": "order-confirmation"
};
}(window));
</script>
