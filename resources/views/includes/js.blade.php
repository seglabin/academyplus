<!-- <script src="{{ asset('assets/js/jquery.js')}}"></script> -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js')}}"></script>
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
<script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>

<!-- Main JS File -->
<script src="{{ asset('assets/js/main.js')}}"></script>

<!-- JPrincipal JS File -->
<!-- <script src="{{ asset('assets/js/JPrincipal.js')}}"></script> -->


<!-- Select2         -->
<script src="{{ asset('assets/js/select2.min.js')}}"></script>

<!-- Password style         -->
<script src="{{ asset('assets/js/style-password.js')}}"></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.js')}}"></script>
<!-- <script src="{{ asset('assets/datatable/js/pdfmake.min.js')}}"></script> -->
<script src="{{ asset('assets/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/buttons.colVis.min.js')}}"></script>




<script src="{{ asset('assets/js/bootstrap-fileupload.js')}}"></script>

<!--Modal-->
<script src="{{ asset('assets/js/common.min.js') }}"></script>
<!--En Modal-->

<script>

    function imprimer(module) {
        // alert(module);
        $.ajax({
            url: '/imprimer',
            type: 'GET', //POST
            data: {
                'module': module // Exemple de données à envoyer
            },
            success: function (response) {
                alert(data);
                // Traitement de la réponse
                if (response.success) {
                    // Afficher les données du produit
                    console.log(response.produit);
                    // ... (mettre à jour le DOM avec les données du produit)
                } else {
                    // Gérer l'erreur
                    console.error('Erreur lors de la récupération du produit.');
                }
            },
            error: function (xhr, status, error) { //alert('Erreur '+ error);
                // Gérer les erreurs de la requête
                console.error('Erreur AJAX:', error);
            }
        });

    }


    function controleNote(x) {
        var barem = parseFloat($('#barem').val());
        //  alert(barem);
        if (parseFloat(x.value) > barem) {
            alert("La note doit être inférieure ou égale à " + barem);
            x.value = -1;

        }
    }

    function calculMoyenne(j) {
        var barem = parseFloat($('#barem').val());
        var s = 0;
        var n = 0;
        for (let i = 0; i <= 12; i++) {
            var e = parseFloat($('#m' + i + '_' + j).val());
            if (e >= 0) {
                n++;
                s += e;
            }
        }

        var moy = (n > 0) ? (s / n) : -1;
         moy = parseFloat(moy.toFixed(2));

        $('#moyenne' + j).val(moy);
    }

    function calculMoyInterro(j) {
        var barem = parseFloat($('#barem').val());
        var s = 0;
        var n = 0;
        for (let i = 0; i <= 5; i++) {
            var e = parseFloat($('#intero' + i + '_' + j).val());
            if (e >= 0) {
                n++;
                s += e;
            }
        }

        var moy = (n > 0) ? (s / n) : -1;
         moy = parseFloat(moy.toFixed(2));

        $('#moyIntero' + j).val(moy);
        calculMoyPeriodeMatiere(j);
    }

    function calculMoyPeriodeMatiere(j) {
        var barem = parseFloat($('#barem').val());
        var moyInter = parseFloat($('#moyIntero' + j).val());
        var dev1 = parseFloat($('#dev1_' + j).val());
        var dev2 = parseFloat($('#dev2_' + j).val());
        var s = 0;
        var n = 0;
        if (moyInter >= 0) {
            n++;
            s += moyInter;
        }
        if (dev1 >= 0) {
            n++;
            s += dev1;
        }
        if (dev2 >= 0) {
            n++;
            s += dev2;
        }

// alert(s);
        var moy = (n > 0) ? (s / n) : -1;
        moy = parseFloat(moy.toFixed(2));
        
        $('#moy' + j).val(moy);
    }


    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    function appliqudataTable(idtable, optbuton) {
        var nomtab = "#" + idtable; //alert(optbuton);
        $(nomtab).DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, "info": true, "ordering": true,
            "buttons": optbuton//["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo(nomtab + '_wrapper .col-md-6:eq(0)');
    }

    function validateEmail(idemail) {
        var email = $('#' + idemail).val();
        const $result = $('#result');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //        alert(emailRegex.test(email));

        if (!emailRegex.test(email)) {
            $result.text(' Veuillez saisir un mail valide.');
            $result.css('color', 'red');
            $('#' + idemail).css('color', 'red');
            $('#' + idemail).focus();
        } else {
            $result.text('');
            $('#' + idemail).css('color', 'black');
        }
    }




    // function appliqueDatatable() {
    //     $(".appliqueDT").DataTable({
    //         "responsive": true, "lengthChange": false, "autoWidth": false,
    //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //     }).buttons().container().appendTo('.appliqueDT_wrapper .col-md-6:eq(0)');
    //     /*  $('#example2').DataTable({
    //           "paging": true,
    //           "lengthChange": false,
    //           "searching": false,
    //           "ordering": true,
    //           "info": true,
    //           "autoWidth": false,
    //           "responsive": true,
    //       });*/
    // }


    function confirmation(texte) {
        var rep = confirm("texte", okLabel = "oui");
    }

    function typemontant(X) {
        result = "";
        cpt = 0;
        for (I = X.value.length - 1; I >= 0; I--) {
            character = X.value.charAt(I);
            if (!/[0-9]/.test(character))
                continue;
            result = character + result;
            cpt++;
            if (cpt % 3 === 0 && I > 0)
                result = " " + result;
        }
        X.value = result;
    }

    function typetelephone(X) { //alert(X.name);


        result = "";
        cpt = 0;

        //       if(X.value.length-1 < 10){
        for (I = X.value.length - 1; I >= 0; I--) {
            character = X.value.charAt(I);
            if (!/[0-9]/.test(character))
                continue;
            result = character + result;
            cpt++;

            if (cpt % 2 === 0 && I > 0)
                result = " " + result;
        }
        //       }
        X.value = result;
    }

    function sansEspace(chaine) {
        return chaine.replace(/\s/g, "");
    }


    function enMajuscule(idchamp, nbCar = 0) {
        var m = document.getElementById(idchamp).value;
        //var t= parseInt(m.length);
        if (parseInt(nbCar) > 0) {
            if (parseInt(m.length) <= parseInt(nbCar))
                document.getElementById(idchamp).value = document.getElementById(idchamp).value.toUpperCase();
        } else {
            document.getElementById(idchamp).value = document.getElementById(idchamp).value.toUpperCase();
        }
    }
    function enMinuscule(idchamp, nbCar = 0) {
        var m = document.getElementById(idchamp).value;
        //var t= parseInt(m.length);
        if (parseInt(nbCar) > 0) {
            if (parseInt(m.length) <= parseInt(nbCar))
                document.getElementById(idchamp).value = document.getElementById(idchamp).value.toLowerCase();
        } else {
            document.getElementById(idchamp).value = document.getElementById(idchamp).value.toLowerCase();
        }
    }

    function onChangeCombo(conf) {    // alert(conf)  
        document.forms["myform"].action = conf;
        document.forms["myform"].submit();
    }

    function onChangeGet(conf) {    // alert(conf)  
        document.forms["myform"].action = conf;
        document.forms["myform"].method = 'GET';
        document.forms["myform"].submit();
    }

    function renvoievalcoche(chk, chpval) {
        document.getElementById(chpval).value = (document.getElementById(chk).checked === true) ? 1 : 0;
    }


    function changeAnneeSel(conf) {
        // alert(document.getElementById('idanSela').value);
        document.getElementById('idanSel').value = document.getElementById('idanSela').value;
        // $('#changeAnSel').val(1);
        var cf = "/changer-anneescolaire";
        document.forms["myform"].action = cf;
        document.forms["myform"].method = 'GET';
        document.forms["myform"].submit();
    }

    let idtable = "letablo";
    let optbuton = ["excel", "pdf"];


    appliqudataTable(idtable, optbuton)
    //appliqueDatatable();

    $('.select2').select2();
</script>