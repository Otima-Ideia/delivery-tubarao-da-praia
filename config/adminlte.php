<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Tubarão',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<img src="/img/logo.png" style="max-height: 50px;" />',

    'logo_mini' => '<b>T</b>P',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'purple',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'admin/dashboard',

    'logout_url' => 'admin/logout',

    'logout_method' => null,

    'login_url' => 'admin/login',

    'register_url' => null,

    'password_reset_url' => 'admin/password/reset',

    'password_email_url' => 'admin/password/email',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'NAVEGAÇÃO PRINCIPAL',
        [
            'text'  => 'Dashboard',
            'route' => 'admin.dashboard.index',
            'icon'  => 'dashboard', 
            'can'   => 'admin',
        ],
        [
            'text'  => 'Acompanhar Entregas',
            'route' => 'admin.deliverymantime.index',
            'icon'  => 'fa fa-motorcycle',
            'can'   => 'admin',
        ],   
        [
            'text'  => 'Caixa',
            'route' => 'admin.cashier.index',
            'icon'  => 'fa fa-line-chart',
            'can'   => 'admin',
        ],[
            'text'  => 'Mesas',
            'route' => 'admin.table.index',
            'icon'  => 'fa fa-line-chart',
            'can'   => 'admin',
        ],
        [
            'text'  => 'Relatórios',
            'route' => 'admin.reports.index',
            'icon'  => 'fa fa-line-chart',
            'can'   => 'admin',
        ],
        [
            'text'  => 'Ofertas',
            'route' => 'admin.offers.index',
            'icon'  => 'money',
            'can'   => 'admin'
        ],
        [
            'text'  => 'Clientes',
            'route' => 'admin.clients.index',
            'icon'  => 'users',
            'can'   => 'admin'
        ],
        [
            'text'  => 'Cupons',
            'route' => 'admin.cupom.validation',
            'icon'  => 'ticket',
        ],
        [
            'text'  => 'Cupons validados',
            'route' => 'admin.cupom.validated',
            'icon'  => 'fas fa-check',
            'can'   => 'admin',
        ],
        [
            'text'  => 'Lojas',
            'route' => 'admin.lojas.index',
            'icon'  => 'fas fa-home',
            'can'   => 'admin',
            'submenu'     => [
                [
                    'text'  => 'Lojas',
                    'route' => 'admin.lojas.index',
                    'icon'  => 'fas fa-home',
                ],
                [
                    'text'  => 'Métodos de Pagamento',
                    'route' => 'admin.paymentmethod.index',
                    'icon'  => 'fas fa-credit-card',
                ],
                [
                    'text'  => 'Pagamento por Loja',
                    'route' => 'admin.lojapaymentmethod.index',
                    'icon'  => 'fas fa-credit-card',
                ],
                [
                    'text'  => 'Taxa de entrega',
                    'route' => 'admin.ordertax.index',
                    'icon'  => 'fa fa-money',
                ],
                [
                    'text'  => 'Configurações de Entrega',
                    'route' => 'admin.lojadeliveryconfig.index',
                    'icon'  => 'fa fa-motorcycle',
                ]
            ]
        ],
        [
            'text'  => 'Usuarios',
            'route' => 'admin.users.index',
            'icon'  => 'fas fa-user',
            'can'   => 'admin',
        ],
        [
            'text' => 'Produtos',
            'icon' => 'fas fa-tag',
            'can'   => 'admin',
            'submenu'     => [
                [
                    'text'  => 'Produtos',
                    'route' => 'admin.products.index',
                    'icon'  => 'fas fa-tag',
                ],
                [
                    'text'  => 'Complementos',
                    'route' => 'admin.complements.index',
                    'icon'  => 'fas fa-tags',
                ],
                [
                    'text'  => 'Categoria de Produto',
                    'route' => 'admin.pcategories.index',
                    'icon'  => 'fas fa-tags',
                ],
                [
                    'text'  => 'Banner de Promoção',
                    'route' => 'admin.banner.index',
                    'icon'  => 'fas fa-certificate',
                ],
                [
                    'text'  => 'Custos',
                    'route' => 'admin.prodcosts.index',
                    'icon'  => 'fa fa-money',
                ]
            ]
        ],
        [
            'text' => 'Pedidos',
            'icon' => 'fa fa-list-alt',
            'submenu'     => [
                [
                    'text'  => 'Pedidos',
                    'route' => 'admin.orders.index',
                    'icon'  => 'fa fa-list-alt',
                ],
                [
                    'text'  => 'Status de Pedido',
                    'route' => 'admin.orderstatus.index',
                    'icon'  => 'far fa-eye',
                    'can'   => 'admin',
                ],
                [
                    'text'  => 'Tempo Atualização Status',
                    'route' => 'admin.orderstime.index',
                    'icon'  => 'far fa-eye',
                    'can'   => 'admin',
                ]
            ]
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        //JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
    ],
];
