<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\User;
use App\Models\element;
use App\Models\role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UtilisateurController extends Controller
{
    public function index(Request $request)
    {   //dd($request);
        try {
            $u = Auth::user();
            $idanSel = (isset($_GET['idanSel']) > 0 && $_GET['idanSel'] != null) ? $_GET['idanSel'] : (session('idanEncours') != null ? session('idanEncours') : null);
            $idabonnement = session('idabonnementEncours');
            $rekclas = " SELECT ca.*,libelle, CONCAT(sigle,' ', groupe) sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanSel . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));
            $rekmat = "SELECT m.*, coef, rang FROM matieres m, coefficients c ";
            $rekmat .= " WHERE m.id = c.idmatiere  ";
            // $rekmat .= " AND  idclasse = '" . $laclassannesco->idclasse . "' ";
            $rekmat .= " ORDER BY rang ";

            $matieres = collect(DB::select($rekmat));

            $libpers = ", COALESCE((SELECT CONCAT(nom, ' ', prenoms) FROM personnes p WHERE  u.idpersonne = p.id ),'') libpersonne ";
            $libabonnement = ", COALESCE((SELECT designation FROM abonnements a WHERE  u.idabonnement = a.id ),'') libabonnement ";
            $libtyp = ", COALESCE((SELECT libelle FROM elements e WHERE  u.idtypuser = e.id ),'') libtype ";

            $rekete = " SELECT u.*, r.name librole " . $libpers . $libabonnement . $libtyp;
            $rekete .= " FROM users u, roles r  ";
            $rekete .= " WHERE u.idrole = r.id ";
            if ($u->idrole != 3)
                $rekete .= " AND idabonnement = '" . $u->idabonnement . "' ";
            $rekete .= " ORDER BY libpersonne ";
            //  dd($rekete);
            $donnees = collect(DB::select($rekete));
            // $donnees = User::get(); 

            session(['config' => 'utilisateur']);
            return view('liste', compact(
                'donnees',
                'classannescos',
                'matieres'
            ));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }


    public function formModif(Request $request, $id)
    { //dd($request);
        $request['idenreg'] = $id;
        return $this->form($request);
    }

    public function form(Request $request)
    {

        $idenreg = $request['idenreg'];

        $idenreg = $request['idenreg'];
        session(['config' => 'utilisateur']);
        $roles = role::orderBy('name')->get();
        $abonnements = abonnement::orderBy('designation')->get();
        $nationalites = element::where('nomtable', 'NATIONALITE')
            ->orderBy('libelle')->get();
        $sexes = element::where('nomtable', 'SEXE')
            ->orderBy('libelle')->get();
        $typusers = element::where('nomtable', 'TYPEUSER')
            ->orderBy('libelle')->get();

        $rekpers = " SELECT p.*, CONCAT(nom,' ', prenoms ) libpersonne FROM personnes p ORDER BY libpersonne ";
        $personnes = collect(DB::select($rekpers));
        $lenregistrement = ($idenreg != null) ? user::find($idenreg) : null;
        return view('formCompte', compact(
            'lenregistrement',
            'idenreg',
            'roles',
            'abonnements',
            'typusers',
            'personnes',
            'nationalites',
            'sexes'
        ));

    }


    public function enregistrer(Request $request)
    {  //dd($request);
        try {

            $id = $request->input('idenreg');

            if ($id == 0 || $id == null) {
                $doub = User::where('login', $request->login)
                    ->get();
                $e = new User();
            } else {
                $doub = User::where('login', $request->login)
                    ->where('id', '!=', $id)
                    ->get();
                $e = User::findOrFail($id);
            }
            if (count($doub) == 0) {
                //Enregistrer d'abord la personne

                $e->idpersonne = $request->idpersonne;
                $e->idrole = $request->idrole;
                $e->idtypuser = $request->idtypuser;
                $e->email = $request->email;
                $e->idabonnement = $request->idabonnement;
                if ($id == 0 || $id == null) {
                    $e->login = $request->login;
                    $hashed = Hash::make($request->password);
                    $e->password = $hashed;
                    $e->is_active = true;
                }
                // dd($request->idabonnement);
                $e->save();
                return redirect()->route('utilisateur');
            } else {
                $info = "L'utilisateur que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'élément de paramétrage.' . $e);
        }
    }


    public function supprimer($id)
    {
        try {
            $e = User::findOrFail($id);
            $e->delete();

            return redirect()->route('utilisateur');
        } catch (\Exception $e) {
            return redirect()->route('utilisateur')->with('error', 'Une erreur est survenue lors de la suppression du prospect.');
        }
    }

    public function logout(Request $request)
    { //dd($request);
        //        Auth::logout();
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function changerPassword(Request $request)
    {
        // dd($request);

        $pref = $request->password;
        $pold = Hash::make($request->ancienpass);
        $pnew = $request->newpass;
        $p = Hash::make($request->newpass);
        if (Hash::check($request->ancienpass, $pref)) {
            $u = User::findOrFail($request->iduser);
            $u->password = $p;
            $u->password_changed_at = date('Y-m-d H:i:s');
            $u->save();
            return back();
        } else {

            $titre = "CONTROLE DE CONFORMITE";
            $info = "Actuel mot de passe incorrect ";
            return view('alertDoublon', compact('info', 'titre'));
        }
    }

    public function reinitialiserPassword(Request $request)
    {
        //dd($request);
        $u = User::findOrFail($request->iduserReinit);
        $p = Hash::make($request->reinitpass);
        $u->password = $p;
        $u->password_changed_at = date('Y-m-d H:i:s');
        $u->save();

        return back();

    }

    public function changerLogin(Request $request)
    {
        // dd($request);
        $u = User::findOrFail($request->iduserChgLogin);
        $u->login = $request->loginchange;

        $u->save();

        return back();

    }

}
