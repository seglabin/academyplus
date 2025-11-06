<?php

namespace App\Http\Controllers;

use App\Models\historique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeconnexionController extends Controller
{
    public function deconnecter()
    {
        try {

            $aut = Auth::user();
            if ($aut) {
                $utilisateur = User::where('id', Auth::user()->id)->first();
                $utilisateur->statut = false;
                $utilisateur->save();

                $historique = historique::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
                $historique->status = false;
                $historique->save();

                auth()->logout();
            }
            //  dd('here');
            return redirect()->route('bienvenue');
            // return redirect()->route('login');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }
    }
}
