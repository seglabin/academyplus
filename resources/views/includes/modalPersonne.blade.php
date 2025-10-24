@php
    use Illuminate\Support\Facades\DB;

    /*
        $libmotif = ", COALESCE((SELECT libelle FROM elements e WHERE e.id = p.idmotif),' ') AS libmotif ";
        $rekete = " SELECT p.* ".$libmotif;
        $rekete .= " ";
        $rekete .= " FROM paiements p WHERE idinscription = '" . $idinscription . "' ";
        $rekete .=" ORDER BY datepaiement ";
       // dd($rekete);
        $paiements = collect(DB::select($rekete));*/
    //dd($affectations);
    $photo = '';
@endphp

<div class="modal fade" id="modalPersonne">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Enregistrement des informations d'une nouvelle personne
                            </h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <section id="admissions" class="admissions section">
                            <div class="container" data-aos="fade-up" data-aos-delay="100">
                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        <div class="row">
                                            
                                            <div class="col-md-3 mb-2">
                                                <label class=" lelabel" for="">NPI</label>                                                
                                                    <input type="text" class="form-control rounded-4 @error('npi') is-invalid @enderror"
                                                        placeholder="Entrez NPI" onKeyup="enMajuscule('npi');" id="npi" name="npi"
                                                        value="">                                                    
                                            </div>
                                            
                                            <div class="col-md-3 mb-2">
                                                <label class="lelabel" for="">Nationalité</label>
                                                @php

                                                echo chargerComboSimple($nationalites, 'id', 'libelle', 'idnationalite', 'Choisir une nationalité','','','');
                                                @endphp
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="lelabel" for="">Sexe (*)</label>
                                                @php              
                                                echo chargerComboSimple($sexes, 'id', 'libelle', 'idsexe', 'Choisir le sexe','',"",'');
                                                @endphp
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class=" lelabel" for="">Contact parent (*)</label>
                                                <input type="text" class="form-control rounded-4 @error('contactparent') is-invalid @enderror"
                                                    placeholder="Entrez le contact parent" onKeyup="typetelephone(this);" id="contactparent" name="contactparent"
                                                    value="">
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label class=" lelabel" for="">Nom (*)</label>
                                                <input type="text" class="form-control rounded-4 @error('nom') is-invalid @enderror"
                                                    placeholder="Entrez le nom" onKeyup="enMajuscule('nom');" id="nom" name="nom"
                                                    value="">
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label class=" lelabel" for="">Prénoms (*)</label>
                                                <input type="text" class="form-control rounded-4 @error('prenoms') is-invalid @enderror"
                                                    placeholder="Entrez le prénom" onKeyup="enMajuscule('prenoms', 1);" id="prenoms" name="prenoms"
                                                    value="">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class=" lelabel" for="">Date de naissance (*)</label>
                                                <input type="date" class="form-control rounded-4 @error('datenais') is-invalid @enderror"
                                                    placeholder="Entrez la date de naissance"  id="datenais" name="datenais"
                                                    value="">
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label class=" lelabel" for="">Lieu de naissance (*)</label>
                                                <input type="text" class="form-control rounded-4 @error('lieunais') is-invalid @enderror"
                                                    placeholder="Entrez le lieu de naissance"  onKeyup="enMajuscule('lieunais', 0);"  id="lieunais" name="lieunais"
                                                    value="">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">

                                        <div class="control-group "> 
                                            <div class="form-group" >
                                                <label ><strong>Photo de la personne </strong></label>
                                                <div class="control-group "> 
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="  fileupload-preview thumbnail " style="width: 120px; height: 120px;">
                                                            <img src="" />                                                       
                                                        </div>
                                                        <div>
                                                            <?php if ($photo != '') { ?>
                                                                <span class="btn btn-file btn-small btn-warning"><span class="fileupload-new"><i class="bi bi-camera-fill icon-white"></i></span> 
                                                                <?php } else { ?>
                                                                    <span class="btn btn-file btn-small btn-success" title="Choisir"><span class="fileupload-new"><i class="bi bi-camera"></i></span> 
                                                                    <?php } ?>
                                                                    <span class="fileupload-exists btn-small btn-warning" title="Changer"><i class="bi bi-camera"></i></span><input type="file" name="photo" id="photo" value="" /></span>
                                                                <span class="btn btn-small btn-danger " data-dismiss="fileupload" title="Supprimer"> <i class="bi bi-trash"></i></span> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 row d-flex justify-content-center">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                   <a class="btn btn-outline-success btnarrondi" href="#" onclick="validerPersonneModal('{{ $config }}');"  > <i class="fas fa-plus"></i> Enregistrer</a>
                                    
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-secondary btnarrondi w-20 mr-auto"
                                    data-dismiss="modal"> Fermer</button>
                                </div>
                                <div class="col-md-4"></div>

                            </div>                            
                        </section>

                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<script>
    function validerPersonneModal(config){
    //    alert(config);
    
    let chps = 'npi|idsexe|nom|prenoms|contactparent|datenais';
    let labels = "N° NPI |le sexe|le nom|le prénom|le contact parent|la date de naissance";
            
    var act = '/enregistrer-personne-modal';
   
    if (controleVide(chps, labels)) {
    // alert(chps);
    document.forms["myform"].method = 'POST';
    document.forms["myform"].action = act;
    document.forms["myform"].submit();
    }

    }
</script>