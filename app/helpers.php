<?php
use Illuminate\Support\Facades\DB;
use App\Models\element;
use App\Models\moyperiodapprenants;
use App\Models\detailsmoyperiod;
use Illuminate\Http\Request;

;
function chargerComboa($donnees, $idtable, $colonne, $idcombo, $choixdefaut = "Choisir...", $largeur = "210", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "")
{
    $affich = "";
    $onch = "";
    $largeur = ($largeur == '') ? '100%' : $largeur . 'px';

    if ($onchange != '')
        $onch = "onchange =" . $onchange; //."'";
    if ($multiple == "") {
        $affich .= "<select class='form-control select2' id='" . $idcombo . "' name='" . $idcombo . "' " . $onch . " style=' width:" . $largeur . ";' >";
    } else {
        $affich .= "<select class='form-control select2' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' " . $onch . " style='height: 30px; width: " . $largeur . "px;' >";
    }
    $affich .= "<option value='0'>--" . $choixdefaut . "--</option>";

    if (sizeof($donnees) > 0) {
        foreach ($donnees as $list) {
            // dd($list);
            $depinit = "";
            if ($multiple == "") {
                if ($list[$idtable] == $idencours) {
                    $depinit = 'selected=selected';
                }
            } else {
                if (in_array($list[$idtable], $idencours)) {
                    $depinit = 'selected=selected';
                }
            }

            $affich .= "<option " . $depinit . " value=" . $list[$idtable] . ">";
            $affich .= $list[$colonne] . "</option>";
        }
    }
    $affich .= "</select>";
    return $affich;
}
function chargerCombo($donnees, $idtable, $colonne, $idcombo, $choixdefaut = "Choisir...", $largeur = "210", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "")
{
    $affich = "";
    $onch = "";
    $largeur = ($largeur == '') ? '100%' : $largeur . 'px';

    if ($onchange != '')
        $onch = "onchange =" . $onchange; //."'";
    if ($multiple == "") {
        $affich .= "<select class='form-control rounded-4 select2' id='" . $idcombo . "' name='" . $idcombo . "' " . $onch . " style=' width:" . $largeur . ";' >";
    } else {
        $affich .= "<select class='form-control rounded-4 selects' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' " . $onch . " style='height: 30px; width: " . $largeur . "px;' >";
    }
    $affich .= "<option value='0'>--" . $choixdefaut . "--</option>";

    if (sizeof($donnees) > 0) {
        foreach ($donnees as $list) {
            // dd($list);
            $depinit = "";
            if ($multiple == "") {
                if ($list->$idtable == $idencours) {
                    $depinit = 'selected=selected';
                }
            } else {
                if (in_array($list->$idtable, $idencours)) {
                    $depinit = 'selected=selected';
                }
            }

            $affich .= "<option " . $depinit . " value=" . $list->$idtable . ">";
            $affich .= $list->$colonne . "</option>";
        }
    }
    $affich .= "</select>";
    return $affich;
}
function chargerComboSimple($donnees, $idtable, $colonne, $idcombo, $choixdefaut = "Choisir...", $largeur = "210", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "")
{
    $affich = "";
    $onch = "";
    $largeur = ($largeur == '') ? '100%' : $largeur . 'px';

    if ($onchange != '')
        $onch = "onchange =" . $onchange; //."'";
    if ($multiple == "") {
        $affich .= "<select class='form-control rounded-4 ' id='" . $idcombo . "' name='" . $idcombo . "' " . $onch . " style=' width:" . $largeur . ";' >";
    } else {
        $affich .= "<select class='form-control rounded-4 ' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' " . $onch . " style='height: 30px; width: " . $largeur . "px;' >";
    }
    $affich .= "<option value='0'>--" . $choixdefaut . "--</option>";

    if (sizeof($donnees) > 0) {
        foreach ($donnees as $list) {
            // dd($list);
            $depinit = "";
            if ($multiple == "") {
                if ($list->$idtable == $idencours) {
                    $depinit = 'selected=selected';
                }
            } else {
                if (in_array($list->$idtable, $idencours)) {
                    $depinit = 'selected=selected';
                }
            }

            $affich .= "<option " . $depinit . " value=" . $list->$idtable . ">";
            $affich .= $list->$colonne . "</option>";
        }
    }
    $affich .= "</select>";
    return $affich;
}

function infos($msg)
{
    ?>
    <script>alert('<?php echo addslashes($msg) ?>');</script>

    <?php
}

function sansespace($ch)
{
    return str_replace(' ', '', $ch);
}

function afficheModal($cas)
{
    echo "Merci Seigneur Jésus";

    @include_once('../resources/views/includes/about.blade.php');

}

function lesclassesAnnesco($iduser, $idrole, $idabonnement, $idan)
{
    // Liste des classes de l'abonné pour l'année scolaire
    $rekclas = " SELECT ca.*,libelle, CONCAT(sigle,' ', groupe) sigle, CONCAT(libelle,' ',COALESCE(groupe, '')) AS libclasse  ";
    $rekclas .= " FROM classannescos ca,classetypes c ";
    $rekclas .= " WHERE c.id = ca.idclasse ";
    $rekclas .= " AND idabonnement = '" . $idabonnement . "' AND idanneescolaire = '" . $idan . "' ";

    switch ($idrole) {
        case 1: //Super admin
        case 3: // admin
        case 5: // Secrétaire
        case 7: // Censeur
        case 8: // Directeur
            # code...
            break;
        case 6: // Enseignant primaire
        case 9: // Enseignant secondaire
            $rekclas .= " AND ca.id IN (SELECT DISTINCT idclassannesco FROM affectations WHERE idenseignant = '" . $iduser . "' )";
            break;

    }

    $rekclas .= " ORDER BY libclasse ";
    //  dd($rekclas);
    $classannescosEncours = collect(DB::select($rekclas));
    return $classannescosEncours;
}

