<?php

namespace App\Http\Controllers;

use App\Models\matiere;
use App\Models\coefficient;
use Illuminate\Http\Request;

class MatiereController extends Controller
{    
    public function index(Request $request)
    {   //dd($request);
        try {

            $donnees = matiere::orderBy('libelle')->get();
            session(['config' => 'matiere']);
            return view('liste', compact(
                'donnees'
            ));
        } catch (\Exception $e) {
            return redirect()->route('matiere')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'matiere']);       

        $lenregistrement = ($idenreg != null) ? matiere::find($idenreg) : null;
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
                $doub = matiere::where('libelle', $request->libelle)->get();
                $e = new matiere();
            } else {
                $doub = matiere::where('libelle', $request->libelle)
                ->where('id', '!=', $id)
                ->get();
                $e = matiere::findOrFail($id);
            }
            //dd($doub);
            if (count($doub) == 0) {
                // libelle	maternel	primaire	secondaire	universitaire	autres
              
                $e->libelle = $request->libelle;
                $e->abreviation = $request->abreviation;
                $e->maternel = $request->maternel;
                $e->primaire = $request->primaire;
                $e->secondaire = $request->secondaire;
                $e->universitaire = $request->universitaire;
                $e->autres = $request->autres;

                $e->save();//die();
                return redirect()->route('matiere');
            } else {
                $info = "La matière que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('matiere')->with('error', value: "Une erreur est survenue lors de l'enregistrement de la classe-type." . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $v = coefficient::where('idmatiere', $id)->get();
            if (count($v) == 0) {
                $e = matiere::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('matiere');
            } else {
                $info = "La matière que vous tentez de supprimer est liée à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('matiere')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
