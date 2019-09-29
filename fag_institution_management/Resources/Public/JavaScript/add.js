// Global Vars
var removeSwitch = '';
var removeElementString = ''; // download File element
var datenCountId = 0;
var downloadCountId = 0;
var linkCountId = 0;

$('document').ready(function () {
    terminEditInit();
});

function terminEditInit() {

    // Beschreibung clearen & setzen
//        $('textarea[name="termineText"]').html('<p>Testbeschreibung</p>');

//    // Backlink editieren
//    var baseLink = $('a[title="Termine"]').attr('href');
//    var newLink = baseLink + '/institution/agentur-frontal';
//    $('a[title="Termine"]').attr('href', newLink);

//    // Wangerbrief deaktivieren
//    $('input[name="terminWangerblatt"]').attr('disabled', true);
//    // Versteckt Dialog nach Ok Klick
//    $('#bt_confirm_error').click(function() {
//      $('#errorDialog').hide();
//    });

    /***************************************************************************
     * Bild Upload
     */
//    $('#kp_bild_termine_upload').change(function(){

//        $(this).simpleUpload("SimpleAjaxFrontend.php?type=saveTermineBild&newTerminID=3&institutionID=1", {

//            start: function(file){
//                //upload started
//                //$('#filename').html(file.name);
//                $('#progress').html("");
//                $('#progressBar').width(0);
//            },
//            progress: function(progress){
//                //received progress
//                $('#progress').html("Progress: " + Math.round(progress) + "%");
//                $('#progressBar').width(progress + "%");
//            },
//            success: function(data){

//                // loggin ausgelaufen
//                if(data == 'accessDenied!'){
//                  window.location.href = 'kopla/login';
//                }

//                //upload successful
//                $('#progress').html("");

//                setLogo(data[0]);
//                $('.removeLogoWrapper').show();
//            },
//            error: function(error){
//                //upload failed
//                $('#progress').html("Failure!<br>" + error.name + ": " + error.message);
//            }
//        });
//    });
    /**
     * Bild Upload
     ****************************************************************************/


    /***************************************************************************
     * Daten Hinzufügen
     */
    // template

    $('#addNewDaten').click(function () {
        var index = $('#index').val();
        if (index < 4) {
            index++;
            $('#index').val(index);
            datenCountId++;
            var datenInputHtml = getDatenFileTemplate(datenCountId);
            var newElementString = '';
            newElementString += '<div class="datenElemnt  EntryElement" id="datenElemnt_' + datenCountId + '">';
            newElementString += datenInputHtml;
            newElementString += '</div>';
            $('#kp_termine_bild_container').append(newElementString);

            // upload handler
            var elementString = '#datenElemnt_' + datenCountId;
            datenEventHelper(elementString);
        }
    });
    /**
     * Daten Hinzufügen
     ****************************************************************************/


    /***************************************************************************
     * Downloads Hinzufügen
     */
    // template

    $('#addNewDownloadsFile').click(function () {
        downloadCountId = $('#indexdownload').val();
        var downloadInputHtml = getDownloadFileTemplate(downloadCountId);
        var newElementString = '';
        newElementString += '<li class="docsElemnt_' + downloadCountId + '">';
        newElementString += '<div class="uploadElemnt  EntryElement" id="uploadElment_' + downloadCountId + '">';
        newElementString += downloadInputHtml;
        newElementString += '</div>';
        newElementString += '</li>';
        $('.kp_neuerTermin_downloads_container').append(newElementString);
        downloadCountId++;
        $('#indexdownload').val(downloadCountId);
        // upload handler
        var elementString = '#uploadElment_' + downloadCountId;
        uploadFilesEventHelper(elementString);
    });

    // Sortable handler
    $('ul.kp_neuerTermin_downloads_container').sortable({
        handle: '.sortIcon',

        onDrop: function ($item, container, _super) {
            saveDownloadSorting();
            _super($item, container);
        }
    });

    // function saveDownloadSorting() {
    //     var newSortArray = Array();
    //
    //     $('.kp_neuerTermin_downloads_container li').each(function () {
    //         // neue ID reihenfolge in array speichern
    //         newSortArray.push($(this).find('input[name="nachrichtenDownloadId"]').val());
    //     });
    //
    //     $.ajax({
    //         type: "POST",
    //         url: "SimpleAjaxFrontend.php",
    //         data: {
    //             type: "saveTermineDownloadSorting",
    //             downloadIds: newSortArray,
    //         },
    //         beforeSend: function () {
    //             // Loader
    //             // $('#KoplaPageLoading').show();
    //         },
    //         success: function (result) {
    //             if (result == 'accessDenied!') {
    //                 window.location.href = 'kopla/login';
    //             }
    //             // Loader
    //             // $('#KoplaPageLoading').fadeOut();
    //         }
    //     });
    // }

    /**
     * Downloads Hinzufügen
     ****************************************************************************/

    /***************************************************************************
     * Links Hinzufügen
     */


    $('#addNewLink').click(function () {

        linkCountId= $('#indexlink').val();

        var linkInputHtml = getLinkTemplate(linkCountId);
        var newElementString = '';
        newElementString += '<li class="EntryElement-item">';
        newElementString += '<div class="linkElemnt  EntryElement" id="linkElment_' + linkCountId + '">';
        newElementString += linkInputHtml;
        newElementString += '</div>';
        newElementString += '</li>';

        $('.kp_neuerTermin_links_container').append(newElementString);
        linkCountId++;
        $('#indexlink').val(linkCountId);
        // upload handler
        var elementString = '#linkElment_' + linkCountId;
        linkEventHelper(elementString);
    });

    // Sortable handler
    $('ul.kp_neuerTermin_links_container').sortable({
        handle: '.sortIcon',

        onDrop: function ($item, container, _super) {
            _super($item, container);
        }
    });

    /**
     * Links Hinzufügen
     ****************************************************************************/

    /***************************************************************************
     * Remove Handler
     */
    // remove abfrage
    $('#bt_confirm').click(function () {

        switch (removeSwitch) {
            case 'downloads':

                $.ajax({
                    type: "POST",
                    url: "SimpleAjaxFrontend.php",
                    data: {
                        type: "deleteTermineDownload",
                        id: $(removeElementString + ' .uploadFileHidden').val(),
                    },
                    beforeSend: function () {

                    },
                    success: function (result) {
                        // loggin ausgelaufen
                        if (result == 'accessDenied!') {
                            window.location.href = 'kopla/login';
                        }

                        $(removeElementString).parent().remove();
                        hideDeleteWrapper();
                    }
                });
                break;
            case 'links':
                $(removeElementString).parent().remove();
                hideDeleteWrapper();
                break;
            case 'daten':
                var datenID = $(removeElementString + ' .terminDataId').val();

                $.ajax({
                    type: "POST",
                    url: "SimpleAjaxFrontend.php",
                    data: {
                        type: "deleteTerminData",
                        id: datenID,
                    },

                    beforeSend: function () {
                        // Loader
                        $('.toDelete--wrapper').hide();
                        $('#KoplaPageLoading').show();
                    },

                    success: function (result) {
                        // loggin ausgelaufen
                        if (result == 'accessDenied!') {
                            window.location.href = 'kopla/login';
                        }

                        // alles erledigt
                        if (result == 'done') {
                            $(removeElementString).remove();
                            $('#KoplaPageLoading').fadeOut();
                        }
                    }
                });
                break;
            case 'deleteThisTermin':
                $.ajax({
                    type: "POST",
                    url: "SimpleAjaxFrontend.php",
                    data: {
                        type: "todeleteTermin",
                        id: 3,
                    },
                    beforeSend: function () {

                    },
                    success: function (result) {
                        if (result == 'accessDenied!') {
                            window.location.href = 'kopla/login';
                        }

                        //  window.location.href = '/kopla/meine-institutionen-verwalten/termine/institution/agentur-frontal';
                        hideTerminDeleteWrapper();
                    }
                });
                break;
            default:

        }
    });
    // cancel handler
    $('#bt_cancel').click(function () {
        hideDeleteWrapper();
    });

    // // Delete Click Handler
    // $('.deleteTermin').click(function () {
    //     deleteTermin($(this).attr('deleteId'));
    // });

    /**
     * Remove Handler
     ****************************************************************************/

    /***************************************************************************
     * Remove Logo Handler
     */
    function showRemoveLogoFile() {
        // bestigung aufrufen
        $('#confirmMessageLogo .changeMessage').html('Soll das Bild entfernt werden? Hochgeladene Dateien werden entfernt.');
        $('#confirmMessageLogo').show();
    }

    $('.removeLogoLink').click(function () {
        showRemoveLogoFile();
    });

    $('#bt_confirm_logo').click(function () {

        var terminId = 3;
        $.ajax({
            type: "POST",
            url: "SimpleAjaxFrontend.php",
            data: {
                type: "deleteTerminLogo",
                id: terminId,
            },
            beforeSend: function () {

            },
            success: function (result) {
                // loggin ausgelaufen
                if (result == 'accessDenied!') {
                    window.location.href = 'kopla/login';
                }
                hideDeleteWrapper();
                setLogo('');
                $('.removeLogoWrapper').hide();
            }
        });
    });

    $('#bt_cancel_logo').click(function () {
        hideDeleteWrapper();
    });
    /**
     * Remove Logo Handler
     ****************************************************************************/

    // TinyMCE laden
    tinymce.init({
        selector: 'textarea[name=termineText]',
        menubar: false,
        plugins: ['autolink lists link'],
        toolbar: 'removeformat | bold italic underline | bullist | link | undo redo',
        language_url: './system/modules/kopla/assets/js/langs/de.js',
        default_link_target: '_blank',
        link_title: false,
        skin_url: "/files/assets/css/tinymce/kopla",
        skin: "kopla",
        //theme_url: '/files/assets/css/tinymce/inlite/inlite.js',
        //themes: "inlite",
        //inline: "true",
        valid_elements: 'a[href|target=_blank],strong/b,br,p,ul,li',
        entity_encoding: "raw",
    });

    // Daten laden
    loadEditData();

    // Pflicht Datenfeld erstellen
    //$('#addNewDaten').click();
    //$('#datenElemnt_1 .removeWrapper').hide();

    // Button Umschreiben
    // var buttonString = $('button[type="submit"]').html();
    // $('button[type="submit"]').html(buttonString.replace('erstellen', 'speichern'));


    // Loader
    $('#KoplaPageLoading').fadeOut();

}

