<?php

namespace App\Http\Controllers;

use App\Models\sessionacademique;
use Illuminate\Http\Request;
use App\Models\classetype;
use App\Models\composition;
use App\Models\abonnement;
use App\Models\classannesco;
use App\Models\anneescolaire;
use App\Models\moyperiodapprenants;
use App\Models\detailsmoyperiod;
use App\Models\moyenne;
use Illuminate\Support\Facades\DB;



class MoyperiodapprenantsController extends Controller
{

    public function index(Request $request)
    {
        //  dd($request);
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

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));

            $reksession = " SELECT sa.*  FROM sessionacademiques sa,secteurs s, classetypes c,classannescos ca ";
            $reksession .= " WHERE s.id = Sa.idsecteur AND c.secteur =  s.sigle ";
            $reksession .= " AND c.id = ca.idclasse  AND ca.id = '" . $idclassannesco . "' ";
            $reksession .= " ORDER BY libelle ";
            $sessionacad = collect(DB::select($reksession));

            $session = ", COALESCE((SELECT libelle FROM sessionacademiques sa WHERE m.idsession = sa.id ),'') libsession ";

            $rekete = " SELECT m.*, CONCAT(c.libelle, groupe) libclas, ma.libelle libmatiere " . $session;
            $rekete .= " FROM moyperiodapprenants m, classannescos ca , classetypes c, matieres ma ";
            $rekete .= " WHERE m.idclassannesco = ca.id AND ca.idclasse = c.id  AND m.idmatiere = ma.id";
            // $rekete .= " AND ca.idabonnement = '" . $idabonnement . "' AND ca.idanneescolaire = '" . $idanneescolaire . "' ";
            $rekete .= " AND idclassannesco = '" . $idclassannesco . "'";
            $rekete .= " ORDER BY libmatiere, libclas ";
            // dd($rekete);
            $donnees = collect(DB::select($rekete));

            $classes = classetype::orderBy('niveau')->get();

            session(['config' => 'moyenne-periode']);
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
            return redirect()->route('moyenneperiode')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }

    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['conf'] = 'modifier-moyenne-periode';
        return $this->form($request);
    }
    public function formDetails(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['conf'] = 'details-moyenne-periode';
        return $this->form($request);
    }

    public function form(Request $request)
    {

        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        if (isset($_GET['idenreg1']))
            $idenreg = $_GET['idenreg1'];
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $conf = ($request['conf'] != null) ? $request['conf'] : 'ajout-moyenne-periode';
        // $cf = ($modif == true) ? 'modifier-composition' : 'ajout-composition';
        session(['config' => $conf]);

        $idanneescolaire = session('idanneescolaire');
        $idabonnement = session('idabonnement');
        $idclassannesco = session('idclassannesco');
        $idsession = session('idsession');
        $lenregistrement = ($idenreg != null) ? moyperiodapprenants::find($idenreg) : null;

        $idmatieresel = (isset($_GET['idmatiere']) > 0 && $_GET['idmatiere'] != null) ? $_GET['idmatiere'] : ($lenregistrement ? $lenregistrement->idmatiere : null);

        $laclassannesco = classannesco::find($idclassannesco);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);
        $lasession = sessionacademique::find($idsession);
        // dd($idenreg);   detailsmoyperiods   moyperiodapprenants
        //moyennecompo
        //m1	m2	m3	m4	m5	m6	m7	m8	m9	m10	m11	m12	moyenne	idinscription	idcompo	
        $id = ", COALESCE((SELECT id FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'') id ";
        $moyenne = ", COALESCE((SELECT moy FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'-1') moy ";
        $moyinterro = ", COALESCE((SELECT moyinterro FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'-1') moyinterro ";
        $dev1 = ", COALESCE((SELECT dev1 FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'-1') dev1 ";
        $dev2 = ", COALESCE((SELECT dev2 FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'-1') dev2 ";
        $rang = ", COALESCE((SELECT rang FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'') rang ";


        $rekete = "SELECT ins.id idinscription, CONCAT(nom,' ', prenoms) libapprenant " . $id . $moyenne . $moyinterro . $dev1 . $dev2 . $rang;
        for ($i = 1; $i <= 5; $i++) {
            $rekete .= ", COALESCE((SELECT intero" . $i . " FROM detailsmoyperiods d WHERE d.idinscription = ins.id AND idmoyperiod = '" . $idenreg . "' ),'-1') intero" . $i . " ";
        }

        $rekete .= " FROM inscriptions ins, apprenants a, personnes p ";
        $rekete .= " WHERE ins.idapprenant = a.id AND p.id = a.idpersonne";
        $rekete .= " AND idclassannesco = '" . $idclassannesco . "'";
        $rekete .= " ORDER BY libapprenant ";
        // dd($rekete);
        $donnees = collect(DB::select($rekete));

        $rekmat = "SELECT m.*, coef, rang FROM matieres m, coefficients c ";
        $rekmat .= " WHERE m.id = c.idmatiere AND idabonnement = '" . $idabonnement . "' ";
        $rekmat .= " AND  idclasse = '" . $laclassannesco->idclasse . "' ";
        $rekmat .= " ORDER BY rang ";
        $matieres = collect(DB::select($rekmat));

        // 
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
            'idmatieresel'
        ));
    }
    public function enregistrer(Request $request)
    {
        //  dd($request);
        try {
            $route = 'moyenneperiode';
            //Revoir cette partie
            if ((session('module') != null) && session('module') == 'compositionAbonne') {
                $route = 'classeAbonne';
                session(['module' => 'listeCompositionAbonne']);
            }

            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = moyperiodapprenants::where('idclassannesco', $request->idclassannesco)
                    ->where('idsession', $request->idsession)
                    ->where('idmatiere', $request->idmatiere)->get();
                $e = new moyperiodapprenants();
            } else {
                $doub = moyperiodapprenants::where('idmatiere', $request->idmatiere)
                    ->where('idclassannesco', $request->idclassannesco)
                    ->where('idsession', $request->idsession)
                    ->where('id', '!=', $id)
                    ->get();
                $e = moyperiodapprenants::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //libelle	datcomposition	barem	idclassannesco	idmatiere	idetat

                validerMoyPeriodeParMatiere($request);

                return redirect()->route($route);
            } else {
                $info = "La moyenne que vous tentez d'enregistrer existe déjà";
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

    public function moyenneperiodeapprenant(Request $request)
    {
        try {
            //  dd($request);

            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idclassannesco = (count($_GET) > 0 && $_GET['idclassannesco'] != null) ? $_GET['idclassannesco'] : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = (count($_GET) > 0 && $_GET['idanneescolaire'] != null) ? $_GET['idanneescolaire'] : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));
            $idsession = (count($_GET) > 0 && $_GET['idsession'] != null) ? $_GET['idsession'] : (session('idsession') != null ? session('idsession') : null);
            $idinscription = (count($_GET) > 0 && $_GET['idinscription'] != null) ? $_GET['idinscription'] : (session('idinscription') != null ? session('idinscription') : null);
            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            session(['idsession' => $idsession]);
            session(['idinscription' => $idinscription]);

            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));

            $reksession = " SELECT sa.*  FROM sessionacademiques sa,secteurs s, classetypes c,classannescos ca ";
            $reksession .= " WHERE s.id = Sa.idsecteur AND c.secteur =  s.sigle ";
            $reksession .= " AND c.id = ca.idclasse  AND ca.id = '" . $idclassannesco . "' ";
            $reksession .= " ORDER BY libelle ";
            $sessionacad = collect(DB::select($reksession));

            $apprenants = apprenantsParClassannesco($idclassannesco);
            // dd($apprenants);

            $lamoyenne = moyenne::where('idclassannesco', $idclassannesco)->first();
            // dd($lamoyenne );
            //    if($lamoyenne != null) dd($lamoyenne->id );
            $idenreg = ($lamoyenne != null) ? $lamoyenne->id : (($request['idenreg'] != null) ? $request['idenreg'] : null);

            $iddetailsmoyenne = infoParRekete("SELECT dm.id FROM detailsmoyennes dm, moyennes my  WHERE dm.idmoyenne = my.id AND  idinscription = '" . $idinscription . "'", 'id');


            //  $id = ", COALESCE((SELECT dm.id FROM detailsmoyennes dm, moyennes my  WHERE dm.idmoyenne = my.id AND  idinscription = '" . $idinscription . "'   ),'') id ";
            $id = ", COALESCE((SELECT dm.id FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'') id ";
            $moyintero = ", COALESCE((SELECT moyinterro FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'') moyinterro ";
            $dev1 = ", COALESCE((SELECT dev1 FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'') dev1 ";
            $dev2 = ", COALESCE((SELECT dev2 FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'') dev2 ";
            $moy = ", COALESCE((SELECT moy FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'') moy ";
            $moycoef = ", (COALESCE((SELECT moy FROM detailsmoyperiods dm, moyperiodapprenants mp  WHERE dm.idmoyperiod = mp.id AND mp.idmatiere = m.id AND idinscription = '" . $idinscription . "' AND idsession = '" . $idsession . "'  ),'1') * coef)  moycoef ";

            $rekete = " SELECT m.id idmatiere, libelle , coef, rang " . $moyintero . $dev1 . $dev2 . $moy . $moycoef . $id;
            $rekete .= " FROM matieres m, coefficients co, classannescos  ca";
            $rekete .= " WHERE m.id = co.idmatiere AND co.idabonnement = ca.idabonnement AND co.idclasse = ca.idclasse ";
            $rekete .= " AND ca.id = '" . $idclassannesco . "' ";
            $rekete .= "";

            $rekete .= " ORDER BY rang ";
            // dd($rekete);
            // dd($idinscription);
            $donnees = collect(DB::select($rekete));

            $laclassannesco = classannesco::find($idclassannesco);
            $lannesco = anneescolaire::find($idanneescolaire);

            //dd($donnees);
            session(['config' => 'moyenne-periode-apprenant']);
            return view('formMoyApprenantPeriode', compact(
                'donnees',
                'abonnements',
                'idenreg',
                'idabonnement',
                'annescolaires',
                'idanneescolaire',
                'lannesco',
                'classannescos',
                'idclassannesco',
                'laclassannesco',
                'idsession',
                'sessionacad',
                'apprenants',
                'idinscription',
                'iddetailsmoyenne',
            ));
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('moyenneperiodeapprenant')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }

    public function moyennegeneraleperiode(Request $request)
    {

        try {
            //   dd($request);

            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idclassannesco = (count($_GET) > 0 && $_GET['idclassannesco'] != null) ? $_GET['idclassannesco'] : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = (count($_GET) > 0 && $_GET['idanneescolaire'] != null) ? $_GET['idanneescolaire'] : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));
            $idsession = (count($_GET) > 0 && $_GET['idsession'] != null) ? $_GET['idsession'] : (session('idsession') != null ? session('idsession') : null);
            // $idinscription = (count($_GET) > 0 && $_GET['idinscription'] != null) ? $_GET['idinscription'] : (session('idinscription') != null ? session('idinscription') : null);
            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            session(['idsession' => $idsession]);
            // session(['idinscription' => $idinscription]);

            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));

            $reksession = " SELECT sa.*  FROM sessionacademiques sa,secteurs s, classetypes c,classannescos ca ";
            $reksession .= " WHERE s.id = Sa.idsecteur AND c.secteur =  s.sigle ";
            $reksession .= " AND c.id = ca.idclasse  AND ca.id = '" . $idclassannesco . "' ";
            $reksession .= " ORDER BY libelle ";
            $sessionacad = collect(DB::select($reksession));

            $matieres = matieresParClassannesco($idclassannesco);
            //    dd($matieres);
            $rekete = "SELECT ins.id idinscription, CONCAT(nom,' ', prenoms) libapprenant "; //. $moyenne . $moyinterro . $dev1 . $dev2 . $rang;
            // $som = 0;
            // $somcoef = 0;
            foreach ($matieres as $i => $m) {
                $ma = ", COALESCE((SELECT moy FROM detailsmoyperiods d, moyperiodapprenants mo WHERE d.idinscription = ins.id AND d.idmoyperiod = mo.id AND idsession = '" . $idsession . "' AND idclassannesco = '" . $idclassannesco . "' AND idmatiere = '" . $m->id . "' ),'-1')  m" . $i;
                // $som += (floatval($ma) * $m->coef);
                // $somcoef += $m->coef;
                $rekete .= $ma . "," . $m->coef . " coef" . $i;

            }
            $id = ", COALESCE((SELECT dm.id FROM detailsmoyennes dm, moyennes mp  WHERE dm.idmoyenne = mp.id AND idinscription = ins.id  ),'') id ";
            $rekete .= $id; //. ",".$som ." total ". ",".$somcoef ." somcoef ";
            $rekete .= " FROM inscriptions ins, apprenants a, personnes p ";
            $rekete .= " WHERE ins.idapprenant = a.id AND p.id = a.idpersonne";
            $rekete .= " AND idclassannesco = '" . $idclassannesco . "'";
            $rekete .= " ORDER BY libapprenant ";

            //  dd($rekete);

            $rekete .= "";


            $donnees = collect(DB::select($rekete));

            // $donnees = array();
            foreach ($donnees as $key => $v) {
                $som = 0;
                $somcoef = 0;
                foreach ($matieres as $i => $m) {
                    $vc = "m" . $i;
                    $coefc = "coef" . $i;
                    if (floatval($v->$vc) > 0) {
                        $som += (floatval($v->$vc) * $m->coef);
                        $somcoef += $m->coef;
                    }
                }
                $moy = $somcoef > 0 ? ($som / $somcoef) : -1;
                $donnees[$key]->somcoef = $somcoef;
                $donnees[$key]->somMoycoef = $som;
                $donnees[$key]->moy = round($moy, 2);
            }

            $d = $donnees->ToArray();
            // dd($d);

            $moys = array_column($d, 'moy');
            array_multisort($moys, SORT_DESC, $d);

            $laclassannesco = classannesco::find($idclassannesco);
            $lannesco = anneescolaire::find($idanneescolaire);

            foreach ($donnees as $k => $d) {
                if ($d->moy > 0)
                    $donnees[$k]->rang = array_search($d->moy, $moys) + 1;
                else
                    $donnees[$k]->rang = '';
            }

            // dd($donnees);
            session(['config' => 'moyenne-generale-periode']);
                // L'instance PDF avec la vue resources/views/print/listePortrait.blade.php


            return view('formMoyApprenantPeriode', compact(
                'donnees',
                'abonnements',
                'idabonnement',
                'annescolaires',
                'idanneescolaire',
                'lannesco',
                'classannescos',
                'idclassannesco',
                'laclassannesco',
                'idsession',
                'sessionacad',
                'matieres',

            ));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('moyenneperiodeapprenant')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }
}

