<div class="modal fade" id="modalReinitPassword">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Réinitialiser le mot de passe
                            </h4>
                        </div>
                    </div>
                    <form class="form-horizontal" method="post" name="formReinitPassWord" id="formReinitPassWord"
                        action="/reinitialiser-password">
                        @csrf
                        <div class="panel-body">
                            <input type="hidden" name="iduserReinit" id="iduserReinit" value="" />
                            <div class="row">
                                <!-- <div class="col-md-6"></div> -->
                                <div class="col-md-4">
                                    <div class="form-group" style="margin:5px;">
                                        <label>Nouveau mot de passe (*)</label>
                                        <input type="password" name="reinitpass" id="reinitpass"
                                            class="form-control rounded-4 " value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group centrer-contenu-horizontal">
                                <div class=" row ">
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-primary btnarrondi w-20 mr-auto"
                                            onclick="reinitpassword(); submit();">Réinitialiser</button>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>