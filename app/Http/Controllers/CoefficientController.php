<?php

namespace App\Http\Controllers;

use App\Models\classetype;
use App\Models\matiere;
use App\Models\coefficient;
use App\Models\abonnement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CoefficientController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        try {
            // $idabonnement = ($request->idabonnement) ? $request->idabonnement : (session('idabonnement') != null ? session('idabonnement') : session('idabonnementEncours'));
            // session(['idabonnement' => $idabonnement]);
            // $abonnements = abonnement::orderBy('designation')->get();
            $typemat = ", COALESCE((SELECT libelle FROM elements e WHERE co.idtypematiere = e.id ),'') libtypematiere ";
            $rekete = " SELECT co.*,c.libelle libclas, m.libelle libmatiere, niveau ".$typemat;
            $rekete .= " FROM coefficients co , classetypes c, matieres m ";
            $rekete .= " WHERE co.idclasse = c.id AND co.idmatiere = m.id ";
            $rekete .= " ORDER BY niveau ASC, rang ASC, libmatiere "; //idtypematiere

            $donnees = collect(DB::select($rekete));

            $matieres = matiere::orderBy('libelle')->get();
            $classes = classetype::orderBy('niveau')->get();


            session(['config' => 'coefficient']);
            return view('liste', compact(
                'donnees',
                'matieres',
                'classes',
            ));
        } catch (\Exception $e) {
            return redirect()->route('coefficient')->with('error', 'Une erreur est survenue lors du chargement de la page.');
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
        session(['config' => 'coefficient']);
        //dd($_GET);

        $idclasSel = isset($_GET['idclasse']) ? $_GET['idclasse'] : null;
        session(['idclasSel' => $idclasSel]);
        $reksect ="SELECT secteur FROM classetypes  WHERE id = '".$idclasSel."' ";
       $tsect = collect(DB::select($reksect))->first();
       $sect = $tsect ? $tsect->secteur : null;
    //    dd($idclasSel,$reksect,$tsect,$sect);
        $classetypes = classetype::orderBy('niveau')->get();
        $rekmat = " SELECT * FROM matieres m WHERE id NOT IN (SELECT DISTINCT idmatiere FROM coefficients WHERE idclasse = '" . $idclasSel . "' )";
       switch ($sect) {
           case 'M':
               $rekmat .= " AND maternel = 1  ";
               break;
           case 'P':
               $rekmat .= " AND primaire = 1  ";
               break;
           case 'S':
               $rekmat .= " AND secondaire= 1  ";
               break;
           case 'U':
               $rekmat .= " AND universitaire = 1  ";
               break;
           default:
               // no action
               break;
       }

        $rekmat .= "ORDER BY libelle ";
        
        $matieres = collect(DB::select($rekmat));

     
        $typematieres = elementParTable('typematiere');

        $lenregistrement = ($idenreg != null) ? coefficient::find($idenreg) : null;
        if ($lenregistrement) {
            // $idinscription = $lenregistrement->idinscription;
        }
        return view('formConfiguration', compact(
            'lenregistrement',
            'idenreg',
            'classetypes',
            'typematieres',
            'matieres'
        ));
    }

    public function enregistrer(Request $request)
    {
        // dd($request);

        try {
            $id = $request->input('idenreg');
            if ($id == 0 || $id == null) {
                $doub = coefficient::where('idclasse', $request->idclasse)
                    ->where('idmatiere', $request->idmatiere)->get();
                $e = new coefficient();
            } else {
                $doub = coefficient::where('idclasse', $request->idclasse)
                    ->where('idmatiere', $request->idmatiere)
                    ->where('id', '!=', $id)
                    ->get();
                $e = coefficient::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //`idabonnement`, coef	rang	idclasse	idmatiere	
                $e->idclasse = $request->idclasse;
                $e->idmatiere = $request->idmatiere;
                $e->coef = $request->coef;
                $e->rang = $request->rang;
                $e->idtypematiere = $request->idtypematiere;

                $e->save();//die();
                return redirect()->route('coefficient');
            } else {
                $info = "Le coefficient que vous tentez d'enregistrer existe déjà";
                $titre = "DOUBLON";
                return view('alertDoublon', compact('info', 'titre'));
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('coefficient')->with('error', 'Une erreur est survenue lors de l\'enregistrement de la classe année scolaire.' . $e);
        }
    }

    public function supprimer($id)
    {
        try {
            // //Controle de possibilité de suppression
            // $v = coefficient::where('idclasse', $id)->get();
            // if (count($v) == 0) {
            $e = coefficient::findOrFail($id);
            //dd($e);
            $e->delete();

            return redirect()->route('coefficient');
            // } else {
            //     $info = "La classe-type que vous tentez de supprimer est lié à au moins un enregistrement \n Vous ne pouvez donc pas le supprimer";
            //     $titre = "CONTRAINTE D'INTEGRITE";
            //     return view('alertDoublon', compact('info', 'titre'));
            // }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('coefficient')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
        }
    }
}
