function initForm(){
    $('.ecomment_fileuploader').change(function(e){
        createNextUploadField(this);
        e.stopImmediatePropagation();
    });
}

function createNextUploadField(elem){
    if($(elem).val() != ''){
        currentName = $(elem).attr('name');
        currentNumber = currentName.substring(currentName.length-2,currentName.length-1);
        newNumber = parseInt(currentNumber)+1;

        if($('input[name*=file-'+newNumber+']').length < 1){
            currentField = $(elem).closest('.controls').clone();
            currentFieldHtml = $(elem).closest('.controls').html();
            newField = replaceAll(currentFieldHtml,'file-'+currentNumber,'file-'+newNumber);

            currentField.html(newField);
            $(elem).parent().after(currentField);
            initForm();

            $(elem).closest('.controls').find('.ecomment-remove-button').show();
            $(elem).closest('.controls').find('.ecomment_fileuploader').off('change');
        }
    }
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function removeUploadField(elem) {
    $(elem).closest('.controls').remove();
}

$(document).ready(function() {
    initForm();

    $('.ecomment-remove-button').hide();
});