$(document).ready(function () {
    $('#Geschlecht').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress(mutterspracheVal,$('#Techniken').val(),$('#Muttersprache').val(),$('#Sprachen').val(),$('#Ort').val(),$('#Gehoerlos').val(),$('#notwenidg').val());
    });
    $('#Techniken').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),mutterspracheVal,$('#Muttersprache').val(),$('#Sprachen').val(),$('#Ort').val(),$('#Gehoerlos').val(),$('#notwenidg').val());
    });
    $('#Muttersprache').change(function() {
        //console.log($(this).val());
        if($(this).val() == 'Andere'){
            $('.optionandere').show();
        }
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),$('#Techniken').val(),mutterspracheVal,$('#Sprachen').val(),$('#Ort').val(),$('#Gehoerlos').val(),$('#notwenidg').val());
    });
    $('#Sprachen').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),$('#Techniken').val(),$('#Muttersprache').val(),mutterspracheVal,$('#Ort').val(),$('#Gehoerlos').val(),$('#notwenidg').val());
    });
    $('#Ort').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),$('#Techniken').val(),$('#Muttersprache').val(),$('#Sprachen').val(),mutterspracheVal,$('#Gehoerlos').val(),$('#notwenidg').val());
    });
    $('#Gehoerlos').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),$('#Techniken').val(),$('#Muttersprache').val(),$('#Sprachen').val(),$('#Ort').val(),mutterspracheVal,$('#notwenidg').val());
    });
    $('#notwenidg').change(function() {
        var mutterspracheVal=$(this).val();
        getAddress($('#Geschlecht').val(),$('#Techniken').val(),$('#Muttersprache').val(),$('#Sprachen').val(),$('#Ort').val(),$('#Gehoerlos').val(),mutterspracheVal);
    });
});


function getAddress(Geschlecht,Techniken,Muttersprache,Sprachen,Ort,Gehoerlos,notwenidg) {
    var url1 = $('.ajaxaddresscommunication').val();
    var allData = {
        'tx_pingagaddress_addresscommunication[useajax]': 1,
        'tx_pingagaddress_addresscommunication[Geschlecht]': Geschlecht,
        'tx_pingagaddress_addresscommunication[Techniken]': Techniken,
        'tx_pingagaddress_addresscommunication[Muttersprache]': Muttersprache,
        'tx_pingagaddress_addresscommunication[Sprachen]': Sprachen,
        'tx_pingagaddress_addresscommunication[Ort]': Ort,
        'tx_pingagaddress_addresscommunication[Gehoerlos]': Gehoerlos,
        'tx_pingagaddress_addresscommunication[notwenidg]': notwenidg,
        //'tx_inspiration_inspiration[page]': pageCount

    };
    $.ajax({
        type: 'POST',
        url: url1,
        data: allData,
        success: function (data) {

            $(".location-list").html($(data).find('.location-list').html());
            // Initialize accordion

        },
        error: function (jqXHR, textStatus, errorThrow) {
            console.log(errorThrow);
        }
    });
}



