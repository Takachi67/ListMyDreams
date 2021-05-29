<?php

return [
    'border_color' => [
        'max' => 'Il y a trop de caractères dans la couleur de bordure.',
        'required' => 'Il manque la couleur de bordure.',
        'string' => 'La couleur de bordure n\'est pas au bon format.'
    ],
    'category' => [
        'in' => 'La catégorie ne correspond à aucun de nos choix.',
        'required' => 'Il manque une catégorie.',
        'string' => 'La catégorie n\'est pas au bon format.'
    ],
    'email' => [
        'email' => 'L\'email n\'est pas au bon format.',
        'required' => 'Il manque une adresse email.',
        'string' => 'L\'email n\'est pas au bon format.'
    ],
    'items' => [
        'array' => 'La liste des objets n\'est pas un tableau.',
        'comment' => [
            'string' => 'Le commentaire d\'un objet n\'est pas au bon format.'
        ],
        'link' => [
            'required' => 'Il manque le lien d\'un objet.',
            'string' => 'Le lien d\'un objet n\'est pas au bon format.'
        ],
        'min' => 'Il doit y avoir au moins un objet dans ta liste.',
        'name' => [
            'max' => 'Il y a trop de caractères dans le nom d\'un objet.',
            'required' => 'Il manque le nom d\'un objet.',
            'string' => 'Le nom d\'un objet n\'est pas au bon format.'
        ],
        'priority' => [
            'in' => 'La priorité d\'un objet ne correspond à aucun de nos choix.',
            'max' => 'Il y a trop de caractères dans la priorité d\'un objet.',
            'required' => 'Il manque la priorité d\'un objet.',
            'string' => 'La priorité d\'un objet n\'est pas au bon format.'
        ],
        'required' => 'Il doit y avoir au moins un objet dans ta liste.'
    ],
    'line_color' => [
        'max' => 'Il y a trop de caractères dans la couleur de ligne.',
        'required' => 'Il manque une couleur de ligne.',
        'string' => 'La couleur de ligne n\'est pas au bon format.'
    ],
    'name' => [
        'max' => 'Il y a trop de caractères dans le nom.',
        'required' => 'Il manque un nom.',
        'string' => 'Le nom n\'est pas au bon format.'
    ],
    'nickname' => [
        'required' => 'Il manque un pseudo.',
        'unique' => 'Ce pseudo est déjà pris.'
    ],
    'password' => [
        'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        'min' => 'Le mot de passe doit contenir 6 caractères minimum.',
        'string' => 'Le mot de passe n\'est pas au bon format.'
    ],
    'picture' => [
        'image' => 'L\'image n\'est pas au bon format.'
    ],
    'sharing_type' => [
        'in' => 'Le type de partage ne correspond à aucun de nos choix.',
        'required' => 'Il manque un type de partage.',
        'string' => 'Le type de partage n\'est pas au bon format.'
    ],
    'text_color' => [
        'max' => 'Il y a trop de caractères dans la couleur de texte.',
        'required' => 'Il manque une couleur de texte.',
        'string' => 'La couleur de texte n\'est pas au bon format.'
    ]
];
