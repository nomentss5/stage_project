<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

use App\Models\Cv;

class CvController extends Controller
{
    public function uploadCv(Request $request){
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg|max:2048',
        ]);

        $file = $request->file('cv');
        // prendre timestamp et associer avec le nom de fichier ex:12654_cv.pdf
        $fileName = time().'_'.$file->getClientOriginalName();
        // specifier le repertoire du fichier
        $filePath = $file->storeAs('cvs/', $fileName, 'public');

        CV::create([
            'file_name' => $fileName,
            'file_path' => '/storage/' . $filePath, $filePath,
        ]);

        // dump("vita ny insertion");
        return redirect()->route('showListeCv')->with('success', 'CV uploaded successfully.');
    } 

    public function cv_liste(){
        $liste = Cv::all();
        return view('Affichage.list_cv', compact('liste'));
    }
}
