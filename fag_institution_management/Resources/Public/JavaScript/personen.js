$('document').ready(function() { personenEditInit(); });

function personenEditInit(){

  // Backlink editieren
  var baseLink = $('a[title="Personen"]').attr('href');
  // var newLink = baseLink + '/institution/agentur-frontal';
  // $('a[title="Personen"]').attr('href', newLink);

  // Breadcrumbs anpassen
  // namen clearen
      //$('.kp-breadcrumbs > li.last').html('Niels Jayakumar');

  /***************************************************************************
  * Bild Upload
  */
  $('#kp_stammdaten_bild_upload').change(function(){

      $(this).simpleUpload("SimpleAjaxFrontend.php?type=savePersonEditStammdatenBild&stammdatenId=4", {

          start: function(file){
              //upload started
              //$('#filename').html(file.name);
              $('#progress').html("");
              $('#progressBar').width(0);
          },
          progress: function(progress){
              //received progress
              $('#progress').html("Progress: " + Math.round(progress) + "%");
              $('#progressBar').width(progress + "%");
          },
          success: function(data){

              // loggin ausgelaufen
              if(data == 'accessDenied!'){
                window.location.href = 'kopla/login';
              }

              //upload successful
              $('#progress').html("");

              setLogo(data[0]);
              $('.removeLogoWrapper').show();
          },
          error: function(error){
              //upload failed
              $('#progress').html("Failure!<br>" + error.name + ": " + error.message);
          }
      });
  });
  /**
  * Bild Upload
  ****************************************************************************/

  /***************************************************************************
  * Remove Logo Handler
  */

  function hideDeleteWrapper(){
    $('.toDelete--wrapper').hide();
  }

  function showDeleteWrapper(){
    $('.toDelete--wrapper').show();
  }

  function showRemoveLogoFile(){
    // bestigung aufrufen
    $('#confirmMessageLogo .changeMessage').html('Soll das Bild entfernt werden? Hochgeladene Dateien werden entfernt.');
    $('#confirmMessageLogo').show();
  }

  $('.removeLogoLink').click(function() {
    showRemoveLogoFile();
  });

  $('#bt_confirm_logo').click(function() {

    var personId = 4;
    $.ajax({
      type: "POST",
      url:  "SimpleAjaxFrontend.php",
      data: {
              type: "deletePersonBild",
              id: personId,
            },
      beforeSend: function()
      {

      },
      success: function(result)
      {
        // loggin ausgelaufen
        if(result == 'accessDenied!'){
          window.location.href = 'kopla/login';
        }
        hideDeleteWrapper();
        setLogo('');
        $('.removeLogoWrapper').hide();
      }
    });
  });

  $('#bt_cancel_logo').click(function() {
    hideDeleteWrapper();
  });
  /**
  * Remove Logo Handler
  ****************************************************************************/


  // Click Handler
  $('#bt_confirm').click(function() {
    $('input[name="stammEmail"]').val('niels1999@gmx.ch');
    $('.toDelete--wrapper').hide();
  });

  // Daten laden
  loadEditData();

  // Stammdatenhandler
  // $('.StammDatenEdit').remove();
  // Wenn checkbox für admin oder anmelderecht entfernt wird, soll noch eine Warnung angezeigt werden.
  warnRemoveRights();

  // Loader
  $('#KoplaPageLoading').fadeOut();

}

function warnRemoveRights()
{
  var itsYou = '';
  var admin = '';
  var anmeldetool = '';
  var wichRight = '';

  if(itsYou)
  {
    if(admin)
    {
      $('input[name="admin"]').click(function(e) {
        e.preventDefault();
        wichRight = 'admin';
        $('#peDialog .changeMessage').html('Wollen Sie Ihre Admin Rechte entziehen?');
        $('#peDialog').show();
      });
    }

    if(anmeldetool)
    {
      // Click Handler
      $('input[name="anmeldeverwalter"]').click(function(e) {
        e.preventDefault();
        wichRight = 'anmeldeverwalter';
        $('#peDialog .changeMessage').html('Wollen Sie Ihre Rechte für die Verwaltung des Anmeldetools entziehen?');
        $('#peDialog').show();
      });
    }
  }

  $('#bt_confirm_remove_right').click(function() {

    switch(wichRight)
    {
      case 'admin':
        $('input[name="admin"]').prop('checked', false);
      break;

      case 'anmeldeverwalter':
        $('input[name="anmeldeverwalter"]').prop('checked', false);
      break;
    }

    sendForm('4');
  });

  // Versteckt Dialog (Cancel)
  $('#bt_cancel_remove_right').click(function() {
    $('#peDialog').hide();
  });
}

function setLogo(logoUrl){
  $('#kp_stammdaten_bild_container').html('');
  $('#kp_stammdaten_bild_container').css('height', '150');
  $('#kp_stammdaten_bild_container').css('width', '320');
  $('#kp_stammdaten_bild_container').css('background-image', 'url(' + logoUrl +')');
  $('#kp_stammdaten_bild_container').css('background-size', 'cover');
  $('#kp_stammdaten_bild_container').css('background-position', 'center center');
  $('#kp_stammdaten_bild_container').css('background-repeat', 'no-repeat');
}

