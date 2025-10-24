<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\personne;
use App\Models\element;
use Illuminate\Support\Facades\DB;

// `npi`, `nom`, `prenoms`, `datenais`, `lieunais`, `contactparent`, `photo`, `idsexe`, `idnationalite`

class PersonneController extends Controller
{
    public function index(Request $request)
    {
        //    dd(count($_GET));
        try {

            $libsexe = ", COALESCE((SELECT libelle FROM elements e WHERE e.id = p.idsexe AND nomtable = 'sexe' ),'') libsexe ";
            $libnationalite = ", COALESCE((SELECT libelle FROM elements e WHERE e.id = p.idnationalite AND nomtable = 'nationalite' ),'') libnationalite ";

            $rekete = " SELECT p.* , CONCAT(nom, ' ', prenoms) libpersonne  " . $libsexe . $libnationalite;
            $rekete .= "FROM personnes p ORDER BY libpersonne ";
            //    dd($rekete);
            $donnees = collect(DB::select($rekete));

            session(['config' => 'personne']);
            return view('liste', compact(
                'donnees',
            ));
        } catch (\Exception $e) {
            return redirect()->route('personne')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        // dd($request);
        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $lenregistrement = ($idenreg != null) ? personne::find($idenreg) : null;

        $leget = $_GET;
        //  dd($_GET);

        if (isset($_GET['npi']) && $_GET['npi'] != "") {
            $lenregistrement = personne::where('npi', $_GET['npi'])->first();
        }
        $cf = ($modif == true) ? 'modifier-personne' : 'ajout-personne';
        session(['config' => $cf]);

        $photo = '';
        if ($lenregistrement) {
            $photo = 'storage/images/Personnes/' . $lenregistrement->photo;
        }

        $sexes = element::where('nomtable', 'sexe')
            ->orderBy('libelle')->get();

        $nationalites = element::where('nomtable', 'nationalite')
            ->orderBy('libelle')->get();

        // dd($idclassannesco);
        return view('parametres.formParam', compact(
            'lenregistrement',
            'idenreg',
            'sexes',
            'nationalites',
            'photo',
            'leget',
        ));
    }


    public function enregistrer(Request $request)
    {
        // dd($request);
        try {
            $id = $request->input('idenreg');
            $route = 'personne';

            // Doublon
            $rekete = " SELECT  * FROM personnes WHERE ( (nom = '" . $request->nom . "' AND prenoms = '" . $request->prenoms . "')  ";
            $rekete .= " OR  npi = '" . $request->npi . "' )";
            if ($id != 0 && $id != null) {
                $rekete .= " AND id != '" . $id . "' ";
            }
            $doub = DB::select($rekete);
            $doub = collect($doub);
            if (count($doub) == 0) {

                if ($id != 0 && $id != null) {
                    $p = personne::findOrFail($id);
                } else {
                    $p = new personne();
                }
                if ($request->hasFile('photo')) {
                    $imagePath = $request->file('photo');
                    $customFileName = $imagePath->getClientOriginalName(); // Utilisez le nom d'origine du fichier
                    $imagePath->move(public_path('storage/images/Personnes'), $customFileName);
                    $p->photo = $customFileName;
                    //  dd($customFileName);
                }
                $p->npi = $request->npi;
                $p->nom = $request->nom;
                $p->prenoms = $request->prenoms;
                $p->datenais = $request->datenais;
                $p->lieunais = $request->lieunais;
                $p->contactparent = $request->contactparent;
                $p->idsexe = $request->idsexe;
                $p->idnationalite = $request->idnationalite;
                $p->save();
                return redirect()->route($route);
            } else {
                $info = "La personne que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }            

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de l\'enregistrement de la personne.' . $e);
        }
    }

    public function enregistrerModal(Request $request)
    {
        //  dd($request);
        //  return back();
        try {
            // $id = $request->input('idenreg');
            // $route = 'personne';

            // Doublon
            $rekete = " SELECT  * FROM personnes WHERE ( (nom = '" . $request->nom . "' AND prenoms = '" . $request->prenoms . "')  ";
            $rekete .= " OR  npi = '" . $request->npi . "' )";
            
            $doub = DB::select($rekete);
            $doub = collect($doub);
            if (count($doub) == 0) {              
                    $p = new personne();               
                if ($request->hasFile('photo')) {
                    $imagePath = $request->file('photo');
                    $customFileName = $imagePath->getClientOriginalName(); // Utilisez le nom d'origine du fichier
                    $imagePath->move(public_path('storage/images/Personnes'), $customFileName);
                    $p->photo = $customFileName;
                    //  dd($customFileName);
                }
                $p->npi = $request->npi;
                $p->nom = $request->nom;
                $p->prenoms = $request->prenoms;
                $p->datenais = $request->datenais;
                $p->lieunais = $request->lieunais;
                $p->contactparent = $request->contactparent;
                $p->idsexe = $request->idsexe;
                $p->idnationalite = $request->idnationalite;
                $p->save();
                return back();
            } else {
                $info = "La personne que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }            

        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la personne.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            $route = 'apprenant';
            if ((session('module') != null) && session('module') == 'listeApprenant') {
                $route = 'classeAbonne';
                session(['module' => 'listeApprenant']);
            }

            $deleted = DB::table('inscriptions')->where('idapprenant', '=', $id)->delete();
            $v = array();

            if (count($v) == 0) {
                $e = apprenant::findOrFail($id);
                $e->delete();

                return redirect()->route($route);
            } else {
                $info = "L'apprenant que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