function setLogo(logoUrl) {
    $('#kp_termine_bild_container').html('');
    $('#kp_termine_bild_container').css('height', '150');
    $('#kp_termine_bild_container').css('width', '320');
    $('#kp_termine_bild_container').css('background-image', 'url(' + logoUrl + ')');
    $('#kp_termine_bild_container').css('background-size', 'cover');
    $('#kp_termine_bild_container').css('background-position', 'center center');
    $('#kp_termine_bild_container').css('background-repeat', 'no-repeat');
}

function removeDatum(datenCountId) {
      if($( "input[name='tx_faginstitutionmanagement_terminal[dates]["+datenCountId+"][startdate]']" ).val()!=''){
          $('.toDelete--wrapper.date').show();
          $('.toDelete--wrapper.date #bt_confirmdate').attr('index',datenCountId);
      }else{
          var index = $('#index').val();
          index--;
          $('#index').val(index);
          $('#datenElemnt_' + datenCountId).remove();
      }


}
function removeEventLink(linkCountId) {
      if($("#linkElment_"+linkCountId+" input[name='tx_faginstitutionmanagement_terminal[linkUrl][]" ).val()!='' && $("#linkElment_"+linkCountId+" input[name='tx_faginstitutionmanagement_terminal[linkText][]" ).val()!=''){
          $('.toDelete--wrapper.links').show();
          $('.toDelete--wrapper.links #bt_confirmlinks').attr('index',linkCountId);
      }else{
          var index = $('#indexlink').val();
          index--;
          $('#indexlink').val(index);
          $('#linkElment_' + linkCountId).parent().remove();
      }


}

