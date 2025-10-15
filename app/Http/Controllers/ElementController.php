<?php

namespace App\Http\Controllers;
use App\Models\element;
use App\Models\subvention;

use Illuminate\Http\Request;

class ElementController extends Controller
{
    public function index(Request $request)
    {   //dd($request);
        // dd(session('nomtable'));
        try {
            $nomtable = session('nomtable');
            if ($nomtable == 'circonscolaire') $titre = "Liste des circonscriptions scolaires";
            if ($nomtable == 'nationalite') $titre = "Liste des nationalités ";
            if ($nomtable == 'sexe') $titre = "Liste des sexes ";
            if ($nomtable == 'motif') $titre = "Liste des motifs ";
            if ($nomtable == 'typematiere') $titre = "Liste des types de matières ";
            if ($nomtable == 'ddemp') $titre = "Liste des Directions Départementales des Enseignements Maternels et Primaires ";

            $donnees = element::where('nomtable', $nomtable)->orderBy('libelle')->get();

            session(['config' => 'element']);
            return view('liste', compact(
                'donnees',
                'nomtable',
                'titre'
            ));
        } catch (\Exception $e) {
            return redirect()->route('element')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        $nomtable = session('nomtable'); //dd($nomtable);
        if ($nomtable == 'circonscolaire') $titre = ($idenreg != null) ? "Modification d'une circonscription scolaire" : "Ajout d'une circonscription scolaire";
        if ($nomtable == 'motif') $titre = ($idenreg != null) ? "Modification d'un motif" : "Ajout d'un motif";
        if ($nomtable == 'typematiere') $titre = ($idenreg != null) ? "Modification d'un type de matière" : "Ajout d'un type de matière";
        if ($nomtable == 'nationalite') $titre = ($idenreg != null) ? "Modification d'une nationalité" : "Ajout d'une nationalité";
        if ($nomtable == 'ddemp') $titre = ($idenreg != null) ? "Modification d'une Direction Départementale des Enseignements Maternels et Primaires" : "Ajout d'une Direction Départementale des Enseignements Maternels et Primaires";
        if ($nomtable == 'sexe') $titre = ($idenreg != null) ? "Modification d'un sexe" : "Ajout d'un sexe";
        session(['config' => 'element']);

        $lenregistrement = ($idenreg != null) ? element::find($idenreg) : null;
        return view('parametres.formParam', compact(
            'lenregistrement',
            'idenreg',
            'nomtable',
            'titre'
        ));
    }


    public function enregistrer(Request $request)
    {
        // dd($request);
        try {

            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = element::where('libelle', $request->libelle)
                    ->where('nomtable', $request->nomtable)->get();
                $e = new element();
            } else {
                $doub = element::where('libelle', $request->libelle)
                    ->where('nomtable', $request->nomtable)
                    ->where('id', '!=', $id)->get();
                $e = element::findOrFail($id);
            }
            //dd(count($doub));
            if (count($doub) == 0) {

                $e->libelle = $request->libelle;
                $e->nomtable = $request->nomtable;

                if($request->lecas != null) $e->lecas = $request->lecas;
                $e->save();//die();
                session(['nomtable' => $request->nomtable]);
                return redirect()->route('element');
            } else {
                $info = "L'élément que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            return redirect()->route('element')->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'élément.' . $e);
        }
    }

    public function supprimer($id)
    {
        $nomtable = session('nomtable');
        //dd($nomtable);
        try {
            //Controle de possibilité de suppression
            $v = array();
            switch ($nomtable) {
                case 'circonscolaire':
                    $v = subvention::where('idcirconscolaire', $id)->get();
                    break;
            }
            if (count($v) == 0) {
                $e = element::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('element');
            } else {
                $info = "L'élément que vous tentez de supprimer est lié à au moins un autre enregistrement \n Vous ne pouvez donc pas la supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('element')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
