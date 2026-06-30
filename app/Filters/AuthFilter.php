<?php
namespace App\Filters;
use App\Models\UsersModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use  App\Models\RoleModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request ,$arguments =null)
    {
        $session = session();

        if(!$session->get('logged_in'))
        {
            return redirect()->to('/login')->with('error','Vous devez vous connecter.');
        }
        if(!empty($arguments))
            {
            
                $userId=$session->get('id');
                $user= new UsersModel();
                $userRole= $user->getRole($userId);
                if(!in_array($userRole,$arguments)){
                    return redirect()->to('/dashboard')->with('error', 'Accès non autorisé.');
                }
            }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response,$arguments= null)
    {

    }
}