function removeDocs(downloadCountId){
    //console.log($('.docsElemnt_' + downloadCountId).find('input[name="tx_faginstitutionmanagement_terminal[newEvent][document][]"]').val());
    if ($('.docsElemnt_' + downloadCountId).find('input[name="tx_faginstitutionmanagement_terminal[newEvent][document][]"]').val() == '' && $('.docsElemnt_' + downloadCountId).find('.uploadFileHidden').length == 0) {
    var index = $('#indexdownload').val();
    index--;
    $('#indexdownload').val(index);
    $('.docsElemnt_' + downloadCountId).remove();
}else{
    $('.toDelete--wrapper.downloads').show();
    $('.toDelete--wrapper.downloads #bt_confirmdownloads').attr('index',downloadCountId);
    $('.toDelete--wrapper.downloads .bt_confirmdownloadsupdate').attr('index',downloadCountId);
}
    // if ($('.docsElemnt_' + downloadCountId).find('.uploadFileHidden').length == 0) {
    //     $('.docsElemnt_' + downloadCountId).remove();
    // } else {
    //     $('.docsElemnt_' + downloadCountId).hide();
    //     $( ".docsElemnt_" + downloadCountId + " input[id^='deleted_']" ).val( "1" );
    // }

}

function getDatenFileTemplate(datenCountId) {
    var datenInputHtml = '';

    //datenInputHtml += '<div class="datenInputWrapper">';
    //datenInputHtml += '<label>Bezeichnung*</label>';
    //datenInputHtml += '<input class="bezeichnung" value="" required name="bezeichnung" type="text">';
    //datenInputHtml += '</div>';

    datenInputHtml += '<div class="EntryInputWrapper datenInputWrapper">';
    datenInputHtml += '<label>Start-Datum*</label>';
    datenInputHtml += '<input autocomplete="off" name="tx_faginstitutionmanagement_terminal[dates][' + datenCountId + '][startdate]" class="termineStartDatum mandatory datepicker" required="" type="text">';
    datenInputHtml += '</div>';

    datenInputHtml += '<div class="EntryInputWrapper datenInputWrapper">';
    datenInputHtml += '<label>End-Datum (für mehrtägige Events; optional)</label>';
    datenInputHtml += '<input autocomplete="off" name="tx_faginstitutionmanagement_terminal[dates][' + datenCountId + '][enddate]" class="termineEndDatum  datepicker" type="text">';
    datenInputHtml += '</div>';

    datenInputHtml += '<div class="EntryInputWrapper datenInputWrapper">';
    datenInputHtml += '<label>Start-Zeit (optional)</label>';
    datenInputHtml += '<input autocomplete="off" name="tx_faginstitutionmanagement_terminal[dates][' + datenCountId + '][starttime]" class="termineStartZeit  timepicker" name="termineStartZeit" type="text">';
    datenInputHtml += '</div>';

    datenInputHtml += '<div class="EntryInputWrapper datenInputWrapper">';
    datenInputHtml += '<label>End-Zeit (optional)</label>';
    datenInputHtml += '<input autocomplete="off" name="tx_faginstitutionmanagement_terminal[dates][' + datenCountId + '][endtime]" class="termineEndZeit  timepicker" name="termineEndZeit" type="text">';
    datenInputHtml += '</div>';
    datenInputHtml += '<div class="removeWrapper">';
    datenInputHtml += '<a class="removeLink" href="javascript:{}" onclick="removeDatum(' + datenCountId + ')"><i class="fa fa-trash"></i> Datum entfernen</a>';
    datenInputHtml += '</div>';

    return datenInputHtml;
}

