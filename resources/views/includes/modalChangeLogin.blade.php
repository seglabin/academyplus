<div class="modal fade" id="modalChangeLogin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="panel panel-success setup-content active">
                    <div class="panel-success">
                        <div class="panel-heading centrer-contenu-horizontal">
                            <h4 class="modal-title ">Modification de Login
                            </h4>
                        </div>
                    </div>
                    <!-- <form class="form-horizontal" method="post" name="formChangeLogin"
                                        id="formChangeLogin" action="/changer-login"> -->
                    @csrf
                    <div class="panel-body">

                        <input type="hidden" name="iduserChgLogin" id="iduserChgLogin" value="" />
                        <input type="hidden" id="ancienLogin" name="ancienLogin" value="" />
                        <input type="hidden" id="tLogin" value="{{ $logins }}" />
                        <div class="row">
                            <!-- <div class="col-md-6"></div> -->
                            <div class="col-md-4">
                                <div class="form-group" style="margin:5px;">
                                    <label>Identifiant (*)</label>
                                    <input type="text" name="loginchange" id="loginchange"
                                        class="form-control rounded-4 " value="" />
                                </div>
                            </div>
                        </div>
                        <div class="btn-group centrer-contenu-horizontal">
                            <div class=" row ">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-primary btnarrondi w-20 mr-auto"
                                        onclick="ChangerLogin(); ">Valider</button>
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
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>