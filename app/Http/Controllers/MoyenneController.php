<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\moyenne;
use App\Models\detailsmoyenne;

class MoyenneController extends Controller
{


    public function validerMoyPeriodeApprenant(Request $request)
    {

        // dd($request);

        $route = 'home';
        try {
            $majMoyperiod = $request->majMoyperiod;
            $idsession = $request->idsession;
            $rang = infoTableParId('sessionacademiques', $idsession, 'rang');
            //Revoir cette partie
            if ((session('module') != null) && session('module') == 'compositionAbonne') {
                $route = 'classeAbonne';
                session(['module' => 'listeCompositionAbonne']);
            }

            $id = $request->input('idenreg');

            if ($id == 0 || $id == null) {
                $doub = moyenne::where('idclassannesco', $request->idclassannesco)->get();
                $e = new moyenne();
            } else {
                $doub = moyenne::where('idclassannesco', $request->idclassannesco)
                    ->where('id', '!=', $id)->get();
                $e = moyenne::findOrFail($id);
            }
            //  dd(count($doub));
            if (count($doub) == 0) {
                //libelle	datcomposition	barem	idclassannesco	idmatiere	idetat
                $e->libelle = $request->libelle;
                $e->idclassannesco = $request->idclassannesco;
                $e->save();//die();
                if ($e) {
                    # Enregistrement de detailsmoyperiods
                    #appreciation	rang	coef1	coef2	coef3	coef4	coef5	coef6	moy1	moy2	moy3	moy4	moy5	moy6	moyannuelle	idmoyenne	idinscription
                    $idm = $request->iddetailsmoyenne;
                    $m = ($idm == 0 || $idm == null) ? new detailsmoyenne() : detailsmoyenne::find($idm);
                    //    dd($idm);
                    if ($m) {
                        $m->idmoyenne = $e->id;
                        // $v = "idinscription" . $i;
                        $m->idinscription = $request->idinscription;
                        $col = "moy" . $rang;
                        $m->$col = $request->moyperiod;
                        $col = "coef" . $rang;
                        $m->$col = 1;
                        $m->save();
                    }

                }

                if ($majMoyperiod == 1) {
                    $n = $request->taille;
                    for ($i = 0; $i < $n; $i++) {
                        $rq = new Request();
                        $rek = " SELECT * FROM moyperiodapprenants WHERE idsession = '" . $idsession . "' ";
                        // $v = "idmatiere" . $i;
                        $rek .= " AND idmatiere = '" . $request->{'idmatiere' . $i} . "' AND idclassannesco = '" . $request->idclassannesco . "' ";
                        $moyp = infoParRekete($rek);
                        
                        $rq['idenreg'] = $moyp != null ? $moyp->id : null;
                        $rq['libelle'] = $moyp != null ? $moyp->libelle : null;
                        $rq['idclassannesco'] = $request->idclassannesco;
                        $rq['idmatiere'] = $request->{'idmatiere' . $i};
                        $rq['idsession'] = $idsession;
                        $rq['taille'] = 1;
                        $rq['id0'] = $request->{'id' . $i};

                        $rq['idinscription0'] = $request->idinscription;
                        $rq['moy0'] = $request->{'moy' . $i};
                        $rq['moyIntero0'] = $request->{'moyIntero' . $i};
                        $rq['dev1_0'] = $request->{'dev1_' . $i};
                        $rq['dev2_0'] = $request->{'dev2_' . $i};
                        //  $rq->idenreg = $moyp != null? $moyp->id:null;
                        //  $rq->libelle = $moyp != null? $moyp->libelle:null;
                        // $rq->idclassannesco = $request->idclassannesco;
                        // $rq->idmatiere = $request->{'idmatiere'.$i};
                        // $rq->idsession = $idsession;
                        // $rq->taille = 1;
                        // $rq->{'id'.$i} = $request->{'id'.$i};
                        // $rq->{'moy'.$i} = $request->{'moy'.$i};
                        // $rq->{'moyIntero'.$i} = $request->{'moyIntero'.$i};
                        // $rq->{'dev1_'.$i} = $request->{'dev1_'.$i};
                        // $rq->{'dev2_'.$i} = $request->{'dev2_'.$i};
                        # code...
                        validerMoyPeriodeParMatiere($rq);
                    }

                }

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

}