function getDownloadFileTemplate(downloadCountId) {
    var downloadInputHtml = '';
    var object = 'newEvent';
    if ($('#type').length > 0) {
        object = $('#type').val();
    }
    if($('#type').val()=='institution'){
        var name = 'tx_faginstitutionmanagement_nextsteplogin';
    }else{
        var name = 'tx_faginstitutionmanagement_terminal';
    }
    downloadInputHtml += '<div class="downlaodInputWrapper  EntryInputWrapper">';
    downloadInputHtml += '<span class="sortIcon"><i class="fa fa-sort"></i></span>';
    downloadInputHtml += '<label>Bezeichnung</label>';
    downloadInputHtml += '<input class="download_text" required value="" name="'+name+'[docstitle][]" type="text">';
    downloadInputHtml += '</div>';


    downloadInputHtml += '<div class="downlaodInputWrapper   EntryInputWrapper  toReplace">';
    downloadInputHtml += '<label>Datei</label>';
    downloadInputHtml += '<div class="inputWrapper"><input name="'+name+'[' + object + '][document][]" type="file"></div>';
    downloadInputHtml += '<div class="status"></div>';
    downloadInputHtml += '</div>';

    downloadInputHtml += '<div class="removeWrapper">';
    if($('#type').val()=='institution'){
        downloadInputHtml += '<a class="removedownload-start" href="javascript:{}"  ><i class="fa fa-trash"></i> Download entfernen</a>';
    }else{
        downloadInputHtml += '<a class="removeLink" href="javascript:{}"  onclick="removeDocs(' + downloadCountId + ')"><i class="fa fa-trash"></i> Download entfernen</a>';
    }
    downloadInputHtml += '</div>';

    return downloadInputHtml;
}

