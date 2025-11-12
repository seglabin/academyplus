<?php

namespace App\Http\Controllers;

use App\Models\sessionacademique;
use Illuminate\Http\Request;
use App\Models\classetype;
use App\Models\composition;
use App\Models\abonnement;
use App\Models\classannesco;
use App\Models\anneescolaire;
use App\Models\moyennecompo;
use Illuminate\Support\Facades\DB;

class CompositionController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        try {

            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idclassannesco = (count($_GET) > 0 && $_GET['idclassannesco'] != null) ? $_GET['idclassannesco'] : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = (count($_GET) > 0 && $_GET['idanneescolaire'] != null) ? $_GET['idanneescolaire'] : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));
            $idsession = (count($_GET) > 0 && $_GET['idsession'] != null) ? $_GET['idsession'] : (session('idsession') != null ? session('idsession') : null);

            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            session(['idsession' => $idsession]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',COALESCE(groupe, '')) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));

            $reksession = " SELECT sa.*  FROM sessionacademiques sa,secteurs s, classetypes c,classannescos ca ";
            $reksession .= " WHERE s.id = Sa.idsecteur AND c.secteur =  s.sigle ";
            $reksession .= " AND c.id = ca.idclasse  AND ca.id = '" . $idclassannesco . "' ";
            $reksession .= " ORDER BY libelle ";
            $sessionacad = collect(DB::select($reksession));

            $session = ", COALESCE((SELECT libelle FROM sessionacademiques sa WHERE ev.idsession = sa.id ),'') libsession ";

            $rekete = " SELECT ev.*, CONCAT(c.libelle, ' ', COALESCE(groupe, '')) libclas " .$session;
            $rekete .= " FROM compositions ev, classannescos ca , classetypes c ";
            $rekete .= " WHERE ev.idclassannesco = ca.id AND ca.idclasse = c.id  ";
            $rekete .= " AND ca.idabonnement = '" . $idabonnement . "' AND ca.idanneescolaire = '" . $idanneescolaire . "' ";
            $rekete .= " AND idclassannesco = '" . $idclassannesco . "'";
            $rekete .= " ORDER BY datecompo, libclas ";
            // dd($rekete);
            $donnees = collect(DB::select($rekete));

            $classes = classetype::orderBy('niveau')->get();

            session(['config' => 'composition']);
            return view('liste', compact(
                'donnees',
                'abonnements',
                'idabonnement',
                'annescolaires',
                'idanneescolaire',
                'classannescos',
                'idclassannesco',
                'idsession',
                'sessionacad',
            ));
        } catch (\Exception $e) {
            return redirect()->route('composition')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }

    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['conf'] = 'modifier-composition';
        return $this->form($request);
    }
    public function formDetails(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['conf'] = 'details-composition';
        return $this->form($request);
    }

    public function form(Request $request)
    {

        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $conf = ($request['conf'] != null) ? $request['conf'] : 'ajout-composition';
        // $cf = ($modif == true) ? 'modifier-composition' : 'ajout-composition';
        session(['config' => $conf]);
        $idanneescolaire = session('idanneescolaire');
        $idabonnement = session('idabonnement');
        // $idclassannesco = session('idclassannesco');
        $idsession = session('idsession');
        $lenregistrement = ($idenreg != null) ? composition::find($idenreg) : null;

         $idclassannesco = ($lenregistrement != null) ? $lenregistrement->idclassannesco : (session('idclassannesco') != null ? session('idclassannesco') : null);

        $laclassannesco = classannesco::find($idclassannesco);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);
        $lasession = sessionacademique::find($idsession);
        // dd($idclassannesco);
        //moyennecompo
        //m1	m2	m3	m4	m5	m6	m7	m8	m9	m10	m11	m12	moyenne	idinscription	idcompo	
        $id = ", COALESCE((SELECT id FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') id ";
        $moyenne = ", COALESCE((SELECT moyenne FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'-1') moyenne ";
        $m1 = ", COALESCE((SELECT m1 FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') m1 ";


        $rekete = "SELECT ins.id idinscription, CONCAT(nom,' ', prenoms) libapprenant, ' ' rang " . $id . $moyenne;
        for ($i = 1; $i <= 12; $i++) {
            $rekete .= ", COALESCE((SELECT m" . $i . " FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') m" . $i . " ";
        }

        $rekete .= " FROM inscriptions ins, apprenants a, personnes p ";
        $rekete .= " WHERE ins.idapprenant = a.id AND a.idpersonne = p.id ";
        $rekete .= " AND idclassannesco = '" . $idclassannesco . "'";
        $rekete .= " ORDER BY libapprenant ";
        $donnees = collect(DB::select($rekete));
        //   dd($rekete);

        $rekmat = "SELECT m.*, coef, rang FROM matieres m, coefficients c ";
        $rekmat .= " WHERE m.id = c.idmatiere AND idabonnement = '" . $idabonnement . "' ";
        if(isset($laclassannesco->idclasse)) $rekmat .= " AND  idclasse = '" . $laclassannesco->idclasse . "' ";
        $rekmat .= " ORDER BY rang ";
        $matieres = collect(DB::select($rekmat));
        //dd($rekmat);
        //dd(count($matieres));
