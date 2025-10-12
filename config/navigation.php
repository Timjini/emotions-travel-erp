<?php

return [
    'sections' => [
        [
            'title' => 'front_office',
            'items' => [
                ['name' => 'customers', 'route' => 'customers.index', 'icon' => 'users'],
                ['name' => 'files', 'route' => 'files.index', 'icon' => 'files'],
                ['name' => 'proformas', 'route' => 'proformas.index', 'icon' => 'profomas'],
                ['name' => 'client_invoices', 'route' => 'invoices.index', 'icon' => 'invoices'],
                // ['name' => 'Credit Notes', 'route' => 'credit-notes.index', 'icon' => 'credit-notes'],
            ],
        ],
        [
            'title' => 'back_office',
            'items' => [
                ['name' => 'suppliers', 'route' => 'suppliers.index', 'icon' => 'suppliers'],
                // ['name' => 'file_costs', 'route' => 'file-costs.index', 'icon' => 'costs'],
                // ['name' => 'Supplier Invoices', 'route' => 'supplier-invoices.index', 'icon' => 'invoices'], get invoice from email and save to database.
                // ['name' => 'Credit Notes', 'route' => 'supplier-credit-notes.index', 'icon' => 'credit-notes'],
                // over payment / hotel or service cancelled and they should pay / 
                // get it as a credit with the service.
            ],
        ],
        [
            'title' => 'accounting',
            'items' => [
                // ['name' => 'Payments', 'route' => 'payments.index', 'icon' => 'payments'], // what I paid the services. 
                // ['name' => 'Receipts', 'route' => 'receipts.index', 'icon' => 'receipts'], // get the receipt of the customer by email 
                // usual customer get directly from invoice. flag with (trust payment) 
                ['name' => 'reports', 'route' => 'reports.index', 'icon' => 'reports'],
                ['name' => 'Analytics', 'route' => 'analytics.index', 'icon' => 'analytics'],
            ],
        ],
        [
            'title' => 'settings',
            'items' => [
                ['name' => 'destinations', 'route' => 'destinations.index', 'icon' => 'destinations'],
                ['name' => 'currencies', 'route' => 'currencies.index', 'icon' => 'currencies'],
                ['name' => 'programs', 'route' => 'programs.index', 'icon' => 'programs'],
                // ['name' => 'Program Types', 'route' => 'program-types.index', 'icon' => 'program-types'],
                // ['name' => 'Third Category', 'route' => 'third-category.index', 'icon' => 'category'],
                ['name' => 'system', 'route' => 'company.system.index', 'icon' => 'system'],
            ],
        ],
    ],
];