function getLinkTemplate(linkCountId) {
    var linkInputHtml = '';
    linkInputHtml += '<div class="linkInputWrapper  EntryInputWrapper">';
    linkInputHtml += '<span class="sortIcon"><i class="fa fa-sort"></i></span>';
    linkInputHtml += '<label>Link Text</label>';
    linkInputHtml += '<input class="link_text" value="" required name="tx_faginstitutionmanagement_terminal[linkText][]" type="text">';
    linkInputHtml += '</div>';
    linkInputHtml += '<input class="linkFileHidden" type="hidden" name="nachrichtenLinkId" value="">';

    linkInputHtml += '<div class="linkInputWrapper  EntryInputWrapper">';
    linkInputHtml += '<label>Link URL</label>';
    linkInputHtml += '<input class="link_url mandatory" value="http://" required name="tx_faginstitutionmanagement_terminal[linkUrl][]" type="text">';
    linkInputHtml += '</div>';

    linkInputHtml += '<div class="removeWrapper">';
    linkInputHtml += '<a class="removeLink mandatory" onclick="removeEventLink('+linkCountId+')" href="javascript:{}"><i class="fa fa-trash"></i> Link entfernen</a>';
    linkInputHtml += '</div>';

    return linkInputHtml;
}

function setDatePicker(targetString) {
    $(targetString).datepicker({dateFormat: 'dd/mm/yy',});
}

function setTimePicker(targetString) {
    $(targetString).timepicker({'scrollDefault': 'now', 'timeFormat': 'H:i', 'step': 15,});
}


function datenEventHelper(elementString) {
    setDatePicker(elementString + ' .termineStartDatum');
    setDatePicker(elementString + ' .termineEndDatum');

    setTimePicker(elementString + ' .termineStartZeit');
    setTimePicker(elementString + ' .termineEndZeit');


    $(elementString + ' .removeLink').click(function () {
        if ($(elementString + ' .termineStartDatum').val() == '') {
            $(elementString).remove();
        } else {
            //link entfernen
            removeDaten(elementString);
        }
    });
}

