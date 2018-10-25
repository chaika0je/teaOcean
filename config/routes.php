<?php

return array(
    '^$' => 'site/index',

    '^catalog$' => 'catalog/catalog',
    '^catalog/([a-z]+)$' => 'catalog/section/$1',                       //пилим
    '^catalog/([a-z]+)/([0-9]+)$' => 'catalog/category/$1/$2',

    '^product/([0-9]+)$' => 'catalog/product/$1',

    '^admin$' => 'admin/login',

    '^panel$' => 'admin/index',
    '^panel/category$' => 'admin/viewCategory',
    '^panel/subcategory$' => 'admin/viewSubcategory',
    '^panel/product$' => 'admin/viewProducts',
    '^panel/main$' => 'admin/viewMain',
    '^panel/orders$' => 'admin/viewOrders',
    '^panel/orders/([0-9]+)$' => 'admin/editOrder/$1',
    '^panel/users$' => 'admin/viewUsers',
    '^panel/sendmail$' => 'admin/sendMail',
    '^panel/edit/([0-9]+)$' => 'admin/editProduct/$1',
    '^panel/settings$' => 'admin/viewSettings',
    '^panel/callbacks$' => 'admin/viewCallbacks',

    '^reg$' => 'site/register',
    '^reg/success$' => 'site/successReg',
    '^auth$' => 'site/auth',

    '^account$' => 'site/account',

    '^cart$' => 'cart/cart',
    '^cart/delete/([0-9]+)' => 'cart/delFromCart/$1',
    '^cart/success$' => 'cart/success',

    '^order$' => 'order/order',

    '^search$' => 'site/search',

    '^delivery$' => 'site/delivery'
);
