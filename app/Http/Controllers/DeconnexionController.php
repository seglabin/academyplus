<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeconnexionController extends Controller
{
    public function deconnecter(){
         try {
        $utilisateur = User::where('id',Auth::user()->id)->first();
        $utilisateur->statut = false;
        $utilisateur->save();

        $historique = Historique::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        $historique->status = false;
        $historique->save(); 

        auth()->logout();
        return redirect('/login');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }
     }
}