function uploadFilesEventHelper(elementString) {
    $(elementString + ' .uploadFile').change(function () {
        //  download hinzufügen
        $(this).simpleUpload("", {

            start: function (file) {
                //upload started
                $(elementString + ' .status').html("");
                //$('#progressBar').width(0);
            },
            progress: function (progress) {
                //received progress
                $(elementString + ' status').html("Progress: " + Math.round(progress) + "%");
                //$('#progressBar').width(progress + "%");
            },
            success: function (data) {
                // loggin ausgelaufen
                if (data == 'accessDenied!') {

                }

                //upload successful
                $(elementString + ' status').html("");

                $(elementString + ' .inputWrapper').html(data[0]);
                $(elementString + ' .uploadFileHidden').val(data[1]);
            },
            error: function (error) {
                //upload failed
                $(elementString + ' .status').html("Failure!<br>" + error.name + ": " + error.message);
            }
        });
    });

    $(elementString + ' .removeLink').click(function () {
        if ($(elementString + ' .uploadFileHidden').val() == '') {
            $(elementString).parent().remove();
        } else {
            //download entfernen
            removeDownloadFile(elementString);
        }
    });
}

function linkEventHelper(elementString) {
    $(elementString + ' .removeLink').click(function () {
        if ($(elementString + ' .link_text').val() == '') {
            $(elementString).parent().remove();
        } else {
            //link entfernen
            removeLink(elementString);
        }
    });
}

/**
 * Delete Hanlder
 ***********************************************/
function removeDownloadFile(elementString) {
    removeElementString = elementString;
    removeSwitch = "downloads";

    // bestigung aufrufen
    $('#confirmMessage .changeMessage').html('Soll der Download entfernt werden? Hochgeladene Dateien werden entfernt.');
    $('#confirmMessage').show();
}

function removeLink(elementString) {
    removeElementString = elementString;
    removeSwitch = "links";

    // bestigung aufrufen
    $('#confirmMessage .changeMessage').html('Soll der Link entfernt werden?');
    $('#confirmMessage').show();
}

function removeDaten(elementString) {
    removeElementString = elementString;
    removeSwitch = "daten";

    // bestigung aufrufen
    $('#confirmMessage .changeMessage').html('Soll das Datum entfernt werden?');
    $('#confirmMessage').show();
}

function deleteTermin() {
    removeSwitch = "deleteThisTermin";

    // bestigung aufrufen
    $('#confirmMessage .changeMessage').html('Soll der Termin mit allen dazugehörigen Inhalten gelöscht werden?');
    $('#confirmMessage').show();
}


function hideDeleteWrapper() {
    $('.toDelete--wrapper').hide();
}

function showDeleteWrapper() {
    $('.toDelete--wrapper').show();
}

function sendForm(newTerminID) {

    // check anzahl Links
    var linkTempArray = new Array();
    var linkCounter = 0;
    $('.linkElemnt').each(function () {
        var linkText = $(this).find('.link_text').val();
        var linkUrl = $(this).find('.link_url').val();
        var link = new Array(linkText, linkUrl, linkCounter);
        linkTempArray.push(link);
        linkCounter = linkCounter + 1;
    });

    // check anzahl downloads
    var downloadsTempArray = new Array();
    $('.uploadElemnt').each(function () {
        var downloadText = $(this).find('.download_text').val();
        var nachrichtenDownloadId = $(this).find('.uploadFileHidden').val();
        var downlaod = new Array(downloadText, nachrichtenDownloadId);
        downloadsTempArray.push(downlaod);
    });

    // check anzahl daten
    var datenTempArray = new Array();
    $('.datenElemnt').each(function () {
        var bezeichnung = $(this).find('.bezeichnung').val();
        var termineStartDatum = $(this).find('.termineStartDatum').val();
        var termineEndDatum = $(this).find('.termineEndDatum').val();
        var termineStartZeit = $(this).find('.termineStartZeit').val();
        var termineEndZeit = $(this).find('.termineEndZeit').val();
        var terminDataId = $(this).find('.terminDataId').val();
        var daten = new Array(bezeichnung, termineStartDatum, termineEndDatum, termineStartZeit, termineEndZeit, terminDataId);
        datenTempArray.push(daten);
    });

    var newSortArray = Array();

    $('.kp_neuerTermin_downloads_container li').each(function () {
        // neue ID reihenfolge in array speichern
        newSortArray.push($(this).find('input[name="nachrichtenDownloadId"]').val());
    });

    $.ajax({
        type: "POST",
        url: "SimpleAjaxFrontend.php",
        data: {
            type: "saveNewTermin",
            id: newTerminID,
            links: linkTempArray,
            downloads: downloadsTempArray,
            downloadIds: newSortArray,
            daten: datenTempArray,
            title: $('input[name="titel"]').val(),
            ort: $('input[name="ort"]').val(),
            beschreibung: tinyMCE.activeEditor.getContent(),
            wangerblatt: $('input[value="terminWangerblatt"]').is(':checked'),
        },
        beforeSend: function () {
            // Loader
            $('#KoplaPageLoading').show();
        },
        success: function (result) {
            // loggin ausgelaufen
            if (result == 'accessDenied!') {
                window.location.href = 'kopla/login';
            }
            // alles gespeichert
            if (result == 'done') {
                //  window.location.href = '/kopla/meine-institutionen-verwalten/termine/institution/agentur-frontal';
            }
        }
    });

}


