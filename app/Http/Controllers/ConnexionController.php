<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\anneescolaire;
use App\Models\LoginHistory;
use App\Models\User;
use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ConnexionController extends Controller
{
    /* public function login(){
         return view('login');
     }*/

    public function connecter(Request $request)
    {
        try {
            //  dd($request);
            $ip = $request->ip();
            // dd($ip);
            
            $utilisateur = User::where('login', $request->login)->first();
            //  dd($utilisateur);
            if ($utilisateur) {

                if (Hash::check($request->password, $utilisateur->password)) {
                    Auth::login($utilisateur);
                    // $user = Auth::user();
                    // dd(Auth::user());
                    $utilisateur->is_active = true;
                    $utilisateur->last_login_at = date('Y-m-d H:i:s');
                    $utilisateur->save();

                    // Valeurs encours
                    $an = date('Y');
                    $mois = date('m');
                    if ($mois < 9)
                        $an -= 1;
                    $anEncours = anneescolaire::where('andebut', $an)->first();
                    $abonnementEncours = abonnement::where('id', $utilisateur->idabonnement)->first();
                    $roleEncours = role::where('id', $utilisateur->idrole)->first();
                    $idanEncours = ($anEncours != null) ? $anEncours->id : null;
                    $idabonnementEncours = $utilisateur->idabonnement;

                $rekmenu = "SELECT DISTINCT idpermission FROM rolepermissions WHERE idrole = '" . $utilisateur->idrole . "' ";
                $menusUser = collect(DB::select($rekmenu))->toArray();   
                $menusUser = array_column($menusUser,'idpermission') ;
                
// dd($rekmenu);
                    // Liste des classes de l'abonné pour l'année scolaire
                    $classannescosEncours = lesclassesAnnesco($utilisateur->id, $utilisateur->idrole, $idabonnementEncours, $idanEncours);

                    $historique = new LoginHistory();
                    $historique->user_id = Auth::user()->id;
                    $historique->status = true;
                    $historique->ip = $ip;
                    $historique->login_at = date('Y-m-d H:i:s');
                    $historique->save();

                    $request->session()->regenerate();
                    //  dd($request);
                    session(['menusUser' => $menusUser]);
                    session(['userEncours' => $utilisateur]);
                    session(['anEncours' => $anEncours]);
                    session(['abonnementEncours' => $abonnementEncours]);
                    session(['classannescosEncours' => $classannescosEncours]);
                    session(['roleEncours' => $roleEncours]);
                    session(['idanEncours' => $idanEncours]);
                    session(['idabonnementEncours' => $idabonnementEncours]);


                    // dd($anEncours);
                    return redirect('/');
                } else {
                    return redirect()->back()->with('error', 'Mot de passe incorrect');
                }
            } else {
                return redirect()->back()->with('error', 'Cet utilisateur est introuvable.');
            }

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('apprenant')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function imprimer(Request $request){
        //  dd($request);
        // $produit = "MERCI SEIGNEUR";
        //         $data = [
        //     'success' => true,
        //     'produit' => $produit
        // ];

        // return response()->json($data);
        $donnees = array();

        return view('print.listePortrait', compact(
                'donnees',
                
            ));

// 
        // return redirect()->back();

    }
}
