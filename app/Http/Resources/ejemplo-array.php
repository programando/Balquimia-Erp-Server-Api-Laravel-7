<?php

 

$test = [
    'number' => 990000096,
    'type_document_id' => 1,
    'customer' => [
        'identification_number' => 1094925334,
        'name' => 'Frank Aguirre',
        'phone' => 3060606,
        'address' => 'CALLE 47 42C 24',
        'email' => 'faguirre@soenac.com',
        'merchant_registration' => 'No tiene'
    ],
    'legal_monetary_totals' => [
        'line_extension_amount' => '300000.00',
        'tax_exclusive_amount' => '300000.00',
        'tax_inclusive_amount' => '357000.00',
        'allowance_total_amount' => '0.00',
        'charge_total_amount' => '0.00',
        'payable_amount' => '357000.00'
    ],
];

$lines = [];

// FOR

// Item 1
$line1 = [];
$line1['unit_measure_id'] = 642;
$line1['invoiced_quantity'] = '1.000000';
$line1['line_extension_amount'] = '300000.00';
$line1['free_of_charge_indicator'] = false;

$impuesto1 = [
    'tax_id' => 1,
    'tax_amount' => '57000.00',
    'taxable_amount' => '300000.00',
    'percent' => '19.00'
];

$impuesto2 = [
    'tax_id' => 2,
    'tax_amount' => '57000.00',
    'taxable_amount' => '300000.00',
    'percent' => '19.00'
];

$line1['tax_totals'][] = $impuesto1;
$line1['tax_totals'][] = $impuesto2;

// Item 2
$line2 = [];
$line2['unit_measure_id'] = 642;
$line2['invoiced_quantity'] = '1.000000';
$line2['line_extension_amount'] = '300000.00';
$line2['free_of_charge_indicator'] = false;

// $impuesto1 = [
//     'tax_id' => 1,
//     'tax_amount' => '57000.00',
//     'taxable_amount' => '300000.00',
//     'percent' => '19.00'
// ];

// $line2['tax_totals'][] = $impuesto1;

$lines[] = $line1;
$lines[] = $line2;

// FOR END

$test['invoice_lines'] = $lines;

echo json_encode($test);
