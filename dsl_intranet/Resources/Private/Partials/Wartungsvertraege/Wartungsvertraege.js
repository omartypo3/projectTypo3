$(document).ready(function() {
$.each( $('.sichtbarkeitCheckbox:checked'), function( key, value ) {
		$(this).next().children().addClass('active');
	});
	$('.sichtbarkeitCheckboxBtn').click(function(e) {
console.log("test");
		if($(this).children('.btn').hasClass('active')){

			$(this).prev('.sichtbarkeitCheckbox').prop( "checked", false );

		} else {
			$(this).prev('.sichtbarkeitCheckbox').prop( "checked", true );
		}

	});

	
	$('.checkboxBtn').click(function(e) {

		if($(this).children('.btn').hasClass('active')){

			$(this).prev('.disableCheckbox').prop( "checked", false );

		} else {
			$(this).prev('.disableCheckbox').prop( "checked", true );
		}

	});
	
	$('.validator_required').attr('required','required');
	
	
	$('.fullDatePicker').datetimepicker({
		locale: 'de',
		sideBySide: true,
		showTodayButton: true,
		showClear: true,
		showClose: true,
		toolbarPlacement: 'bottom',
		format: 'DD.MM.YYYY'
	});
	$('.fullDatePicker,.fullDateTimePicker').datetimepicker('show');$('.fullDatePicker,.fullDateTimePicker').datetimepicker('hide');
	
	$('.selectpickerFormular').selectpicker();
	
	
	
$('.animated').autosize({append: "\n"});

});