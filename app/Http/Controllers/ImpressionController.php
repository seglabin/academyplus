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
        // dd(session('config'));
        try {
            $idabonnement = (count($_GET) > 0 && isset($_GET['idabonnement'])) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idanneescolaire = (count($_GET) > 0 && isset($_GET['idanneescolaire'])) ? $_GET['idanneescolaire'] : null;
            $letitre = (count($_GET) > 0 && isset($_GET['letitre'])) ? $_GET['letitre'] : 'Titre document';
            $idclassannesco = (count($_GET) > 0 && isset($_GET['idclassannesco'])) ? $_GET['idclassannesco'] : null;
            $idinscription = (count($_GET) > 0 && isset($_GET['idinscription'])) ? $_GET['idinscription'] : null;
            $idsession = (count($_GET) > 0 && isset($_GET['idsession'])) ? $_GET['idsession'] : null;
            $config = session('config') != null ? session('config') : '';
            $labonne = $idabonnement != null ? collect(DB::select(" SELECT * FROM abonnements WHERE id = '" . $idabonnement . "' "))->first() : null;
            $lannesco = $idanneescolaire != null ? collect(DB::select(" SELECT a.*, CONCAT(andebut,' - ',(andebut + 1)) libannee FROM anneescolaires a WHERE id = '" . $idanneescolaire . "' "))->first() : null;
            $laclannesco = $idclassannesco != null ? collect(DB::select(" SELECT ca.*, CONCAT(libelle, ' ', COALESCE(groupe, '')) libclas FROM classannescos ca , classetypes c WHERE ca.idclasse = c.id AND  ca.id = '" . $idclassannesco . "' "))->first() : null;
            $lapprenant = $idinscription != null ? collect(DB::select(" SELECT ins.*, CONCAT(nom, ' ', prenoms) libapprenant FROM inscriptions ins, apprenants a , personnes p WHERE a.idpersonne = p.id AND ins.idapprenant = a.id AND  ins.id = '" . $idinscription . "' "))->first() : null;
            $lasession = $idsession != null ? collect(DB::select(" SELECT * FROM sessionacademiques WHERE id = '" . $idsession . "' "))->first() : null;
            $donneeimprim = session('donneeimprim') != null ? session('donneeimprim') : array();
            $coltitre = session('coltitre') != null ? session('coltitre') : '';
            $coldata = session('coldata') != null ? session('coldata') : '';
            $hautdoc = array();
            $ln = array();
            $frmat = 'A4';
            // dd($config);
            $pag = in_array($config, array('moyenne-periode-apprenant','details-composition')) ? 'landscape' : 'portrait';

            $fichier = $letitre . '.pdf';
            // dd($donneeimprim);
            // dd($config);
            // switch ($config) {
            //     case 'moyenne-generale-periode':
            //     case 'moyenne-periode-apprenant':
            //     case 'anneescolaire':
            //     case 'role':
            //     case 'personne':
            //     case 'session-academique':
            //     case 'coefficient':
            //     case 'matiere':
            //     case 'utilisateur':
            //     case 'classetype':
            //     case 'apprenant':
            //     case 'classannesco':
            //     case 'abonnement':
            //     case 'paiement':
            //     case 'paramfrais':
            //     case 'evaluation':
            //     case 'composition':
            //     case 'moyenne-periode':
            //     case 'permission':
            //     case 'element':
            if ($lannesco != null) {
                array_push($ln, 'Année scolaire ');
                array_push($ln, $lannesco->libannee);
            }
            if ($laclannesco != null) {
                array_push($ln, 'Classe Année scolaire ');
                array_push($ln, $laclannesco->libclas);
            }
            if ($lasession != null) {
                array_push($ln, 'Session académique ');
                array_push($ln, $lasession->libelle);
            }
            if (count($ln) > 0)
                array_push($hautdoc, $ln);
            $ln = array();
            if ($lapprenant != null) {
                array_push($ln, 'Apprenant : ');
                array_push($ln, $lapprenant->libapprenant);
            }
            if (count($ln) > 0)
                array_push($hautdoc, $ln);
            //         break;

            // }
            // dd($hautdoc);
            //  dd($donneeimprim);


            // session(['config' => 'abonnement']);
            $pdf = PDF::loadView('print.liste', compact(
                'donneeimprim',
                'labonne',
                'coldata',
                'coltitre',
                'hautdoc',
                'letitre',

            ))->setPaper($frmat, $pag);
            $pdf->setBasePath(public_path());

            // return $pdf->stream();             ->setPaper('a4', 'landscape')
            return $pdf->stream($fichier, ['Content-Disposition' => 'inline']);

            // return view('print.listePortrait', compact(
            //     'donnees',
            //     'labonne'                
            // ));

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }
    }


    public function cartes(Request $request)
    {
        //dd($request);
        // --- IGNORE ---
        try {
            $idabonnement = (count($_GET) > 0 && isset($_GET['idabonnement'])) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $labonne = $idabonnement != null ? collect(DB::select(" SELECT * FROM abonnements WHERE id = '" . $idabonnement . "' "))->first() : null;
            $idanneescolaire = (count($_GET) > 0 && isset($_GET['idanneescolaire'])) ? $_GET['idanneescolaire'] : null;
            $lannesco = $idanneescolaire != null ? collect(DB::select(" SELECT a.*, CONCAT(andebut,' - ',(andebut + 1)) libannee FROM anneescolaires a WHERE id = '" . $idanneescolaire . "' "))->first() : null;
            $config = session('config') != null ? session('config') : '';
            $donneeimprim = session('donneeimprim') != null ? session('donneeimprim') : array();

            $letitre = (count($_GET) > 0 && isset($_GET['letitre'])) ? $_GET['letitre'] : 'Titre document';
            $fichier = $letitre . '.pdf';

            $frmat = 'A4';
            $pag = in_array($config, array('moyenne-periode-apprenant')) ? 'landscape' : 'portrait';

            $pdf = PDF::loadView('print.cartes', compact(
                'donneeimprim',
                'labonne',
                'lannesco',


            ))->setPaper($frmat, $pag);
            $pdf->setBasePath(public_path());

            // return $pdf->stream();             ->setPaper('a4', 'landscape')
            return $pdf->stream($fichier, ['Content-Disposition' => 'inline']);

            // return view('print.cartes', compact(
            //     'donnees',
            //     'labonne'
            // ));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }

    }

}
