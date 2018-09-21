TYPO3.jQuery(document).ready(function () {
    LoadRte();
    $('body').on('change', "#amazingspeaker", function () {
        if(this.checked) {
            $("#speaker").removeClass("hidden");
        }
        else {
            $("#speaker").addClass("hidden");
        }

    });
    if($('#amazingspeaker:checkbox:checked').length >0) {
        $("#speaker").removeClass("hidden");

    }
    document.querySelector("html").classList.add('js');
    InputFileStyle(".if1",".ift1",".fr1");
});



function InputFileStyle(input_file,input_file_trigger,file_return){

    var fileInput2  = document.querySelector( input_file ),
        button2     = document.querySelector( input_file_trigger ),
        the_return2 = document.querySelector(file_return);

    button2.addEventListener( "keydown", function( event ) {
        if ( event.keyCode == 13 || event.keyCode == 32 ) {
            fileInput2.focus();
        }
    });
    button2.addEventListener( "click", function( event ) {
        fileInput2.focus();
        return false;
    });
    fileInput2.addEventListener( "change", function( event ) {
        the_return2.innerHTML = this.value;
    });
}
function LoadRte() {

    require(["/typo3conf/ext/dld/Resources/Public/scripts/ckeditor/ckeditor.js"], function () {
      if($('form[name="people"]').length) {
          CKEDITOR.replace('tx_dld_web_dlddldback[people][biography]');

      }
      if($('form[name="newPeople"]').length) {
          CKEDITOR.replace('tx_dld_web_dlddldback[newPeople][biography]');
      }

    });
}
