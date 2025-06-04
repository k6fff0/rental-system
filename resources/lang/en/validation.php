<?php

return [
    'custom' => [
        'name' => [
            'required' => 'Please enter your name.',
            'unique' => 'This name is already taken.',
        ],
        'phone' => [
            'unique' => 'This phone number is already taken.',
        ],
        'email' => [
            'unique' => 'This email address is already taken.',
        ],
    ],

    'attributes' => [
        'name' => 'name',
        'email' => 'email address',
        'phone' => 'phone number',
    ],
];
