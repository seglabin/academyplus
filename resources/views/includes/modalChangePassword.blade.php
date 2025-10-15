<div class="modal fade" id="modalChangerPassword">
    @php
    $userEncours = (session('userEncours') != null) ? session('userEncours') : null;
    $iduser = $userEncours != null ? $userEncours->id : '';
    $pw = $userEncours != null ? $userEncours->password : '';
    @endphp
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Changement de mot de passe
                            </h4>
                        </div>
                    </div>
                    <form class="form-horizontal" method="post" name="formChangerPassWord" id="formChangerPassWord"
                        action="">
                        @csrf
                        <div class="panel-body">
                            <input type="hidden" name="iduser" id="iduser" value="{{ $iduser }}" />
                            <input type="hidden" name="password" id="password" value="{{ $pw }}" />
                            <div class="row">
                                <!-- <div class="col-md-6"></div> -->
                                <div class="col-md-4">
                                    <label>Ancien mot de passe (*)</label>
                                    <div class="form-group" style="margin:5px;">
                                        <input type="password" name="ancienpass" id="ancienpass"
                                            class="form-control rounded-4 "  value="" />
                                        <!-- <span toggle="#ancienpass"  onchange="controlePw();"
                                                            class="bi bi-fw bi-eye field-icon toggle-ancienpass"></span> -->
                                    </div>

                                    <!-- <div class="form-group">
                                                        <input id="password" name="password" type="password"
                                                            class="form-control" placeholder="Mot de passe" required>
                                                        <span toggle="#password"
                                                            class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                    </div> -->
                                </div>



                                <div class="col-md-4">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Nouveau (*)</label>
                                        <input type="password" name="newpass" id="newpass"
                                            class="form-control rounded-4 " value="" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Confirmation (*)</label>
                                        <input type="password" name="confirmpass" id="confirmpass"
                                            class="form-control rounded-4 " value="" />
                                    </div>
                                </div>

                            </div>
                            <div class="btn-group centrer-contenu-horizontal">
                                <div class=" row ">
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-primary btnarrondi w-20 mr-auto"
                                            onclick="changerMonPassword();">Changer</button>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-secondary btnarrondi w-20 mr-auto"
                                            data-dismiss="modal">
                                            Annuler</button>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>
                            </div>

                            <!-- </div> -->


                        </div>
                    </form>
                </div>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
</div>