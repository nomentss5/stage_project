<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;

class ImageController extends Controller
{
    public function extract()
    {
        $pdfPath = storage_path('app/public/CV.pdf'); // Chemin vers votre fichier PDF
        $outputPath = public_path('images'); // Chemin vers le répertoire où enregistrer les images

        // Assurez-vous que le répertoire de sortie existe
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0777, true);
        }

        $imagick = new Imagick();
        $imagick->readImage($pdfPath);

        foreach ($imagick as $index => $page) {
            $page->setImageFormat('jpeg');
            $pagePath = $outputPath . '/page_' . $index . '.jpg';
            $page->writeImage($pagePath);
        }

        $imagick->clear();
        $imagick->destroy();

        return 'Images extracted successfully!';
    }
}