<?php 
namespace App\Model;

use codeIgnitier\Model;

class RoleModel extends Model
{
    protected $table ="Role";
    
    protected $primaryKey='id';

    protected $allowFields=['name'];


}
