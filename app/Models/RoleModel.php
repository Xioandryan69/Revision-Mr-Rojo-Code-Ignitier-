<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = "Role";

    protected $primaryKey = 'id';

    protected $allowFields = ['name'];


}
