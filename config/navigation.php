<?php
return [
    'sections' => [
        [
            'title' => 'front_office',
            'items' => [
                ['name' => 'customers', 'route' => 'customers.index', 'icon' => 'clients'],
                ['name' => 'files', 'route' => 'files.index', 'icon' => 'files'],
                // ['name' => 'Profomas', 'route' => 'profomas.index', 'icon' => 'profomas'],
                // ['name' => 'Client Invoices', 'route' => 'client-invoices.index', 'icon' => 'invoices'],
                // ['name' => 'Credit Notes', 'route' => 'credit-notes.index', 'icon' => 'credit-notes'],
            ],
        ],
        [
            'title' => 'back_office',
            'items' => [
                // ['name' => 'Suppliers', 'route' => 'suppliers.index', 'icon' => 'suppliers'],
                // ['name' => 'File Costs', 'route' => 'file-costs.index', 'icon' => 'costs'],
                // ['name' => 'Supplier Invoices', 'route' => 'supplier-invoices.index', 'icon' => 'invoices'],
                // ['name' => 'Credit Notes', 'route' => 'supplier-credit-notes.index', 'icon' => 'credit-notes'],
            ],
        ],
        [
            'title' => 'accounting',
            'items' => [
                // ['name' => 'Payments', 'route' => 'payments.index', 'icon' => 'payments'],
                // ['name' => 'Receipts', 'route' => 'receipts.index', 'icon' => 'receipts'],
                // ['name' => 'Basic Reports', 'route' => 'basic-reports.index', 'icon' => 'reports'],
            ],
        ],
        [
            'title' => 'settings',
            'items' => [
                // ['name' => 'Destinations', 'route' => 'destinations.index', 'icon' => 'destinations'],
                // ['name' => 'Program Types', 'route' => 'program-types.index', 'icon' => 'program-types'],
                // ['name' => 'Third Category', 'route' => 'third-category.index', 'icon' => 'category'],
                // ['name' => 'System', 'route' => 'system.index', 'icon' => 'system'],
            ],
        ],
    ],
];