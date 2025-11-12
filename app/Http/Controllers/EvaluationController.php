<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classetype;
use App\Models\matiere;
use App\Models\evaluation;
use App\Models\abonnement;
use App\Models\classannesco;
use App\Models\anneescolaire;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        try {
            $idabonnement = ($request->idabonnement) ? $request->idabonnement : (session('idabonnement') != null ? session('idabonnement') : null);
            $idclassannesco = ($request->idclassannesco) ? $request->idclassannesco : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = ($request->idanneescolaire) ? $request->idanneescolaire : (session('idanneescolaire') != null ? session('idanneescolaire') : null);

            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',COALESCE(groupe, '')) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));



            $rekete = " SELECT ev.*, CONCAT(c.libelle, ' ', COALESCE(groupe, '')) libclas, m.libelle libmatiere ";
            $rekete .= " FROM evaluations ev, classannescos ca , classetypes c, matieres m ";
            $rekete .= " WHERE ev.idclassannesco = ca.id AND ev.idmatiere = m.id ";
            $rekete .= " AND ca.idclasse = c.id ";
            $rekete .= " AND ca.idabonnement = '" . $idabonnement . "' AND ca.idanneescolaire = '" . $idanneescolaire . "' ";

            $rekete .= " ORDER BY libclas, libmatiere ";
            // dd($rekete);
            $donnees = collect(DB::select($rekete));

            $matieres = matiere::orderBy('libelle')->get();


            session(['config' => 'evaluation']);
            return view('liste', compact(
                'donnees',
                'matieres',
                'abonnements',
                'idabonnement',
                'annescolaires',
                'idanneescolaire',
                'classannescos',
                'idclassannesco'
            ));
        } catch (\Exception $e) {
            return redirect()->route('evaluation')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }


    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        return $this->form($request);
    }

    public function form(Request $request)
    {

        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $cf = ($modif == true) ? 'modifier-evaluation' : 'ajout-evaluation';
        session(['config' => $cf]);
        $idanneescolaire = session('idanneescolaire');
        $idabonnement = session('idabonnement');
        $idclassannesco = session('idclassannesco');
        $lenregistrement = ($idenreg != null) ? evaluation::find($idenreg) : null;

        $matieres = matiere::orderBy('libelle')->get();

        $laclassannesco = classannesco::find($idclassannesco);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);


        return view('formScolarite', compact(
            'lenregistrement',
            'idenreg',
            'idclassannesco',
            'laclassannesco',
            'matieres','labonnement','lannesco','idanneescolaire','idabonnement'
        ));
    }


    public function enregistrer(Request $request)
    {
         //dd($request);
        try {
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = evaluation::where('idclassannesco', $request->idclassannesco)
                    ->where('idmatiere', $request->idmatiere)
                    ->where('libelle', $request->libelle)->get();
                $e = new evaluation();
            } else {
                $doub = evaluation::where('libelle', $request->libelle)
                    ->where('idclassannesco', $request->idclassannesco)
                    ->where('idmatiere', $request->idmatiere)
                    ->where('id', '!=', $id)
                    ->get();
                $e = evaluation::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //libelle	datevaluation	barem	idclassannesco	idmatiere	idetat
                $e->libelle = $request->libelle;
                $e->idclassannesco = $request->idclassannesco;
                $e->idmatiere = $request->idmatiere;
                $e->datevaluation = $request->datevaluation;
                $e->barem = $request->barem;

                $e->save();//die();
                return redirect()->route('evaluation');
            } else {
                $info = "L'evaluation que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('evaluation')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            // //Controle de possibilité de suppression
            // $v = evaluation::where('idclasse', $id)->get();
            // if (count($v) == 0) {
            $e = evaluation::findOrFail($id);
            //dd($e);
            $e->delete();

            return redirect()->route('evaluation');
            // } else {
            //     $info = "La classe-type que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
            //     $titre = "CONTRAINTE D'INTEGRITE";
            //     return view('alertDoublon', compact('info', 'titre'));
            // }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('evaluation')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
