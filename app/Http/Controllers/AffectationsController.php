<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\affectation;
use Illuminate\Support\Facades\DB;

class AffectationsController extends Controller
{


    public function enregistrer(Request $request)
    {  //dd($request);
        try {
            $i = $request->num;
            $idens = 'idenseignant'.$i;
            $idcl = 'idclassannesco'.$i;
            $idm = 'idmatiere'.$i;
            $dat = 'dateaffetation'.$i;

            $rek = " SELECT * FROM affectations WHERE idenseignant = '" . $request->$idens . "' AND idclassannesco = '" . $request->$idcl . "' AND idmatiere = '" . $request->$idm . "' ";
            $d = collect(DB::select($rek));

            // dd(count($d));

            if (count($d) == 0) {
                $e = new affectation();
            }else{
                // dd($d[0]->id);
                $id = $d[0]->id;
                 $e = affectation::findOrFail($id);
                 $e->desactive = false;
            }
                $e->idenseignant = $request->$idens;
                $e->idclassannesco = $request->$idcl;
                $e->idmatiere = $request->$idm;
                $e->dateaffetation = $request->$dat;

                $e->save();//die();
                // session(['config' => 'utilisateur']);
                return redirect()->route('utilisateur');

            
           
            //     return redirect()->route('classannesco');
            // } else {
            //     $info = "La classe année scolaire que vous tentez d'enregistrer existe déjà";
            //     $titre = "DOUBLON";
            //     return view('alertDoublon', compact('info', 'titre'));
            // }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors de l\'enregistrement.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
                $e = affectation::findOrFail($id);
                $e->delete();

                return redirect()->route('utilisateur');
           
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }

    public function retirer($id)
    {
        try {
                $e = affectation::findOrFail($id);
                 $e->desactive = true;
                $e->save();

                return redirect()->route('utilisateur');
           
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors de la modification de l\'enregistrement.');
        }
    }
}