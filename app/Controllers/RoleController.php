<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RoleController extends BaseController
{
    public function create()
    {
        // 1. Récupérer les données JSON de la requête AJAX
        $data = $this->request->getJSON(true);

        // 2. Définir les règles de validation ici (au chargement)
        $rules = [
            'name' => 'required|min_length[3]|is_unique[Role.name]'
        ];

        $messages = [
            'name' => [
                'required'   => 'Le champ Nom du rôle est obligatoire.',
                'min_length' => 'Le Nom du rôle doit contenir au moins 3 caractères.',
                'is_unique'  => 'Ce nom de rôle existe déjà.'
            ]
        ];

        // 3. Exécuter la validation sur les données reçues
        if (! $this->validateData($data, $rules, $messages)) {
            // Si ça échoue, on renvoie directement les erreurs en JSON
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validation échouée au chargement.',
                'errors'  => $this->validator->getErrors()
            ])->setStatusCode(422);
        }

        // 4. Si la validation passe, on peut insérer en toute sécurité
        $roleModel = new RoleModel();
        $roleModel->skipValidation(true)->insert($data); // On saute la validation du modèle puisqu'elle est faite !

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Le rôle a été validé et créé avec succès !'
        ]);
    }
    public function index()
    {
        return view('role/index'); // Va chercher le fichier dans app/Views/role/index.php
    }
}