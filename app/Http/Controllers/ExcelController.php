<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abonnement;
use App\Models\localite;
use App\Models\secteur;
use App\Models\user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

// use Rap2hpoutre\FastExcel\FastExcel; // La classe FastExcel
// use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;


// Importation de SheetCollection
use Rap2hpoutre\FastExcel\SheetCollection; // La collection de feuilles


class ExcelController extends Controller
{
    public function imprimer(Request $request)
    {
        // dd($request); donneeimprim  coltitre  coldata
        // dd(session());
        try {
            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $labonne = $idabonnement != null ? collect(DB::select(" SELECT * FROM abonnements WHERE id = '" . $idabonnement . "' "))->first() : null;
            $donneeimprim = session('donneeimprim') != null ? session('donneeimprim') : array();
            $coltitre = session('coltitre') != null ? session('coltitre') : '';
            $coldata = session('coldata') != null ? session('coldata') : '';
            //  dd($donneeimprim);

            // $fastexcel = new FastExcel($donneeimprim); // L'instance Fast Excel
            $fastexcel = fastexcel($donneeimprim); // L'instance Fast Excel

// Exportation vers le fichier "/public/users.xlsx"
        // $chemin = $fastexcel->export("test.xlsx");

        // Exportation vers le fichier "/public/users.csv"
        // $chemin = $fastexcel->export("users.csv");

        // Exportation vers le fichier "/public/users.ods"
        // $chemin = $fastexcel->export("users.ods");
        
//         // Téléchargement du fichier "users.xlsx"
// return $fastexcel->download('users.xlsx');

        // Collection "App\Models\User";
        $users = User::select('id', 'login', 'email')->get();

        // Collection "App\Models\Post"
        $abonnements = abonnement::orderBy("created_at")->get();

        // Collection "App\Models\Product"
        $secteurs = secteur::orderBy('libelle')->get();

        // Collection des feuilles de calcul (SheetCollection)
        $sheets = new SheetCollection([
            "Utilisateurs" => $users,
            "Abonnements" => $abonnements,
            "Secteurs" => $secteurs
        ]);

        // Exportation des feuilles de calcul vers "/public/users-posts-products.xlsx"
        //  $chemin = (fastexcel($sheets))->export("users-posts-products.xlsx");
       // return (fastexcel($sheets))->download("users-posts-products.xlsx");


        // Importation du fichier "/public/users.xlsx"
// $data = fastexcel()->import("users.xlsx");

// $data = fastexcel()->importSheets("users-posts-products.xlsx");

// // $data contient une collection
// dd($data);


 $users = User::all(); // Votre collection de données

    return (new FastExcel($users))
        ->withHeaders([
            'ID' => 'ID',
            'Nom' => 'Login',
            'Email' => 'Email'
        ])
        ->withColumns([
            'login',
            'email'
        ])
        ->sheet('Utilisateurs') // Nom de la feuille de calcul
        ->styleCells(
            'A1:C1', // Plage de cellules à styliser (par exemple, les en-têtes)
            [
                'font' => ['bold' => true],
                'fill' => ['color' => ['rgb' => 'FF0000']], // Rouge
            ]
        )
        ->export('users.xlsx');


        //dd($fastexcel);

            // session(['config' => 'abonnement']);
            // $pdf = PDF::loadView('print.listePortrait', compact(
            //     'donneeimprim',
            //     'labonne',
            //     'coldata',
            //     'coltitre'
            // ))->setPaper('a4');
            // $pdf->setBasePath(public_path());

            // // return $pdf->stream();             ->setPaper('a4', 'landscape')
            // return $pdf->stream('document.pdf', ['Content-Disposition' => 'inline']);

            // return view('print.listePortrait', compact(
            //     'donnees',
            //     'labonne'                
            // ));

        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

}
