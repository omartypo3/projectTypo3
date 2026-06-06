<?php

namespace Emagineurs\EAnnuaires\Wizards;

class userFunc{
    
    
    public function weekPicker($PA, $fObj){
        
        //REVOIR LES INCLUSIONS CSS ET JS AVEC XAVIER



$css = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css";
$js = "<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js\"></script>

<script type=\"text/javascript\">  
$(document).ready(function(){
 
$(function() {
    
    var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('#weekpicker').datepicker('widget').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('#weekpicker').datepicker( {
        showOtherMonths: false,
        selectOtherMonths: false,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            $('#weekpicker').val($.datepicker.formatDate( dateFormat, startDate, inst.settings )
                 + ' - ' + $.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            
            selectCurrentWeek();
        },
        beforeShow: function() {
            selectCurrentWeek();
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    }).datepicker('widget').addClass('ui-weekpicker');
    
    $('.ui-weekpicker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('.ui-weekpicker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
});});
</script>";

     //  var_dump($PA);
       // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($PA, '1');
       $backgroundColor = 'white';
        if (!empty($PA['parameters']['color'])) {
                $backgroundColor = $PA['parameters']['color'];
        }
       // $PA['item'] = '<div style="background-color: ' . $backgroundColor . '; padding: 4px;">' . $PA['item'] . '</div>';
 $color = (isset($PA['parameters']['color'])) ? $PA['parameters']['color'] : 'red';
        $formField  = '<style type="text/css">@import url("'.$css.'");</style>'
                . '<div style="padding: 5px; background-color: ' . $color . ';">';
    $formField .= '<input type="text" name="' . $PA['itemFormElName'] . '"';
    $formField .= ' value="' . htmlspecialchars($PA['itemFormElValue']) . '"';
    $formField .= ' onchange="' . htmlspecialchars(implode('', $PA['fieldChangeFunc'])) . '"';
    $formField .= $PA['onFocus'];
    $formField .= ' /></div>';
    $output = $formField;
        // Assemble the wizard itself
        $output .= '<div style="margin-top: 8px; margin-left: 4px;">';

       // $commonJavascriptCalls = $PA['fieldChangeFunc']['TBE_EDITOR_fieldChanged'] . $PA['fieldChangeFunc']['typo3form.fieldGet'] . ' return false;';
        // Create the + button
       // $onClick = "document." . $PA['itemFormElName'].".value++; " . $commonJavascriptCalls;
         $onClick = "document.getElementsByName('".$PA['itemFormElName']."')[0].value++" ;
        $output .= '<a href="#" onclick="' . htmlspecialchars($onClick) . '" style="padding: 6px; border: 1px solid black; background-color: #999">Choix semaine</a>';
        $output .= '</div>';
        $output .= ' <h1><p>Fecha de publicaci&oacute;n:&nbsp;<input type="text" id="weekpicker" required="required" name="newsdate"/></p></h1>'.$js;
   //      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($PA, '2');die();
        return $output;
    }
}