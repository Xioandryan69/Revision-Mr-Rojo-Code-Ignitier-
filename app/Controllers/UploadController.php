<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Files\UploadedFile;
class UploadController extends BaseController
{
    public function index(): string
    {
        return view('upload/index');
    }
    public function uploadFile(UploadedFile $file): ?string
    {
        if ($file->isValid() && !$file->hasMoved()) {
            // Génère un nom unique (ex: 171829381_a8f3d.mp4)
            $nomUnique = $file->getRandomName();
            // Déplace vers le répertoire public/uploads/
            $file->move(FCPATH . 'uploads/', $nomUnique);
            return $nomUnique;
        }
        return null;
    }
    public function uploadMedia()
    {
        //1 mo-> 1024 ko
        $rules = [
            'fichier' => [
                'rules' => [
                    'uploaded[fichier]',
                    'max_size[fichier,20480]',
                    'mime_in[fichier,image/jpeg,image/png,image/webp,video/mp4,video/webm,video/quicktime,video/x-msvideo,video/x-matroska]',
                ],
                'errors' => [
                    'uploaded' => 'Veuillez sélectionner un fichier.',
                    'max_size' => 'Le fichier est trop volumineux (Maximum 20 Mo).',
                    'mime_in' => 'Type de fichier non autorisé (JPG, PNG, WEBP, MP4, WEBM, MOV,AVI, MKV).',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        }
        $file = $this->request->getFile('fichier');


        $nomUnique = $this->uploadFile($file);
        if ($nomUnique) {
            return redirect()->back()->with('success', 'Fichier téléversé ! Nom unique : ' . $nomUnique);
        }

        return redirect()->back()->with('error', 'Échec du téléversement ou du déplacement du fichier.');


    }
}
//mkdir -p public/uploads
//www-data web
//sudo chown -R www-data:www-data public/uploads
//sudo chown -R andrianandrainy:andrianandrainy public/uploads
//sudo chmod 775 public/uploads 


//   /etc/php/8.x/cli/php.ini
# et si vous utilisez Apache :
//  /etc/php/8.x/apache2/php.ini

//manaova backup

//cherchez ces 3 lignes et transformez misy limit
// upload_max_filesize = 50M
// post_max_size = 55M
// memory_limit = 128M