// dd($conf);
        return view('formScolarite', compact(
            'lenregistrement',
            'idenreg',
            'idclassannesco',
            'laclassannesco',
            'labonnement',
            'lannesco',
            'idanneescolaire',
            'idabonnement',
            'donnees',
            'matieres',
            'idsession',
            'lasession',
        ));
    }

    public function enregistrer(Request $request)
    {
        // dd($request);
        try {
            $route = 'composition';
            //dd(session('module'));
            if ((session('module') != null) && session('module') == 'compositionAbonne') {
                $route = 'classeAbonne';
                session(['module' => 'listeCompositionAbonne']);
            }
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = composition::where('idclassannesco', $request->idclassannesco)
                    ->where('idsession', $request->idsession)
                    ->where('libelle', $request->libelle)->get();
                $e = new composition();
            } else {
                $doub = composition::where('libelle', $request->libelle)
                    ->where('idclassannesco', $request->idclassannesco)
                    ->where('idsession', $request->idsession)
                    ->where('id', '!=', $id)
                    ->get();
                $e = composition::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //libelle	datcomposition	barem	idclassannesco	idmatiere	idetat
                $e->libelle = $request->libelle;
                $e->idclassannesco = $request->idclassannesco;
                $e->datecompo = $request->datecompo;
                $e->barem = $request->barem;
                $e->idsession = $request->idsession;

                $e->save();//die();
                if ($e) {
                    # Enregistrement de moyennecompos
                    #m1	m2	m3	m4	m5	m6	m7	m8	m9	m10	m11	m12	moyenne	idinscription	idcompo
                    $nb = $request->taille;
                    if ($nb > 0) {
                        # code...
                        for ($i = 0; $i < $nb; $i++) {
                            # code...
                            $v = "id" . $i;
                            $idm = $request->$v;
                            $m = ($idm == 0 || $idm == null) ? new moyennecompo() : moyennecompo::find($idm);
                            if ($m) {
                                $m->idcompo = $e->id;
                                $v = "idinscription" . $i;
                                $m->idinscription = $request->$v;
                                $v = "moyenne" . $i;
                                $m->moyenne = $request->$v;
                                for ($j = 1; $j <= 12; $j++) {
                                    # code...
                                    $v = "m" . $j . '_' . $i;
                                    $col = "m" . $j;
                                    $m->$col = $request->$v;
                                }
                                $m->save();
                            }
                        }
                    }
                }

                return redirect()->route($route);
            } else {
                $info = "La composition que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            $e = composition::findOrFail($id);
            //dd($e);
            $e->delete();

            return redirect()->route('composition');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('composition')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
