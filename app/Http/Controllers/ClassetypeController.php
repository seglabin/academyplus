<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classetype;
use App\Models\classannesco;
use App\Models\niveau;
use App\Models\secteur;
use Illuminate\Support\Facades\DB;

class ClassetypeController extends Controller
{

    public function index(Request $request)
    {   //dd($request);
        try {

            $donnees = classetype::orderBy('niveau')->get();

            session(['config' => 'classetype']);
            return view('liste', compact(
                'donnees'
            ));
        } catch (\Exception $e) {
            return redirect()->route('classetype')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'classetype']);
        $niveaux = niveau::orderBy('id')->get();
        $secteurs = secteur::orderBy('id')->get();

        $lenregistrement = ($idenreg != null) ? classetype::find($idenreg) : null;
        return view('parametres.formParam', compact(
            'lenregistrement',
            'idenreg',
            'niveaux',
            'secteurs'
        ));
    }


    public function enregistrer(Request $request)
    { //dd($request);
        try {
            $rekdoub = " SELECT * FROM classetypes WHERE  (sigle='" . $request->sigle . "' OR libelle='" . $request->libelle . "' )";
            $id = $request->input('idenreg');

            if ($id == 0 || $id == null) {
                // $doub = classetype::where('sigle', $request->sigle)
                //     ->orWhere('libelle', $request->libelle) ->get();
                $e = new classetype();
            } else {
                // $doub = Classetype::where('sigle', $request->sigle)
                //     ->orWhere('libelle', $request->libelle)
                //     ->where('id', '!=', $id)
                //     ->get();
                $rekdoub .= " AND id!= '" . $id."' "; 
                $e = classetype::findOrFail($id);
            }
            $doub = collect(DB::select($rekdoub));
            dd($doub);
            if (count($doub) == 0) {
                //`designation`, `contact`, `email`, `adresse`
                $e->niveau = $request->niveau;
                $e->secteur = $request->secteur;
                $e->sigle = $request->sigle;
                $e->libelle = $request->libelle;

                $e->save();//die();
                return redirect()->route('classetype');
            } else {
                $info = "La classe type que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('classetype')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe-type.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $v = classannesco::where('idclasse', $id)->get();
            if (count($v) == 0) {
                $e = classetype::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('classetype');
            } else {
                $info = "La classe-type que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('classetype')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