/****
 ** Content Loader
 ***/
function loadEditData() {

    //  $('input[name="titel"]').val('Testanlass');
    //  $('input[name="ort"]').val('Willisau');

    $('input[value="terminWangerblatt"]').prop('checked', false);
    // Bild
    $('.removeLogoWrapper').hide();
    // Downloads

    // Links
    $('#addNewLink').click();
    //  var elementString = '#linkElment_' + linkCountId;$(elementString + ' .link_text').val('Agentur Frontal');$(elementString + ' .link_url').val('http://www.frontal.ch');$(elementString + ' .linkFileHidden').val('7');
    // daten
    $('#addNewDaten').click();
    //  var elementString = '#datenElemnt_' + datenCountId;$(elementString + ' .termineStartDatum').val('05.07.2019');$(elementString + ' .termineEndDatum').val('');$(elementString + ' .termineStartZeit').val('20:00');$(elementString + ' .termineEndZeit').val('23:30');$(elementString + ' .terminDataId').val('4');$('#addNewDaten').click();var elementString = '#datenElemnt_' + datenCountId;$(elementString + ' .termineStartDatum').val('11.05.2019');$(elementString + ' .termineEndDatum').val('');$(elementString + ' .termineStartZeit').val('18:00');$(elementString + ' .termineEndZeit').val('21:00');$(elementString + ' .terminDataId').val('5');$('#addNewDaten').click();var elementString = '#datenElemnt_' + datenCountId;$(elementString + ' .termineStartDatum').val('08.08.2019');$(elementString + ' .termineEndDatum').val('');$(elementString + ' .termineStartZeit').val('');$(elementString + ' .termineEndZeit').val('');$(elementString + ' .terminDataId').val('7');    $('#datenElemnt_1 .removeWrapper').hide();
}


//newSortArray

var idToUnlink = '';

