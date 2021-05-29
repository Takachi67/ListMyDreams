<?php

return [
    'border_color' => [
        'max' => 'There is too many characters in the border color field.',
        'required' => 'A border color is required.',
        'string' => 'A border color must be in string format.'
    ],
    'category' => [
        'in' => 'The category field isn\'t in the acceptable list.',
        'required' => 'A category is required.',
        'string' => 'A category must be in string format.'
    ],
    'email' => [
        'email' => 'The email field doesn\'t match the required format.',
        'required' => 'An email is required.',
        'string' => 'An email must be in string format.'
    ],
    'items' => [
        'array' => 'The items field isn\'t an array.',
        'comment' => [
            'string' => 'The item comment field must be in string format.'
        ],
        'link' => [
            'required' => 'The item link field is required.',
            'string' => 'The item link field must be in string format.'
        ],
        'min' => 'There must be at least one object in your list.',
        'name' => [
            'max' => 'There is too many characters in the item name field.',
            'required' => 'The item name field is required.',
            'string' => 'The item name field must be in string format.'
        ],
        'priority' => [
            'in' => 'The item priority field isn\'t in the acceptable list.',
            'max' => 'There is too many characters in the item priority field.',
            'required' => 'The item priority field is required.',
            'string' => 'The item priority field must be in string format.'
        ],
        'required' => 'There must be at least one object in your list.'
    ],
    'line_color' => [
        'max' => 'There is too many characters in the line color field.',
        'required' => 'A line color is required.',
        'string' => 'A line color must be in string format.'
    ],
    'name' => [
        'max' => 'There is too many characters in the name field.',
        'required' => 'A name is required.',
        'string' => 'A name must be in string format.'
    ],
    'nickname' => [
        'required' => 'A nickname is required.',
        'unique' => 'This nickname already exists.'
    ],
    'password' => [
        'confirmed' => 'The password confirmation doesn\'t match.',
        'min' => 'The password must contains 6 characters minimum.',
        'string' => 'The password field must be in string format.'
    ],
    'picture' => [
        'image' => 'The picture isn\'t an image.'
    ],
    'sharing_type' => [
        'in' => 'The sharing type field isn\'t in the acceptable list.',
        'required' => 'The sharing type field is required.',
        'string' => 'The sharing type field must be in string format.'
    ],
    'text_color' => [
        'max' => 'There is too many characters in the text color field.',
        'required' => 'A text color is required.',
        'string' => 'A text color must be in string format.'
    ]
];
