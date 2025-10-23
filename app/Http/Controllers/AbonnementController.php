<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abonnement;
use App\Models\localite;
use App\Models\secteur;
use App\Models\user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AbonnementController extends Controller
{
    public function index(Request $request)
    {   //dd($request);
        try {
            $iddepartement = ($request->iddepartement) ? $request->iddepartement : null;
            $departemsnts = localite::where("idtypelocalite", 1)->orderBy('libelle')->get();
            $idCommune = ($request->idCommune) ? $request->idCommune : null;
            $communes = localite::where("idlocalitemere", $iddepartement)->orderBy('libelle')->get();
            $idarrond = ($request->idarrond) ? $request->idarrond : null;
            $arronds = localite::where("idlocalitemere", $idCommune)->orderBy('libelle')->get();
            $idlocalite = ($request->iddepartement) ? $request->iddepartement : null;
            $quartiers = localite::where("idlocalitemere", $idarrond)->orderBy('libelle')->get();
            $rekete = " SELECT a.*, s.sigle siglesecteur, s.libelle libsecteur ";
            $rekete .= " FROM abonnements a, secteurs s WHERE a.idsecteur = s.id ";
            $rekete .= " ORDER BY designation ";
            $donnees = collect(DB::select($rekete));
            // $donnees = abonnement::orderBy('designation')->get();

            session(['config' => 'abonnement']);
            return view('liste', compact(
                'donnees',
                'departemsnts',
                'iddepartement',
                'communes',
                'idCommune',
                'arronds',
                'idarrond',
                'quartiers',
                'idlocalite'
            ));
        } catch (\Exception $e) {
            return redirect()->route('abonnement')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'abonnement']);


        $iddepartement = ($request->iddepartement) ? $request->iddepartement : null;
        $idCommune = ($request->idCommune) ? $request->idCommune : null;
        $idarrond = ($request->idarrond) ? $request->idarrond : null;
        $idlocalite = ($request->idlocalite) ? $request->idlocalite : null;
        $lenregistrement = ($idenreg != null) ? abonnement::find($idenreg) : null;
        $secteurs = secteur::orderBy('libelle')->get();
        $nomphot = "";
        $ph = '';
        $photo = '';
        if ($lenregistrement) {
            $photo = 'storage/images/abonnements/' . $lenregistrement->logo;
            //storage/images/ABADASSI Jerry.JPG
            $idlocalite = $lenregistrement->idlocalite;
            if ($idarrond == null) {
                $qt = localite::find($idlocalite);
                $idarrond = $qt->idlocalitemere;
            }
            if ($idCommune == null) {
                $ar = localite::find($idarrond);
                $idCommune = $ar->idlocalitemere;
            }
            if ($iddepartement == null) {
                $com = localite::find($idCommune);
                $iddepartement = $com->idlocalitemere;
            }
        }


        $departemsnts = localite::where("idtypelocalite", 1)->orderBy('libelle')->get();
        $communes = localite::where("idlocalitemere", $iddepartement)->orderBy('libelle')->get();
        $arronds = localite::where("idlocalitemere", $idCommune)->orderBy('libelle')->get();
        $quartiers = localite::where("idlocalitemere", $idarrond)->orderBy('libelle')->get();


        return view('formConfiguration', compact(
            'lenregistrement',
            'idenreg',
            'departemsnts',
            'iddepartement',
            'communes',
            'idCommune',
            'arronds',
            'idarrond',
            'quartiers',
            'idlocalite',
            'nomphot',
            'ph',
            'photo',
            'secteurs'
        ));
    }


    public function enregistrer(Request $request)
    {
        // dd($request);
        try {

            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = abonnement::where('identifiant', $request->identifiant)
                    ->get();
                $e = new abonnement();
            } else {
                $doub = abonnement::where('identifiant', $request->identifiant)
                    ->where('id', '!=', $id)
                    ->get();
                $e = abonnement::findOrFail($id);
            }
            //dd($doub);
            if (count($doub) == 0) {
                $imagePath = null;
                if ($request->hasFile('logo')) {
                    $imagePath = $request->file('logo');
                    $customFileName = $imagePath->getClientOriginalName(); // Utilisez le nom d'origine du fichier
                    $imagePath->move(public_path('storage/images/abonnements'), $customFileName);
                    $e->logo = $customFileName;
                }
                // dd($request->idlocalite);
                $e->email = $request->email;
                $e->designation = $request->designation;
                $e->contact = $request->contact;
                $e->datexpiration = $request->datexpiration;
                $e->identifiant = $request->identifiant;
                $e->idlocalite = $request->idlocalite;
                $e->idsecteur = $request->idsecteur;
                $e->titredirecteur = $request->titredirecteur;
                $e->directeur = $request->directeur;

                if ($e->save()) {
                    if ($id == 0 || $id == null) {
                        //Enregistrement admin de l'abonné
                        $u = new user();
                        // $u->idpersonne = $request->idpersonne;
                        $u->idrole = '5'; //Secrétaire
                        $u->idtypuser = '10'; //Personnel
                        $u->email = $request->email;
                        $u->contact = $request->contact;
                        $u->idabonnement = $e->id;
                        $u->login = $request->identifiant;
                        $hashed = Hash::make('passe');
                        $u->password = $hashed;
                        $u->is_active = true;

                        $u->save();
                    }
                }
                return redirect()->route('abonnement');
            } else {
                $info = "L'abonnement que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('abonnement')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe-type.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $rekete = " ( SELECT id FROM apprenants WHERE idabonnement = '" . $id . "') ";
            $rekete .= " UNION ( SELECT id FROM classannescos WHERE idabonnement = '" . $id . "') ";
            $rekete .= " UNION ( SELECT id FROM coefficients WHERE idabonnement = '" . $id . "') ";
            $rekete .= " UNION ( SELECT id FROM paramfrais WHERE idabonnement = '" . $id . "') ";
            $rekete .= " UNION ( SELECT id FROM subventions WHERE idabonnement = '" . $id . "') ";
            $rekete .= " UNION ( SELECT id FROM users WHERE idabonnement = '" . $id . "') ";
            $v = collect(DB::select($rekete));
            if (count($v) == 0) {
                $e = abonnement::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('abonnement');
            } else {
                $info = "L'abonnement que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('abonnement')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