function elementParTable($nomtable)
{
    return element::where('nomtable', $nomtable)->orderBy('libelle')->get();
}

function classetypeParAbonne($idabonne = '')
{
    $rekete = " SELECT * FROM classetypes ";
    if ($idabonne != '') {
        $rk = "SELECT s.* FROM secteurs s, abonnements a WHERE s.id = a.idsecteur AND a.id = '" . $idabonne . "' ";
        $sect = collect(DB::select($rk));
        //  dd(count($sect));
        if (count($sect) > 0) {

            $rekete .= " WHERE secteur = '" . $sect[0]->sigle . "' ";
        }
    }
    $rekete .= " ORDER BY niveau ";

    return collect(DB::select($rekete));
}

function infoTableParId($table, $id, $colonne = '')
{
    $sql = "SELECT * FROM $table WHERE id = '" . $id . "'";
    $res = collect(DB::select($sql));
    // dd($res[0]);
    if (count($res) > 0) {
        if ($colonne != '') {
            return ($res[0])->$colonne;
        } else {
            return $res[0];
        }
    } else {
        return null;
    }
}

function infoParRekete($rekete, $colonne = '')
{
    $res = collect(DB::select($rekete));
    // dd($res[0]);
    if (count($res) > 0) {
        if ($colonne != '') {
            return ($res[0])->$colonne;
        } else {
            return $res[0];
        }
    } else {
        return null;
    }
}


function matieresParClassannesco($idclassannesco)
{
    $rekete = " SELECT m.*, coef, rang ";
    $rekete .= " FROM matieres m, coefficients co, classannescos  ca";
    $rekete .= " WHERE m.id = co.idmatiere AND co.idabonnement = ca.idabonnement AND co.idclasse = ca.idclasse ";
    $rekete .= " AND ca.id = '" . $idclassannesco . "' ";
    $rekete .= "";

    $rekete .= " ORDER BY rang ";
    // dd($rekete);
    return collect(DB::select($rekete));
}


function apprenantsParClassannesco($idclassannesco)
{
    $rekete = " SELECT ins.*, npi, nom, prenoms, contactparent , CONCAT(nom, ' ', prenoms) libapprenant ";
    $rekete .= " FROM inscriptions ins, apprenants a, personnes p, classannescos  ca";
    $rekete .= " WHERE ins.idapprenant = a.id AND a.idpersonne = p.id AND ins.idclassannesco = ca.id ";
    $rekete .= " AND ca.id = '" . $idclassannesco . "' ";
    $rekete .= "";

    $rekete .= " ORDER BY libapprenant ";
    //  dd($rekete);
    return collect(DB::select($rekete));
}

function validerMoyPeriodeParMatiere(Request $request)
{

    //    dd($request);
    $id = $request->input('idenreg');
    // dd($request->idclassannesco);
    if ($id == 0 || $id == null) {
        $e = new moyperiodapprenants();
    } else {
        $e = moyperiodapprenants::findOrFail($id);
    }

    //libelle	datcomposition	barem	idclassannesco	idmatiere	idetat
    if (isset($request->libelle))
        $e->libelle = $request->libelle;
    $e->idclassannesco = $request->idclassannesco;
    $e->idmatiere = $request->idmatiere;
    $e->idsession = $request->idsession;

    $e->save();//die();
    if ($e) {
        # Enregistrement de detailsmoyperiods
        #appreciation	rang	intero1	intero2	intero3	intero4	intero5	dev1	dev2	moyinterro	moy	idmoyperiod	idinscription
        $nb = $request->taille;
        if ($nb > 0) {
            # code...
            for ($i = 0; $i < $nb; $i++) {
                # code...

                $idm = $request->{'id' . $i};
                $m = ($idm == 0 || $idm == null) ? new detailsmoyperiod() : detailsmoyperiod::find($idm);
                // dd($m);
                if ($m) {
                    $m->idmoyperiod = $e->id;
                    $v = "idinscription" . $i;
                    $m->idinscription = $request->$v;
                    $v = "moy" . $i;
                    $m->moy = $request->$v;
                    $v = "moyIntero" . $i;
                    $m->moyinterro = $request->$v;
                    for ($j = 1; $j <= 5; $j++) {
                        # code...
                        $v = "intero" . $j . '_' . $i;
                        $col = "intero" . $j;
                        if (isset($request->$v))
                            $m->$col = $request->$v;
                    }
                    for ($j = 1; $j <= 2; $j++) {
                        # code...
                        $v = "dev" . $j . '_' . $i;
                        $col = "dev" . $j;
                        if (isset($request->$v))
                            $m->$col = $request->$v;
                    }
                    $m->save();
                }
            }
        }
    }

}


    function rechercheSouchaine($chaine, $souchaine)
    {
        if (strpos($chaine, $souchaine) !== FALSE) {
            return TRUE;
        }
        return FALSE;
    }

    function formatDateFrancais($date)
    {
        $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if ($dateObj) {
            return $dateObj->format('d-m-Y H:i:s');
        }
        return '';
        // $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        // if ($dateObj) {
        //     return $dateObj->format('d-m-Y');
        // }
        // return '';
    }

?>