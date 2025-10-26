<?php

namespace App\Http\Controllers;

use App\Models\element;
use Illuminate\Http\Request;
use App\Models\apprenant;
use App\Models\classannesco;
use App\Models\classetype;
use App\Models\abonnement;
use App\Models\anneescolaire;
use App\Models\inscription;
use App\Models\moyennecompo;
use App\Models\personne;
use Illuminate\Support\Facades\DB;

class ApprenantController extends Controller
{
    public function index(Request $request)
    {
        //    dd(count($_GET));
        try {

            $idabonnement = (count($_GET) > 0 && $_GET['idabonnement'] != null) ? $_GET['idabonnement'] : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            $idclassannesco = (count($_GET) > 0 && $_GET['idclassannesco'] != null) ? $_GET['idclassannesco'] : (session('idclassannesco') != null ? session('idclassannesco') : null);
            $idanneescolaire = (count($_GET) > 0 && $_GET['idanneescolaire'] != null) ? $_GET['idanneescolaire'] : (session('idanneescolaire') != null ? session('idanneescolaire') : session('idanEncours'));

            session(['idanneescolaire' => $idanneescolaire]);
            session(['idabonnement' => $idabonnement]);
            session(['idclassannesco' => $idclassannesco]);
            $abonnements = abonnement::orderBy('designation')->get();

            $rekan = " SELECT a.*, CONCAT(andebut,' - ',(andebut+1)) AS libannee FROM anneescolaires a ORDER BY andebut ";
            $annescolaires = collect(DB::select($rekan));

            $rekclas = " SELECT ca.*,libelle, sigle, CONCAT(libelle,' ',groupe) AS libclasse  FROM classannescos ca,classetypes c";
            $rekclas .= " WHERE c.id = ca.idclasse ";
            $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idanneescolaire . "' ";
            $rekclas .= " ORDER BY libclasse ";
            $classannescos = collect(DB::select($rekclas));

            $sexe = ", COALESCE((SELECT libelle FROM elements e  WHERE e.id = pe.idsexe),'') sexe ";
            $clas = ", COALESCE((SELECT CONCAT(c.sigle, ' ', groupe) FROM classetypes c, classannescos ca, inscriptions ins WHERE c.id = ca.idclasse AND ins.idclassannesco = ca.id AND ins.idapprenant= a.id ORDER BY ins.id DESC LIMIT 1 ),'') classeactuelle ";
            $libclas = ", COALESCE((SELECT CONCAT(c.libelle, ' ', groupe) FROM classetypes c, classannescos ca, inscriptions ins WHERE c.id = ca.idclasse AND ins.idclassannesco = ca.id AND ins.idapprenant= a.id ORDER BY ins.id DESC LIMIT 1 ),'') libclasseactuelle ";
            $totscolarite = " COALESCE((SELECT fraiscolarite FROM paramfrais p, classetypes c, classannescos ca, inscriptions ins WHERE c.id = p.idclassetype AND p.idannesco = '" . $idanneescolaire . "' AND p.idabonnement = '" . $idabonnement . "' LIMIT 1 ),'0')  ";
            $totpaie = " COALESCE((SELECT SUM(montant) FROM paiements p, inscriptions ins WHERE ins.id = p.idinscription AND ins.idapprenant= a.id ORDER BY ins.id ),'0')  ";
            $idinscription = ", COALESCE((SELECT ins.id FROM inscriptions ins WHERE  ins.idapprenant= a.id ORDER BY ins.id  LIMIT 1),'') idinscription ";

            $rekete = " SELECT a.*, npi, nom, prenoms, contactparent , CONCAT(nom, ' ', prenoms) libapprenant, photo  " . $idinscription . $clas.$libclas. $sexe . ',' . $totpaie . ' totpaye,' . $totscolarite . ' totscolarite ,(' . $totscolarite . '-' . $totpaie . ') reste ';
            $rekete .= "FROM apprenants a, personnes pe WHERE a.idpersonne = pe.id";
            if ($idclassannesco != null && $idclassannesco != 0) {
                $rekete .= " AND a.id IN ( SELECT idapprenant FROM inscriptions WHERE idclassannesco = '" . $idclassannesco . "' ) ";
            } else {

                if ($idabonnement != null && $idanneescolaire != null && $idabonnement != 0 && $idanneescolaire != 0) {
                    $rekete .= " AND a.id IN ( SELECT idapprenant FROM inscriptions WHERE idclassannesco  IN (SELECT id FROM classannescos WHERE idabonnement= '" . $idabonnement . "' AND idanneescolaire= '" . $idanneescolaire . "' )) ";
                } else {
                    $rekete .= " AND (a.id IN ( SELECT idapprenant FROM inscriptions WHERE idclassannesco  IN (SELECT id FROM classannescos WHERE idanneescolaire= '" . $idanneescolaire . "' )) OR idabonnement= '" . $idabonnement . "' ) ";
                }

            }

            $rekete .= " ORDER BY nom, prenoms ";
            //    dd($rekete);
            $donnees = collect(DB::select($rekete));

            session(['config' => 'apprenant']);
            return view('liste', compact(
                'donnees',
                'abonnements',
                'annescolaires',
                'idanneescolaire',
                'idclassannesco',
                'idabonnement',
                'classannescos'
            ));
        } catch (\Exception $e) {
            return redirect()->route('apprenant')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }


    public function formModif(Request $request, $id)
    {
        $request['idenreg'] = $id;
        $request['modif'] = true;


        return $this->form($request);
    }

    public function form(Request $request)
    {
        // dd($request);
        $idenreg = ($request['idenreg'] != null) ? $request['idenreg'] : null;
        $modif = ($request['modif'] != null) ? $request['modif'] : false;
        $lenregistrement = ($idenreg != null) ? apprenant::find($idenreg) : null;

        $lapersonne = ($lenregistrement != null && $lenregistrement->idpersonne != 0) ? $lenregistrement->personne() : null;

        $leget = $_GET;
        //  dd($_GET);
        if (isset($_GET['matricule']) && $_GET['matricule'] != "") {
            $lenregistrement = apprenant::where('matricule', $_GET['matricule'])->first();
            $lapersonne = ($lenregistrement != null && $lenregistrement->idpersonne != 0) ? $lenregistrement->personne() : null;

        }
        if (isset($_GET['npi']) && $_GET['npi'] != "") {
            $lapersonne = personne::where('npi', $_GET['npi'])->first();
        }
        //         dd($lapersonne);
// dd($lapersonne->getParent()->idpersonne);
        $cf = ($modif == true) ? 'modifier-apprenant' : 'ajout-apprenant';
        session(['config' => $cf]);
        $idanneescolaire = session('idanneescolaire');
        $idabonnement = session('idabonnement');
        $idclassannesco = session('idclassannesco');

        $photo = '';
        if ($lenregistrement) {
            $photo = 'storage/images/Personnes/' . $lenregistrement->photo;
            $idabonnement = $lenregistrement->idabonnement;
            // dd($photo);
        }

        $inscription = inscription::where('idapprenant', $idenreg)->latest('id')->first();
        if ($inscription) {
            //    dd($inscription);
            $idclassannesco = $inscription->idclassannesco;
            $laclassannesco = classannesco::find($idclassannesco);
            $idanneescolaire = $laclassannesco->idanneescolaire;
        }

        $laclassannesco = classannesco::find($idclassannesco);
        $labonnement = abonnement::find($idabonnement);
        $lannesco = anneescolaire::find($idanneescolaire);
        // dd(123);

        $sexes = element::where('nomtable', 'sexe')
            ->orderBy('libelle')->get();

        $nationalites = element::where('nomtable', 'nationalite')
            ->orderBy('libelle')->get();
        $abonnements = abonnement::orderBy('designation')->get();
        $classannescos = classannesco::orderBy('id')->get();
        $annescolaires = DB::table('anneescolaires')
            ->select('id', 'andebut', DB::raw('CONCAT(andebut," - ",(andebut+1)) AS libannee'))
            ->get();
        $classannescos = DB::table('classannescos')
            ->join('classetypes', 'classannescos.idclasse', '=', 'classetypes.id')
            ->where('idanneescolaire', $idanneescolaire)
            ->where('idabonnement', $idabonnement)
            ->select('classannescos.*', 'libelle', 'sigle', DB::raw('CONCAT(libelle," ",groupe) AS libclasse'))
            ->get();

        // dd($idclassannesco);
        return view('formScolarite', compact(
            'lenregistrement',
            'idenreg',
            'classannescos',
            'abonnements',
            'annescolaires',
            'idanneescolaire',
            'idabonnement',
            'sexes',
            'nationalites',
            'idclassannesco',
            'labonnement',
            'photo',
            'lannesco',
            'laclassannesco',
            'leget',
            'lapersonne'
        ));
    }


    public function enregistrer(Request $request)
    {
        //  dd($request);
        // dd(sansespace($request->reduction));
        try {
            $id = $request->input('idenreg');
            $route = 'apprenant';
            if ((isset($request->module) && $request->module == 'inscriptionAbonne')) {
                $appr = apprenant::where('matricule', $request->matricule)->first();
                $id = $appr != null ? $appr->id : null;
                $route = 'classeAbonne';
                session(['module' => 'listeApprenant']);
            }

            // Enregistrement de la personne

            // Doublon
            $rekete = " SELECT  * FROM personnes WHERE ( (nom = '" . $request->nom . "' AND prenoms = '" . $request->prenoms . "')  ";
            $rekete .= " OR  npi = '" . $request->npi . "' )";
            if ($request->idpersonne != 0 && $request->idpersonne != null) {
                $rekete .= " AND id != '" . $request->idpersonne . "' ";
            }
            $doubp = DB::select($rekete);
            $doubp = collect($doubp);
            
            if (count($doubp) == 0) {

                if ($request->idpersonne != 0 && $request->idpersonne != null) {
                    $p = personne::findOrFail($request->idpersonne);
                } else {
                    $p = new personne();
                }
                if ($request->hasFile('photo')) {
                    $imagePath = $request->file('photo');
                    $customFileName = $imagePath->getClientOriginalName(); // Utilisez le nom d'origine du fichier
                    $imagePath->move(public_path('storage/images/Personnes'), $customFileName);
                    $p->photo = $customFileName;
                    //  dd($customFileName);
                }
                $p->npi = $request->npi;
                $p->nom = $request->nom;
                $p->prenoms = $request->prenoms;
                $p->datenais = $request->datenais;
                $p->lieunais = $request->lieunais;
                $p->contactparent = $request->contactparent;
                $p->idsexe = $request->idsexe;
                $p->idnationalite = $request->idnationalite;

                if ($p->save()) {

                    // Enregistrement de l'apprenant
                    // Doublon
                    $rekete = " SELECT  * FROM apprenants WHERE ( matricule = '" . $request->matricule . "'  ";
                    $rekete .= " OR idpersonne = '" . $p->id . "') ";

                    if ($id != 0 && $id != null) {
                        $rekete .= "  AND id != '" . $id . "' ";
                    }
                    $doub = DB::select($rekete);
                    $doub = collect($doub);
                    //  dd($rekete);
                    if ($id == 0 || $id == null) {
                        $e = new apprenant();
                    } else {
                        $e = apprenant::findOrFail($id);
                    }
                    
                    if (count($doub) == 0) {


                    } else {
                        $info = "L'apprenant que vous tentez d'enregistrer existe déjà";
                        $titre = "DOUBLON";
                        return view('alertDoublon', compact('info', 'titre'));
                    }

                    $e->idabonnement = $request->idabonnement;
                    $e->idpersonne = $p->id;
                    $e->matricule = $request->matricule;

                    $e->save();//die();
                    if (isset($request->dateinscrip)) {
                        //enregistrement d'inscription
                        if ($e) {
                            // Doublon

                            // dd(122);

                            //Inscription   dateinscrip	reduction	reinscription	idclassannesco	idapprenant	
                            $rek = "SELECT * From inscriptions WHERE idclassannesco = '" . $request->idclassannesco . "' ";
                            $rek .= " AND idapprenant = '" . $e->id . "' ";
                            if ($request->idinscription == 0 || $request->idinscription == null) {
                                $ins = new inscription();
                            } else {
                                $rek .= " AND id != '" . $request->idinscription . "' ";
                                $ins = inscription::findOrFail($request->idinscription);
                            }
                            $doub = collect(DB::select($rek));
                            if (count($doub) == 0) {
                                $ins->dateinscrip = $request->dateinscrip;
                                $ins->reduction = intval(sansespace($request->reduction));
                                $ins->idclassannesco = $request->idclassannesco;
                                $ins->idapprenant = $e->id;
                                $ins->save();
                            }

                        }
                    }


                }

            } else {
                $info = "L'apprenant que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }

            return redirect()->route($route);

        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            $route = 'apprenant';
            if ((session('module') != null) && session('module') == 'listeApprenant') {
                $route = 'classeAbonne';
                session(['module' => 'listeApprenant']);
            }

            $deleted = DB::table('inscriptions')->where('idapprenant', '=', $id)->delete();
            $v = array();

            if (count($v) == 0) {
                $e = apprenant::findOrFail($id);
                $e->delete();

                return redirect()->route($route);
            } else {
                $info = "L'apprenant que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
                $titre = "CONTRAINTE D'INTEGRITE";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route($route)->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
