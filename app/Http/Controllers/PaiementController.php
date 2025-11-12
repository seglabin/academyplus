<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paiement;
use App\Models\apprenant;
use App\Models\classannesco;
use App\Models\classetype;
use App\Models\abonnement;
use App\Models\anneescolaire;
use App\Models\inscription;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{

    public function index(Request $request)
    {   
        // dd($request); 
        try {
            $idabonnement = ($request->idabonnement) ? $request->idabonnement : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idclassannesco = ($request->idclassannesco) ? $request->idclassannesco : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = ($request->idanneescolaire) ? $request->idanneescolaire : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));

            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            // dd($rekclas);
            $classannescos = collect(DB::select($rekclas));



            $inscriptions = inscription::where("idclassannesco", $idclassannesco)->get();
            $idinscrip = $inscriptions->pluck('id')->toArray();

            $rekete = "SELECT p.*, CONCAT(nom,' ', prenoms) libapprenant, libelle libmotif ";
            $rekete .= " FROM paiements p, inscriptions ins, apprenants a, elements e, personnes pe ";
            $rekete .= " WHERE p.idinscription = ins.id AND ins.idapprenant = a.id AND e.id = p.idmotif ";
            $rekete .= " AND a.idpersonne = pe.id AND idclassannesco = '" . $idclassannesco . "'";
            $rekete .= " ORDER BY datepaiement ";
            // dd($rekete);
            $donnees = collect(DB::select($rekete));

            session(['config' => 'paiement']);
            return view('liste', compact(
                'donnees',
                'abonnements',
                'idabonnement',
                'classannescos',
                'idclassannesco',
                'annescolaires',
                'idanneescolaire',

            ));
        } catch (\Exception $e) {
            return redirect()->route('paiement')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }


    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['modif'] = true;
        return $this->form($request);
    }

    public function form(Request $request)
    {

        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $cf = ($modif == true) ? 'modifier-paiement' : 'ajout-paiement';
        session(['config' => $cf]);
        $idanneescolaire = (session('idanneescolaire')!= null && session('idanneescolaire')!= 0)?session('idanneescolaire'): session('idanEncours'); 
        $idabonnement = session('idabonnement');
        $idclassannesco = session('idclassannesco');
        $lenregistrement = ($idenreg != null) ? paiement::find($idenreg) : null;

        if ($lenregistrement) {
            $idinscription = $lenregistrement->idinscription;
            //dd($idinscription);
            $idinscription = inscription::find($idinscription);
            $idclassannesco = $idinscription->idclassannesco;
            $classannesco = classannesco::find($idclassannesco);
            $idanneescolaire = $classannesco->idanneescolaire;
        }

        $abonnements = abonnement::orderBy('designation')->get();

        $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
        $annescolaires = collect(DB::select($rekan));

        $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
        $rekclas .= " WHERE c.id = ca.idclasse ";
        $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
        $rekclas .= " ORDER BY libclasse ";
        $classannescos = collect(DB::select($rekclas));

        $rekappr = "SELECT ins.*, CONCAT(nom,' ', prenoms) libapprenant ";
        $rekappr .= " FROM inscriptions ins, apprenants a, personnes pe ";
        $rekappr .= " WHERE a.idpersonne = pe.id AND ins.idapprenant = a.id AND idclassannesco = '" . $idclassannesco . "' ";
        $rekappr .= " ORDER BY libapprenant ";
        $apprenants = collect(DB::select($rekappr));

        $rekmotif = " SELECT * FROM elements WHERE nomtable = 'motif' AND lecas = 'PAIEMENT' ORDER BY libelle ";
        $motifs = collect(DB::select($rekmotif));

        $laclassannesco = classannesco::find($idclassannesco);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);


        return view('formScolarite', compact(
            'lenregistrement',
            'idenreg',
            'classannescos',
            'abonnements',
            'annescolaires',
            'idanneescolaire',
            'idabonnement',
            'idclassannesco',
            'labonnement',
            'lannesco',
            'laclassannesco',
            'apprenants',
            'motifs'
        ));
    }


    public function enregistrer(Request $request)
    {
        //dd($request);
        try {
            $route = 'paiement';
            if ((isset($request->module) && $request->module == 'paiementAbonne')) {
                $route = 'classeAbonne';
                session(['module' => 'listePaiementAbonnement']);
            }
            $id = $request->input('idenreg');
            $doub = array();
            if ($id == 0 || $id == null) {
                $e = new paiement();
            } else {
                $e = paiement::findOrFail($id);
            }
            if (count($doub) == 0) {

                $e->datepaiement = $request->datepaiement;
                $e->montant = sansespace($request->montant);
                $e->deposant = $request->deposant;
                $e->idinscription = $request->idinscription;
                $e->idmotif = $request->idmotif;

                $e->save();//die();
                return redirect()->route($route);
            } else {
                $info = "Le paiement que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe-type.' . $e);
        }
    }


    public function enregistrerModal(Request $request)
    {
        //dd($request);
        try {
            $i = isset($request->num) ? $request->num : '';
            $datepaiement = $request->input('datepaiement' . $i);
            $montant = $request->input('montantP' . $i);
            $deposant = $request->input('deposant' . $i);
            $idinscription = $request->input('idinscription' . $i);
            $idmotif = $request->input('idmotif' . $i);
            $e = new paiement();

            $id = $request->input('idenreg');
            $doub = array();
            
            if (count($doub) == 0) {

                $e->datepaiement = $datepaiement;
                $e->montant = sansespace($montant);
                $e->deposant = $deposant;
                $e->idinscription = $idinscription;
                $e->idmotif = $idmotif;

                $e->save();//die();
                return redirect()->back();
            } else {
                $info = "Le paiement que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement du paiement.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            // dd($id);
               $route = 'paiement';
            if ((session('module') != null) && session('module') == 'listePaiementAbonnement') {
                $route = 'classeAbonne';
                session(['module' => 'listePaiementAbonnement']);
            }

            $e = paiement::findOrFail($id);
            //dd($e);
            $e->delete();
            return redirect()->route($route)->with('success', 'L\'enregistrement a été supprimé avec succès.');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
