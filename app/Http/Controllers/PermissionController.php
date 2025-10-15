<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permission;
use App\Models\rolepermission;

class PermissionController extends Controller
{
    
    public function index(Request $request)
    {   //dd($request);
        try {

            $donnees = permission::orderBy('libelle')->get();
            session(['config' => 'permission']);
            return view('liste', compact(
                'donnees'
            ));
        } catch (\Exception $e) {
            return redirect()->route('permission')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'permission']);       

        $lenregistrement = ($idenreg != null) ? permission::find($idenreg) : null;
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
                $doub = permission::where('libelle', $request->libelle)->get();
                $e = new permission();
            } else {
                $doub = permission::where('libelle', $request->libelle)
                ->where('id', '!=', $id)
                ->get();
                $e = permission::findOrFail($id);
            }
            //dd($doub);
            if (count($doub) == 0) {
                // libelle	maternel	primaire	secondaire	universitaire	autres
              
                $e->libelle = $request->libelle;
                $e->description = $request->description;
                
                $e->save();//die();
                return redirect()->route('permission');
            } else {
                $info = "La fonctionnalité que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('permission')->with('error', value: "Une erreur est survenue lors de l'enregistrement de la classe-type." . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $v = rolepermission::where('idpermission', $id)->get();
            if (count($v) == 0) {
                $e = permission::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('permission');
            } else {
                $info = "La fonctionalité que vous tentez de supprimer est liée à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('permission')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
