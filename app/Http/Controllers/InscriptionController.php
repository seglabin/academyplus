<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inscription;

class InscriptionController extends Controller
{
    
    public function enregistrer(Request $request)
    {
        // dd($request);

        try {
            $i = isset($request->num)?$request->num:'';
            // idenreg0   idapprenant0    idclassannesco0 dateinscrip0    reduction
            $idapprenant = $request->input('idapprenant'.$i);
            $idclassannesco = $request->input('idclassannesco'.$i);
            $dateinscrip = $request->input('dateinscrip'.$i);
            $reduction = $request->input('reduction'.$i);
            $id = $request->input('idenreg'.$i);
            $doub = inscription::where('idapprenant', $idapprenant)
                ->where('idclassannesco', $idclassannesco);
                
            if ($id == 0 || $id == null) {
                $e = new inscription();
            } else {
                $doub = $doub->where('id', '!=', $id);                    
                $e = inscription::findOrFail($id);
            }
            $doub = $doub->get();
            //  dd(count($doub));
            if (count($doub) == 0) {
                //`idabonnement`, coef	rang	idclasse	idmatiere	
                $e->idapprenant = $idapprenant;
                $e->idclassannesco = $idclassannesco;
                $e->dateinscrip = $dateinscrip;
                $e->reduction = $reduction;                

                $e->save();//die();
                return redirect()->back();
            } else {
                $info = "L'inscription que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

}
