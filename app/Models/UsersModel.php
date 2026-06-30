<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role_id'
    ];

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Le nom d\'utilisateur est obligatoire.',
            'min_length' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères.'
        ],
        'email' => [
            'required' => 'L\'email est obligatoire.',
            'valid_email' => 'Adresse email invalide.',
            'is_unique' => 'Cet email existe déjà.'
        ],
        'password' => [
            'required' => 'Le mot de passe est obligatoire.',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.'
        ],
        'role_id' => [
            'required' => 'Le rôle est obligatoire.',
            'integer' => 'Le rôle est invalide.'
        ]
    ];

    protected $skipValidation = false;
}