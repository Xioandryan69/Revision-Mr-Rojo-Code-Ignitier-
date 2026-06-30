<?php 
namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table ="Role";
    
    protected $primaryKey='id';

    protected $allowFields=['name'];

    protected $validationRules=[
        'name'=>[
            'label'=>'Nom du role',
            'rules'=>'required|min_length[3]|is_unique[Role.name.id,{id}]',
            'errors'=>[
                'required'=>'Le champ {field} est obligatoire ',
                'min_length'=>'Le {field} doit contenir au moins {param} caractere ',
                'is_unique' => 'Ce nom de role exciste deja'
            ]
        ]
    ];

    protected $skipValidation=false;


}
