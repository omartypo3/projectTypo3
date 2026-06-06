/* Define two custom functions (asc and desc) for string sorting */
jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};

jQuery(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    $('.bootstrap table').dataTable( {
        "sPaginationType": "full_numbers",

        "oLanguage": {
            "sLengthMenu": "Montrer _MENU_ enregistrements par page",
            "sZeroRecords": "Aucun résultat",
            "sInfo": "De _START_ à _END_ sur _TOTAL_ enregistrements",
            "sInfoEmpty": "De 0 à 0 sur 0 enregistrement",
            "sInfoFiltered": "(Filtre sur _MAX_ enregistrements au total)",
            "sSearch": "Recherche",
            "oPaginate": {
                "sFirst":    "<<",
                "sPrevious": "<",
                "sNext":     ">",
                "sLast":     ">>"
            }
        },

        "aaSorting": [ [2,'asc'] ],
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ]
    } ).columnFilter( {
        aoColumns: [
            { type: "select" },
            { type: "date" },
            { type: "select" },
            { type: "select" },
            { type: "text" },
            null,
            null
        ]}
    );

    // $(".bootstrap table thead tr").remove();
    // $(".bootstrap table tfoot tr").prependTo($(".bootstrap table thead"));
} );