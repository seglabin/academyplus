<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abonnement;
use App\Models\paramfrai;
use App\Models\classetype;
use App\Models\anneescolaire;
use Illuminate\Support\Facades\DB;

class ParamfraiController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        try {
            //idannesco	idclassetype	idabonnement
            $idabonnement = ($request->idabonnement) ? $request->idabonnement : (session('idabonnement') != null ? session('idabonnement') : null);
            $idanneescolaire = ($request->idanneescolaire) ? $request->idanneescolaire : (session('idanneescolaire') != null ? session('idanneescolaire') : null);
            session(['idabonnement' => $idabonnement]);
            session(['idanneescolaire' => $idanneescolaire]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));
            $classes = classetype::orderBy('niveau')->get();

            $rekete = "SELECT p.*, CONCAT(andebut,' - ',(andebut+1)) libannee, designation,niveau, libelle ";
            $rekete .= " FROM paramfrais p, anneescolaires a, abonnements ab, classetypes c ";
            $rekete .= " WHERE p.idannesco = a.id AND p.idabonnement = ab.id AND p.idclassetype = c.id ";
            $rekete .= " AND idabonnement = '" . $idabonnement . "' AND idannesco = '" . $idanneescolaire . "'";
            $rekete .= " ORDER BY niveau ";
            // dd($rekete);
            $donnees = collect(DB::select($rekete));



            session(['config' => 'paramfrais']);
            return view('liste', compact(
                'donnees',
                'annescolaires',
                'classes',
                'abonnements',
                'idabonnement',
                'idanneescolaire'
            ));
        } catch (\Exception $e) {
            return redirect()->route('paramfrais')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }


    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        return $this->form($request);
    }

    public function form(Request $request)
    {
        $idenreg = $request['idenreg'];
        session(['config' => 'paramfrais']);
        $idabonnement = session('idabonnement');
        $idanneescolaire = session('idanneescolaire');
        // $classetypes = classetype::orderBy('niveau')->get();
        $abonnements = abonnement::orderBy('designation')->get();
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);
        $rekClasse = " SELECT * FROM classetypes  WHERE  id IN ( ";
        $rekClasse .= " SELECT DISTINCT idclasse FROM classannescos ca WHERE idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "') ";
        $rekClasse .= " ORDER BY niveau  ";
        $classetypes = collect(DB::select($rekClasse));
        
        $lenregistrement = ($idenreg != null) ? paramfrai::find($idenreg) : null;
        if ($lenregistrement) {
            // $idinscription = $lenregistrement->idinscription;
        }
        return view('formConfiguration', compact(
            'lenregistrement',
            'idenreg',
            'classetypes',
            'idabonnement','idanneescolaire',
            'labonnement',
            'lannesco'
        ));
    }


    public function enregistrer(Request $request)
    {
        //  dd($request);

        try {
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = paramfrai::where('idabonnement', $request->idabonnement)
                    ->where('idannesco', $request->idannesco)
                    ->where('idclassetype', $request->idclassetype)->get();
                $e = new paramfrai();
            } else {
                $doub = paramfrai::where('idabonnement', $request->idabonnement)
                    ->where('idannesco', $request->idannesco)
                    ->where('idclassetype', $request->idclassetype)
                    ->where('id', '!=', $id)
                    ->get();
                $e = paramfrai::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //fraiscolarite	fraisinscrip	fraisreinscrit	trancheinscrip	tranchecheance1	
                // tranchecheance2	tranchecheance3	tranchecheance4	tranchecheance5	tranchecheance6	
                // tranchecheance7	echeance1	echeance2	echeance3	echeance4	echeance5	
                // echeance6	echeance7	idannesco	idclassetype	idabonnement	
                $e->idabonnement = $request->idabonnement;
                $e->idannesco = $request->idanneescolaire;
                $e->idclassetype = $request->idclassetype;
                $e->fraiscolarite = intval(sansespace($request->fraiscolarite));
                $e->fraisinscrip = intval(sansespace($request->fraisinscrip));
                $e->fraisreinscrit = intval(sansespace($request->fraisreinscrit));
                $e->trancheinscrip = intval(sansespace($request->trancheinscrip));
                $e->tranchecheance1 = intval(sansespace($request->tranchecheance1));
                $e->tranchecheance2 = intval(sansespace($request->tranchecheance2));
                $e->tranchecheance3 = intval(sansespace($request->tranchecheance3));
                $e->tranchecheance4 = intval(sansespace($request->tranchecheance4));
                $e->tranchecheance5 = intval(sansespace($request->tranchecheance5));
                $e->tranchecheance6 = intval(sansespace($request->tranchecheance6));
                $e->tranchecheance7 = intval(sansespace($request->tranchecheance7));
                $e->echeance1 = $request->echeance1;
                $e->echeance2 = $request->echeance2;
                $e->echeance3 = $request->echeance3;
                $e->echeance4 = $request->echeance4;
                $e->echeance5 = $request->echeance5;
                $e->echeance6 = $request->echeance6;
                $e->echeance7 = $request->echeance7;

                $e->save();//die();
                return redirect()->route('paramfrais');
            } else {
                $info = "Le paramfrai que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('paramfrais')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {

            $e = paramfrai::findOrFail($id);
            //dd($e);
            $e->delete();

            return redirect()->route('paramfrais');        
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('paramfrais')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
