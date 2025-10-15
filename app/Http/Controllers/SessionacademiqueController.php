<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sessionacademique;
use App\Models\composition;
use App\Models\moyperiodapprenants;
use App\Models\secteur;
use Illuminate\Support\Facades\DB;

class SessionacademiqueController extends Controller
{
    //libelle	rang	idsecteur	
    public function index(Request $request)
    {
        // dd($request);
        try {
           
            $secteurs = secteur::orderBy('libelle')->get();
            $rekete = " SELECT sa.*,s.libelle libsecteur, sigle  ";
            $rekete .= " FROM sessionacademiques sa , secteurs s ";
            $rekete .= " WHERE sa.idsecteur = s.id ";
            $rekete .= " ORDER BY libsecteur,libelle  "; //idtypematiere

            $donnees = collect(DB::select($rekete));

            $secteurs = secteur::orderBy('libelle')->get();
           
            session(['config' => 'session-academique']);
            return view('liste', compact(
                'donnees',
                'secteurs',
              
            ));
        } catch (\Exception $e) {
            return redirect()->route('sessionacademique')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'session-academique']);
        //dd($_GET);

        $idclasSel = isset($_GET['idclasse']) ? $_GET['idclasse'] : null;
       $secteurs = secteur::orderBy('libelle')->get();

        $lenregistrement = ($idenreg != null) ? sessionacademique::find($idenreg) : null;
       
        return view('parametres.formParam', compact(
            'lenregistrement',
            'idenreg',
            'secteurs',
           
        ));
    }

    public function enregistrer(Request $request)
    {
        // dd($request);

        try {
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = sessionacademique::where('idsecteur', $request->idsecteur)
                    ->where('libelle', $request->libelle)->get();
                $e = new sessionacademique();
            } else {
                $doub = sessionacademique::where('idsecteur', $request->idsecteur)
                    ->where('libelle', $request->libelle)
                    ->where('id', '!=', $id)
                    ->get();
                $e = sessionacademique::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //`idsecteur`, coef	rang	idclasse	idmatiere	
                $e->idsecteur = $request->idsecteur;
                $e->libelle = $request->libelle;              
                $e->rang = $request->rang;
            
                $e->save();//die();
                return redirect()->route('sessionacademique');
            } else {
                $info = "La session académique que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('sessionacademique')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la session académique.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            // //Controle de possibilité de suppression
             $v = composition::where('idsession', $id)->get();
             $v2 = moyperiodapprenants::where('idsession', $id)->get();
             $nb = count($v) + count($v2);

             if ($nb == 0) {
            $e = sessionacademique::findOrFail($id);
            //dd($e);
            $e->delete();

            return redirect()->route('sessionacademique');
            } else {
                $info = "La session académique que vous tentez de supprimer est liée à au moins un enregistrement \n Vous ne pouvez donc pas la supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('sessionacademique')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
