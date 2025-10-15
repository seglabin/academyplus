<style>
    .button-container {
        display: flex;
        margin: 0 10px;
        /* Espacement entre les boutons */
        /* justify-content: center; */
        /* Alignement horizontal au centre */
        /* Ou, pour espacer les boutons :
     justify-content: space-around;
     justify-content: space-between;
     justify-content: space-evenly;
  */
    }

    .button-container a {
        margin: 0 10px;
        /* Espacement entre les boutons */
    }

    .menuabonne {

        /* padding: 5px; */
        /* height: 30px; */
    }

    .m1 {
        width: 100%;
        height: 60px;
        /* background-color:aquamarine; */
        background-image: url({{ asset('assets/img/slide/bg0.jpg')}} );
    }

    .active {
        color: white;
        bg-success;

    }
</style>


<!-- <section id="heroa" class=" section  m1" > -->
    <div class=" m1 ">
            <div class="row ">
                <div class="col-md-12 ">
            <div class="button-container">
                <a class="btn btn-outline-success btnarrondi active" href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> Inscription</a>
                <a class="btn btn-outline-success btnarrondi" href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> Classe</a>
                <a class="btn btn-outline-success btnarrondi" href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> Classe</a>
                <a class="btn btn-outline-success btnarrondi" href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> Classe</a>

            </div>
            <br>
            <div class="button-container">
                <a class="btn btn-outline-success btnarrondi " href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> ML1</a>
                <a class="btn btn-outline-success btnarrondi" href="#" onclick="ajouter('');"> <i
                        class="bi  bi-plus-circle"></i> ML2</a>

            </div>
        </div>
    </div>
</div>
<!-- </section> -->