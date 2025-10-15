var JPrincipal = {
    urlajax: '../../../ajax/ajaxIncludeForm.php',
    // afficheModal: function (ancre, rang) { alert(ancre);
    //     $.get(JPrincipal.urlajax, {
    //         action: 'afficheMenu',
    //         rang: rang,
    //         ancre: ancre

    //     }, function (data) {
    //          $("#zoneAffectation").html(data);
    //     }
    //     );
    // },

      imprimer: function(conf) { //alert(conf);
var valret = "";
// switch(conf){
//     case 'fichevaluation':       
//         valret = $('#select2-idtype-container').attr('title') + '|' + $('#select2-idmatiere-container').attr('title') + '|' +  $('#datevaluation').val();
// //        alert(valret);
//         break;
// }

        $.get(JPrincipal.urlajax, {
            action: 'getImpressionPDF',
            conf: conf,
            valRet: valret
        }, function(data) { alert(data);
            $("#zoneadd").html(data);
        }
        );
    },

}