$('document').ready(function () {
    initPersonenListe();
    $('.datepicker').datepicker({dateFormat: 'dd/mm/yy',});
    $('.timepicker').timepicker({'scrollDefault': 'now', 'timeFormat': 'H:i', 'step': 15,});
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#outputImage').html('');
            setTimeout(function () {
                $('#outputImage').html('<img src="'+e.target.result+'" width="200" height="200" />');
            }, 500);
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
function initPersonenListe() {
    // Sortable handler
    $('ol.personenListe').sortable({
        handle: '.sortIcon',
        update: function ($item, container, _super) {
            saveNewSortPersonen();

        }
    });


    // cancel handler
    $('#bt_cancel').click(function () {
        hideDeleteWrapper();
    });

    // confirm delete handler
    $('#bt_confirm').click(function () {

        window.location.href = idToUnlink;
    });

    /*************
     * Sorting Handler
     **************************************************************/
    $('.deletIcon').each(function () {
        $(this).click(function () {
            unlinkPerson($(this).parent().find('.personLinkId').val());
        });
    });
}

// Live speichern der Sortierung
function saveNewSortPersonen() {
    var newSortArray = Array();

    $('.personenListe .personWrapper').each(function () {
        // neue ID reihenfolge in array speichern

        newSortArray.push($(this).find('.personsortId').val());
    });
    $.ajax({
        type: "POST",
        url: $('#urlsorting').val(),
        data: {
            'tx_faginstitutionmanagement_nextsteplogin[users]': newSortArray
        },
        beforeSend: function () {
            // Loader
            $('#KoplaPageLoading').show();
        },
        success: function (result) {
            // Loader
            $('#KoplaPageLoading').fadeOut();
        },
        error: function (jqXHR, textStatus, errorThrow) {
           console.log('Ajax request - ' + textStatus + ': ' + errorThrow);
        }
    });
}

function unlinkPerson(id) {
    idToUnlink = id;
    $('.toDelete--wrapper').show();
}

function hideDeleteWrapper() {
    $('.toDelete--wrapper').hide();
}

function showDeleteWrapper() {
    $('.toDelete--wrapper').show();
}
function modifValues(){
    var val = $('#progress progress').attr('value');
    if(val<100) {
        var newVal = val * 1 + 1;
        var txt = Math.floor(newVal) + '%';

        $('#progress progress').attr('value', newVal).text(txt);
        $('#progress strong').html(txt);
    }
}


(function ($) {
    $(document).ready(function () {
        $(document).accordion({
            // Put custom options here
            heightStyle: 'content',
            header: 'div.toggler',
            collapsible: true,
            active: false,
            create: function (event, ui) {
                ui.header.addClass('active');
                $('div.toggler').attr('tabindex', 0);
            },
            activate: function (event, ui) {
                ui.newHeader.addClass('active');
                ui.oldHeader.removeClass('active');
                $('div.toggler').attr('tabindex', 0);
            }
        });
        $('#uploadImage').on('change',function () {
            $('#progress').show();
            setInterval(function(){ modifValues(); },5);
            $('.image_preview').remove();
            $('input#uploadImage-file-reference').remove();
                readURL(this);
            setTimeout(function () {
               $('#progress').hide();
               $('.removeLogoWrapper').show();
            }, 500);

        })
        $('.removeLogoLink').click(function () {
            $('.toDelete--wrapper.image').show();
        })
        $('.toDelete--wrapper.image #bt_confirme').click(function (e) {
            e.preventDefault();
            $('#uploadImage').val('');
            $('.removeLogoWrapper').hide();
            $('#outputImage').html('');
            $('.image_preview').remove();
            $('input#uploadImage-file-reference').remove();
            $('.toDelete--wrapper.image').hide();
        });
        $('.toDelete--wrapper.date #bt_confirmdate').click(function () {
            var index = $('#index').val();
            index--;
            $('#index').val(index);
            $('#datenElemnt_' + $(this).attr('index')).remove();
            $('.toDelete--wrapper.date').hide();
        })
        $('.toDelete--wrapper.links #bt_confirmlinks').click(function () {
            var index = $('#indexlink').val();
            index--;
            $('#indexlink').val(index);
            $('#linkElment_' + $(this).attr('index')).parent().remove();
            $('.toDelete--wrapper.links').hide();
        })
        $('.bt_cancel').click(function () {
            $('.toDelete--wrapper').hide();
        })
        $('.toDelete--wrapper.downloads #bt_confirmdownloads').click(function () {
            var index = $('#indexdownload').val();
            index--;
            $('#indexdownload').val(index);
            $('.docsElemnt_' + $(this).attr('index')).remove();
            $('.toDelete--wrapper.downloads').hide();
        });
        $('.toDelete--wrapper.downloads .bt_confirmdownloadsupdate').click(function () {
            var index = $('#indexdownload').val();
            index--;
            $('#indexdownload').val(index);
            $('.docsElemnt_' + $(this).attr('index')).remove();
            $('.toDelete--wrapper.downloads').hide();
        })
    });
})(jQuery);

(function ($) {
    $(document).ready(function () {
        $('.ce_table .sortable').each(function (i, table) {
            $(table).tablesorter();
        });
    });
})(jQuery);


