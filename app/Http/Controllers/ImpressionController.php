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


class ImpressionController extends Controller
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

            // session(['config' => 'abonnement']);
            $pdf = PDF::loadView('print.listePortrait', compact(
                'donneeimprim',
                'labonne',
                'coldata',
                'coltitre'
            ))->setPaper('a4');
            $pdf->setBasePath(public_path());

            // return $pdf->stream();             ->setPaper('a4', 'landscape')
            return $pdf->stream('document.pdf', ['Content-Disposition' => 'inline']);

            // return view('print.listePortrait', compact(
            //     'donnees',
            //     'labonne'                
            // ));

        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

}
