<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mvtfinancier;
use App\Models\abonnement;
use App\Models\paiement;
use Illuminate\Support\Facades\DB;


class MvtfinancierController extends Controller
{

    public function index(Request $request)
    {
        //    dd(count($_GET));
        try {

            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idanneescolaire = (count($_GET) > 0 && $_GET['idanneescolaire'] != null) ? $_GET['idanneescolaire'] : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));

            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));



            // $sexe = ", COALESCE((SELECT libelle FROM elements e  WHERE e.id = pe.idsexe),'') sexe ";
            $libmotif = ", COALESCE((SELECT e.libelle FROM elements e, mvtfinanciers mv WHERE e.id = mv.idmotif AND idpayeur = ins.id LIMIT 1 ),'') libmotif ";
            $totE = " COALESCE((SELECT SUM(montant) totE FROM mvtfinanciers mv  WHERE typemvt = 'E' AND idpayeur = ins.id  AND PAYEUR = 'inscriptions' GROUP BY idpayeur ),'0')  ";
            $totS = " COALESCE((SELECT SUM(montant) totS FROM mvtfinanciers mv  WHERE typemvt = 'S' AND idpayeur = ins.id  AND PAYEUR = 'inscriptions' GROUP BY idpayeur ),'0')  ";




            $rekete = " SELECT ins.id id, CONCAT(nom, ' ', prenoms) libapprenant " . $libmotif . "," . $totE . " totE ," . $totS . " totS," . " (" . $totE . " - " . $totS . " ) solde ";
            $rekete .= " FROM apprenants a, personnes pe, inscriptions ins WHERE a.idpersonne = pe.id AND  ins.idapprenant = a.id ";
            $rekete .= " AND ins.id IN (SELECT DISTINCT idpayeur FROM mvtfinanciers mv WHERE mv.idabonnement = '" . $idabonnement . "' AND mv.idanneescolaire = '" . $idanneescolaire . "') ";
            //  $rekete .= " AND e.id = mv.idmotif AND mv.idabonnement = '" . $idabonnement . "' AND mv.idanneescolaire = '" . $idanneescolaire . "' "; 
            // $rekete .= " GROUP BY idpayeur, libapprenant, libmotif ";
            $rekete .= " ORDER BY libapprenant ";
            //    dd($rekete);
            $donnees = collect(DB::select($rekete));

            session(['config' => 'mvtfinancier']);
            return view('liste', compact(
                'donnees',
                'abonnements',
                'annescolaires',
                'idanneescolaire',
                'idabonnement',
            ));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('mvtfinancier')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }

    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        return $this->form($request);
    }


    public function enregistrer(Request $request)
    {
          //dd($request);

        try {
            $i = isset($request->num) ? $request->num : '';
            $datemvt = $request->input('datemvt' . $i);
            $typemvt = $request->input('typemvt' . $i);
            $reference = $request->input('reference' . $i);
            $montant = $request->input('montant' . $i);
            $idpayeur = $request->input('idpayeur' . $i);
            $payeur = $request->input('payeur' . $i);
            $idmotif = $request->input('idmotif' . $i);
            $idabonnement = $request->input('idabonnement' . $i);
            $idanneescolaire = $request->input('idanneescolaire' . $i);
            $observations = empty($request->input('idanneescolaire' . $i)) ? null : $request->input('observations' . $i);
            $id = $request->input('idenreg' . $i);
            $doub = mvtfinancier::where('idpayeur', $idpayeur)
                ->where('datemvt', $datemvt)
                ->where('idabonnement', $idabonnement)
                ->where('idanneescolaire', $idanneescolaire)
                ->where('payeur', $payeur);

            if ($id == 0 || $id == null) {
                $e = new mvtfinancier();
            } else {
                $doub = $doub->where('id', '!=', $id);
                $e = mvtfinancier::findOrFail($id);
            }
            $doub = $doub->get();
            //  dd(count($doub));
            if (count($doub) == 0) {
                // `datemvt`, `typemvt`, `reference`, `montant`, `idpayeur`, `payeur`, `idmotif`, `idabonnement`, `idanneescolaire`
                $e->datemvt = $datemvt;
                $e->typemvt = $typemvt;
                $e->reference = $reference;
                $e->montant = sansespace($montant);
                $e->idpayeur = $idpayeur;
                $e->payeur = $payeur;
                $e->idmotif = $idmotif;
                $e->idabonnement = $idabonnement;
                $e->idanneescolaire = $idanneescolaire;
                $e->observations = $observations;

                $e->save();//die();
                return redirect()->back();
            } else {
                $info = "La cotisation que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la cotisation.' . $e);
        }
    }



    public function enregistrerPayerParCotisation(Request $request)
    {
       // dd($request);

       
        try {
            $i = isset($request->num) ? $request->num : '';
            $datemvt = $request->input('datemvt' . $i);
            $typemvt = $request->input('typemvt' . $i);
            $reference = $request->input('referencePC' . $i);
            $montant = $request->input('montantPC' . $i);
            $observations = $request->input('observationsPC' . $i);
            $deposant = $request->input('deposant' . $i);
            $idpayeur = $request->input('idpayeur' . $i);
            $payeur = $request->input('payeur' . $i);
            $idmotif = $request->input('idmotif' . $i);
            $idabonnement = $request->input('idabonnement' . $i);
            $idanneescolaire = $request->input('idanneescolaire' . $i);
            $observations = empty($request->input('idanneescolaire' . $i)) ? null : $request->input('observations' . $i);
            $id = $request->input('idenreg' . $i);
            $doub = mvtfinancier::where('idpayeur', $idpayeur)
                ->where('datemvt', $datemvt)
                ->where('idabonnement', $idabonnement)
                ->where('idanneescolaire', $idanneescolaire)
                ->where('payeur', $payeur);

            if ($id == 0 || $id == null) {
                $e = new mvtfinancier();
            } else {
                $doub = $doub->where('id', '!=', $id);
                $e = mvtfinancier::findOrFail($id);
            }
            $doub = $doub->get();
            //  dd(count($doub));
            if (count($doub) == 0) {
                // `datemvt`, `typemvt`, `reference`, `montant`, `idpayeur`, `payeur`, `idmotif`, `idabonnement`, `idanneescolaire`
                $e->datemvt = $datemvt;
                $e->typemvt = $typemvt;
                $e->reference = $reference;
                $e->montant = sansespace($montant);
                $e->idpayeur = $idpayeur;
                $e->payeur = $payeur;
                $e->idmotif = $idmotif;
                $e->idabonnement = $idabonnement;
                $e->idanneescolaire = $idanneescolaire;
                $e->observations = $observations;

                if ($e->save()) {
                    $p = new paiement();
                    $p->datepaiement = $datemvt;
                    $p->montant = sansespace($montant);
                    $p->deposant = $deposant;
                    $p->idinscription = $idpayeur;
                    $p->idmotif = 9; //Frais de scolarité

                    $p->save();//die();
                }
                return redirect()->back();
            } else {
                $info = "La cotisation que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la cotisation.' . $e);
        }
    }


}
