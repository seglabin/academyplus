<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classetype;
use App\Models\classannesco;
use App\Models\abonnement;
use App\Models\apprenant;
use App\Models\paiement;
use Illuminate\Support\Facades\DB;
use App\Models\anneescolaire;
use App\Models\composition;
use App\Models\personne;

class ClassannescoController extends Controller
{
    public function index(Request $request)
    {
        //  dd($request);
        try {

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));
            $idabonnement = ($request->idabonnement) ? $request->idabonnement : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idanneescolaire = ($request->idanneescolaire) ? $request->idanneescolaire : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));
            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekete = "SELECT ca.*, CONCAT(andebut,' - ',(andebut+1)) libannee, designation,niveau, libelle ";
            $rekete .= " FROM classannescos ca, anneescolaires a, abonnements ab, classetypes c ";
            $rekete .= " WHERE ca.idanneescolaire = a.id AND ca.idabonnement = ab.id AND ca.idclasse = c.id ";
            $rekete .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "'";
            $rekete .= " ORDER BY niveau, groupe ";
            $donnees = collect(DB::select($rekete));


            session(['config' => 'classannesco']);
            return view('liste', compact(
                'donnees',
                'annescolaires',
                'abonnements',
                'idabonnement',
                'idanneescolaire'
            ));
        } catch (\Exception $e) {
            return redirect()->route('classannesco')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }

    public function classeAbonne(Request $request)
    {
        //  dd($request);
        //   dd($_GET);
        try {
            $donnees = array();
            $apprenants = array();
            $matieres = array();
            $motifs = array();
            $leget = $_GET;
            //$changeAnSel = (isset($_GET['changeAnSel']) && $_GET['changeAnSel'] != null) ? $_GET['changeAnSel'] : null;
            $idenreg = (isset($_GET['idenreg']) && $_GET['idenreg'] != null) ? $_GET['idenreg'] : (session('idenreg') != null ? session('idenreg') : null);
            $module = (isset($_GET['module']) && $_GET['module'] != null) ? $_GET['module'] : (session('module') != null ? session('module') : 'listeApprenant');
            $idclas = (isset($_GET['idclassannescosEncours']) > 0 && $_GET['idclassannescosEncours'] != null) ? $_GET['idclassannescosEncours'] : (session('idclassannescosEncours') != null ? session('idclassannescosEncours') : null);
            session(['idclassannescosEncours' => $idclas]);
            session(['module' => $module]);
            session(['idenreg' => $idenreg]);
            $lenregistrement = null;
            $lapersonne = null;

            // $idanSel = (isset($_GET['idanSel']) > 0 && $_GET['idanSel'] != null) ? $_GET['idanSel'] : (session('idanEncours') != null ? session('idanEncours') : null);
            // // dd($idanSel);
            // session(['idanEncours' => $idanSel]);
            $idabonnement = session('idabonnementEncours');

            if ($idclas) {
                $clas = classannesco::find($idclas);
                // dd($clas);
                session(['idanneescolaire' => $clas->idanneescolaire]);
                session(['idabonnement' => $clas->idabonnement]);
                session(['idclassannescosEncours' => $idclas]);
                session(['laclassEncour' => $clas]);
                $idanneescolaire = $clas->idanneescolaire;
                $rekete = "";

                switch ($module) {
                    case 'inscriptionAbonne':
                        $lenregistrement = apprenant::where('id', $idenreg)->first();

                        if (isset($_GET['matricule'])) {
                            $lenregistrement = apprenant::where('matricule', $_GET['matricule'])->first();
                        }
                        $lapersonne = ($lenregistrement != null && $lenregistrement->idpersonne != 0) ? personne::find($lenregistrement->idpersonne) : null;
                        if (isset($_GET['npi']) && $_GET['npi'] != "") {
                            $lapersonne = personne::where('npi', $_GET['npi'])->first();
                        }

                        break;
                    case 'paiementAbonne':
                        $rekappr = "SELECT ins.*, CONCAT(nom,' ', prenoms) libapprenant ";
                        $rekappr .= " FROM inscriptions ins, apprenants a, personnes pe ";
                        $rekappr .= " WHERE ins.idapprenant = a.id  AND pe.id = a.idpersonne AND idclassannesco = '" . $idclas . "' ";
                        $rekappr .= " ORDER BY libapprenant ";
                        $apprenants = collect(DB::select($rekappr));

                        $rekmotif = " SELECT * FROM elements WHERE nomtable = 'motif' AND lecas = 'PAIEMENT' ORDER BY libelle ";
                        $motifs = collect(DB::select($rekmotif));

                        $lenregistrement = ($idenreg != null) ? paiement::find($idenreg) : null;
                        break;
                    case 'compositionAbonne':
                        $lenregistrement = ($idenreg != null) ? composition::find($idenreg) : null;

                        $id = ", COALESCE((SELECT id FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') id ";
                        $moyenne = ", COALESCE((SELECT moyenne FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'-1') moyenne ";
                        $m1 = ", COALESCE((SELECT m1 FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') m1 ";


                        $rekete = "SELECT ins.id idinscription, CONCAT(nom,' ', prenoms) libapprenant " . $id . $moyenne;
                        for ($i = 1; $i <= 12; $i++) {
                            $rekete .= ", COALESCE((SELECT m" . $i . " FROM moyennecompos m WHERE m.idinscription = ins.id AND idcompo = '" . $idenreg . "' ),'') m" . $i . " ";
                        }
                        $laclassannesco = classannesco::find($idclas);
                        $rekete .= " FROM inscriptions ins, apprenants a, personnes p ";
                        $rekete .= " WHERE ins.idapprenant = a.id   AND p.id = a.idpersonne";
                        $rekete .= " AND idclassannesco = '" . $idclas . "'";
                        $rekete .= " ORDER BY libapprenant ";
                        $donnees = collect(DB::select($rekete));
                        //  dd($rekete);

                        $rekmat = "SELECT m.*, coef, rang FROM matieres m, coefficients c ";
                        $rekmat .= " WHERE m.id = c.idmatiere  ";
                        $rekmat .= " AND  idclasse = '" . $laclassannesco->idclasse . "' ";
                        $rekmat .= " ORDER BY rang ";
                        $matieres = collect(DB::select($rekmat));

                        break;
                    case 'listePaiementAbonnement':
                        $rekete = "SELECT p.*, CONCAT(nom,' ', prenoms) libapprenant, libelle libmotif ";
                        $rekete .= " FROM paiements p, inscriptions ins, apprenants a, elements e, personnes pe ";
                        $rekete .= " WHERE p.idinscription = ins.id AND ins.idapprenant = a.id AND e.id = p.idmotif ";
                        $rekete .= " AND pe.id = a.idpersonne AND idclassannesco = '" . $idclas . "'";
                        $rekete .= " ORDER BY datepaiement ";
                        break;

                    case 'listeCompositionAbonne':
                        $rekete = " SELECT ev.*, CONCAT(c.libelle, ' ', COALESCE(groupe, '')) libclas ";
                        $rekete .= " FROM compositions ev, classannescos ca , classetypes c ";
                        $rekete .= " WHERE ev.idclassannesco = ca.id AND ca.idclasse = c.id  ";
                        $rekete .= " AND ca.idabonnement = '" . $idabonnement . "' AND ca.idanneescolaire = '" . $idanneescolaire . "' ";
                        $rekete .= " AND idclassannesco = '" . $idclas . "'";
                        $rekete .= " ORDER BY datecompo, libclas ";
                        break;

                    case 'listeApprenant':
                        // $rekete = " SELECT a.*, CONCAT(nom, ' ', prenoms) libapprenant ";
                        $clas = ", COALESCE((SELECT CONCAT(c.libelle, ' ', COALESCE(groupe, '')) FROM classetypes c, classannescos ca, inscriptions ins WHERE c.id = ca.idclasse AND ins.idclassannesco = ca.id AND ins.idapprenant= a.id ORDER BY ins.id DESC LIMIT 1 ),'') classeactuelle ";
                        $totscolarite = " COALESCE((SELECT fraiscolarite FROM paramfrais p, classetypes c, classannescos ca, inscriptions ins WHERE c.id = p.idclassetype AND p.idannesco = '" . $idanneescolaire . "' AND p.idabonnement = '" . $idabonnement . "' LIMIT 1 ),'0')  ";
                        $totpaie = " COALESCE((SELECT SUM(montant) FROM paiements p, inscriptions ins WHERE ins.id = p.idinscription AND ins.idapprenant= a.id GROUP BY p.idinscription ORDER BY ins.id ),'0')  ";

                        $idinscription = ", COALESCE((SELECT ins.id FROM inscriptions ins WHERE  ins.idapprenant= a.id ORDER BY ins.id  LIMIT 1),'') idinscription ";
                        $sexe = ", COALESCE((SELECT libelle FROM elements e  WHERE e.id = p.idsexe),'') sexe ";
                        $clas = ", COALESCE((SELECT CONCAT(c.sigle, ' ', COALESCE(groupe, '')) FROM classetypes c, classannescos ca, inscriptions ins WHERE c.id = ca.idclasse AND ins.idclassannesco = ca.id AND ins.idapprenant= a.id ORDER BY ins.id DESC LIMIT 1 ),'') classeactuelle ";
                        $libclas = ", COALESCE((SELECT CONCAT(c.libelle, ' ', COALESCE(groupe, '')) FROM classetypes c, classannescos ca, inscriptions ins WHERE c.id = ca.idclasse AND ins.idclassannesco = ca.id AND ins.idapprenant= a.id ORDER BY ins.id DESC LIMIT 1 ),'') libclasseactuelle ";

                        $rekete = " SELECT a.*, npi, nom, prenoms, contactparent,photo, CONCAT(nom, ' ', prenoms) libapprenant  " . $idinscription . $clas . ',' . $totpaie . ' totpaye,' . $totscolarite . ' totscolarite ,(' . $totscolarite . '-' . $totpaie . ') reste ' . $sexe. $clas.$libclas;

                        $rekete .= " FROM apprenants a, inscriptions ins, personnes p ";
                        $rekete .= " WHERE a.id = ins.idapprenant AND p.id = a.idpersonne AND idclassannesco = '" . $idclas . "' ";
                        // $rekete .= " GROUP BY a.id ";
                        $rekete .= " ORDER BY libapprenant ";
                        break;

                    default:
                        # code...
                        break;
                }


                // dd($rekete);
                if ($rekete != "")
                    $donnees = collect(DB::select($rekete));
                //  dd($donnees);



            }

            // dd($module);

            session(['config' => 'classeAbonne']);
            return view('Abonnes.listeClasse', compact(
                'donnees',
                'idabonnement',
                'idanneescolaire',
                'lenregistrement',
                'module',
                'leget',
                'apprenants',
                'motifs',
                'matieres',
                'lapersonne'

            ));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('home')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'classannesco']);
        // $classetypes = classetype::orderBy('niveau')->get();
        $idanneescolaire = session('idanneescolaire');
        $idabonnement = session('idabonnement');

        $classetypes = classetypeParAbonne($idabonnement);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);


        $lenregistrement = ($idenreg != null) ? classannesco::find($idenreg) : null;
        return view('formConfiguration', compact(
            'lenregistrement',
            'idenreg',
            'classetypes',
            'idanneescolaire',
            'idabonnement',
            'labonnement',
            'lannesco'
        ));
    }


    public function enregistrer(Request $request)
    { //dd($request);
        try {
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = classannesco::where('idabonnement', $request->idabonnement)
                    ->where('idclasse', $request->idclasse)
                    ->where('idanneescolaire', $request->idanneescolaire)
                    ->where('groupe', $request->groupe)->get();
                $e = new classannesco();
            } else {
                $doub = classannesco::where('idabonnement', $request->idabonnement)
                    ->where('idclasse', $request->idclasse)
                    ->where('idanneescolaire', $request->idanneescolaire)
                    ->where('groupe', $request->groupe)
                    ->where('id', '!=', $id)
                    ->get();
                $e = classannesco::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //`idabonnement`, `idclasse`, `idanneescolaire`,
                $e->idabonnement = $request->idabonnement;
                $e->idclasse = $request->idclasse;
                $e->idanneescolaire = $request->idanneescolaire;
                $e->groupe = $request->groupe;

                $e->save();//die();
                return redirect()->route('classannesco');
            } else {
                $info = "La classe année scolaire que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('classannesco')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            //Controle de possibilité de suppression
            $v = classannesco::where('idclasse', $id)->get();
            if (count($v) == 0) {
                $e = classetype::findOrFail($id);
                //dd($e);
                $e->delete();

                return redirect()->route('classannesco');
            } else {
                $info = "La classe-type que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('classannesco')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