function sendForm(personId)
{

  $.ajax({
    type: "POST",
    url:  "SimpleAjaxFrontend.php",
    data: {
            type: "saveEditPerson",
            id: personId,
            position: $('input[name="position"]').val(),
            email: $('input[name="email"]').val(),
            mobile: $('input[name="mobile"]').val(),
            tel: $('input[name="tel"]').val(),
            strasse: $('input[name="strasse"]').val(),
            plz: $('input[name="plz"]').val(),
            ort: $('input[name="ort"]').val(),
                          published: $('input[value="published"]').is(':checked'),
            admin: $('input[value="admin"]').is(':checked'),

            email_default: $('input[name="email_default"]').is(':checked'),
            tel_default: $('input[name="tel_default"]').is(':checked'),
            mobile_default: $('input[name="mobile_default"]').is(':checked'),
            strasse_default: $('input[name="strasse_default"]').is(':checked'),
            plz_default: $('input[name="plz_default"]').is(':checked'),
            ort_default: $('input[name="ort_default"]').is(':checked'),
          },
  //   beforeSend: function()
  //   {
  //     // Loader
  //     $('#KoplaPageLoading').show();
  //   },
  //   success: function(result)
  //   {
  //     // loggin ausgelaufen
  //     if(result == 'accessDenied!'){
  //       window.location.href = 'kopla/login';
  //     }
  //     // alles gespeichert
  //     if(result == 'done'){
  //       window.location.href = '/kopla/meine-institutionen-verwalten/personen/institution/agentur-frontal';
  //     }
  //
  //     // stammdaten email nicht verfügbar
  //     if(result == 'username exist'){
  //       // Loader
  //       $('#KoplaPageLoading').hide();
  //
  //       $('.toDelete--wrapper strong').html($('input[name="stammEmail"]').val());
  //       $('.toDelete--wrapper').show();
  //     }
  //   }
   });
}

/****
** Content Loader
***/
function loadEditData(){


  // daten laden
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][title]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][zip]"]').val('');
  $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').val('');

  // // Namen zurückwandeln
  // var nameString = $('input[name=stammVorname]').val();
  // nameString = nameString.replace("&#x27;", "'");
  // $('input[name=stammVorname]').val(nameString)
  //
  // var nameString = $('input[name=stammName]').val();
  // nameString = nameString.replace("&#x27;", "'");
  // $('input[name=stammName]').val(nameString)
  //
  // $('input[value="published"]').attr('checked','checked');
  // // Bild
  //   $('.removeLogoWrapper').hide();


  // Stammdaten E-Mail
  $('input[value="email_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').val($('input[name="email_default"]').val());    $('input[value="email_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').val($('input[name="email_default"]').val());
    }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][email]"]').val('');      }
  });

  // Stammdaten Telefon
  $('input[value="tel_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').val('');    $('input[value="tel_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').val('');      }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][phone]"]').val('');      }
  });

  // Stammdaten Mobile
  $('input[value="mobile_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').val('');    $('input[value="mobile_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').val('');      }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][mobile]"]').val('');      }
  });

  // Stammdaten Strasse
  $('input[value="strasse_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').val('');    $('input[value="strasse_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').val('');      }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][address]"]').val('');
    }
  });

  // Stammdaten PLZ
  $('input[value="plz_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').val('');    $('input[value="plz_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').val('');      }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][Zip]"]').val('');
    }
  });

  // Stammdaten Ort
  $('input[value="ort_default"]').attr('checked','checked');$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').attr('disabled', true);$('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').val('');    $('input[value="ort_default"]').click(function() {
    if($(this).is(':checked'))
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').attr('disabled', true);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').val('');      }
    else
    {
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').attr('disabled', false);
      $('input[name="tx_faginstitutionmanagement_nextsteplogin[role][city]"]').val('');      }
  });

}
(function($) {
    $(document).ready(function() {
      $(document).accordion({
        // Put custom options here
        heightStyle: 'content',
        header: 'div.toggler',
        active: false,
        collapsible: true,
        create: function(event, ui) {
          ui.header.addClass('active');
          $('div.toggler').attr('tabindex', 0);
        },
        activate: function(event, ui) {
          ui.newHeader.addClass('active');
          ui.oldHeader.removeClass('active');
          $('div.toggler').attr('tabindex', 0);
        }
      });
    });
  })(jQuery);

  (function($) {
    $(document).ready(function() {
      $('.ce_table .sortable').each(function(i, table) {
        $(table).tablesorter();
      });
    });
  })(jQuery)


  // setTimeout(function(){var e=function(e,t){try{var n=new XMLHttpRequest}catch(r){return}n.open("GET",e,!0),n.onreadystatechange=function(){this.readyState==4&&this.status==200&&typeof t=="function"&&t(this.responseText)},n.send()},t="system/cron/cron.";e(t+"txt",function(n){parseInt(n||0)<Math.round(+(new Date)/1e3)-86400&&e(t+"php")})},5e3);
