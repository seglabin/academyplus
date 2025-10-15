<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Structure;
use App\Models\visite;
use App\Models\typeelement;
use App\Models\Permission;
use App\Models\Prospect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    // public function __construct(\Illuminate\Contracts\Auth\Factory $auth)
    // {
    //     // $this->middleware('auth');
    // }
    public function index(Request $request)
    {
        
        session(['config' => 'accueil']);
        $userEncours = (session('userEncours')!=null)? session('userEncours'):null;
        $anEncours = (session('anEncours')!=null)? session('anEncours'):null;
        $abonnementEncours = (session('abonnementEncours')!=null)? session('abonnementEncours'):null;
        $roleEncours = (session('roleEncours')!=null)? session('roleEncours'):null;
        //  dd($abonnementEncours);
        // if($abonnementEncours)
        
        return view('accueil');
        // return view('welcome');
        // return view('accueilAbonne');
        // return view('Abonnes.liste');
    }

}
