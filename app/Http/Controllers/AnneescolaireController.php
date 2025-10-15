<?php

namespace App\Http\Controllers;
use App\Models\anneescolaire;
use App\Models\classannesco;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnneescolaireController extends Controller
{

    public function index(Request $request)
    {   //dd($request);
        try {

            $donnees = anneescolaire::orderBy('andebut')->get();

            session(['config' => 'anneescolaire']);
            return view('liste', compact(
                'donnees'
            ));
        } catch (\Exception $e) {
            return redirect()->route('anneescolaire')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'anneescolaire']);

        $lenregistrement = ($idenreg != null) ? anneescolaire::find($idenreg) : null;
        return view('parametres.formParam', compact(
            'lenregistrement',
            'idenreg'
        ));
    }


    public function enregistrer(Request $request)
    { //dd($request);
        try {

            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = Anneescolaire::where('andebut', $request->andebut)->get();
                $e = new anneescolaire();
            } else {
                $doub = Anneescolaire::where('andebut', $request->andebut)
                    ->where('id', '!=', $id)
                    ->get();
                $e = anneescolaire::findOrFail($id);
            }
            //dd(count($doub));
            if (count($doub) == 0) {

                $e->andebut = $request->andebut;
                $e->save();//die();
                return redirect()->route('anneescolaire');
            } else {
                $info = "L'année scolaire que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            return redirect()->route('anneescolaire')->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $v = classannesco::where('idanneescolaire', $id)->get();
            if (count($v) == 0) {
                $e = anneescolaire::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('anneescolaire');
            } else {
                $info = "L'année que vous tentez de supprimer est lié à au moins un autre enregistrement \n Vous ne pouvez donc pas la supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('client')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
    public function ChangerAnnesco(Request $request)
    {
        $u = Auth::user();
        //  dd($_GET);
        $idanSel = (isset($_GET['idanSel']) > 0 && $_GET['idanSel'] != null) ? $_GET['idanSel'] : (session('idanEncours') != null ? session('idanEncours') : null);
        // dd($idanSel);
        // Liste des classes de l'abonné pour l'année scolaire
       
        $classannescosEncours =  lesclassesAnnesco($u->id, $u->idrole, $u->idabonnement, $idanSel);


        session(['classannescosEncours' => $classannescosEncours]);
        session(['idanEncours' => $idanSel]);
        session(['laclassEncour' => null]);
        session(['idclassannescosEncours' => null]);

        return redirect()->back();

    }
}
