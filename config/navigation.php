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
                ['name' => 'file_costs', 'route' => 'files.costs.index', 'icon' => 'costs'],
                // ['name' => 'Supplier Invoices', 'route' => 'supplier-invoices.index', 'icon' => 'invoices'],
                // ['name' => 'Credit Notes', 'route' => 'supplier-credit-notes.index', 'icon' => 'credit-notes'],
            ],
        ],
        [
            'title' => 'accounting',
            'items' => [
                // ['name' => 'Payments', 'route' => 'payments.index', 'icon' => 'payments'],
                // ['name' => 'Receipts', 'route' => 'receipts.index', 'icon' => 'receipts'],
                ['name' => 'reports', 'route' => 'reports.index', 'icon' => 'reports'],
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
