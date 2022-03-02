// fichier tableau.js
$(document).ready(function () {
    $(document).ready(function () {
        $('#tab').dataTable({
            "language": {
                "url": "/DataTables/French.json"
            },   
    "processing": true,
    "serverSide": true,
        "filter": true,
   
    });
});

// $(document).ready(function () {
    // $('#tab').DataTable({
//            language: {
//                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"  
//            },
           // "filter": true,
           // "destroy": true
//        });
   
//    });

$(document).ready(function () {
    $('#tab2').DataTable({
           language: {
               url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"  
           },
           "processing": true,
           "serverSide": true,
           "filter": true,
           "destroy": true
       });
   
   });
 
//    $(document).ready(function () {
//     $('#tab3').DataTable({
//            language: {
//                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"  
//            },
//            "filter": true,
//            "destroy": true
//        });
//    });