var dateienElement = $('#dateien');
var dateienAjaxUrl = dateienElement.data('dateienAjaxUrl');
var checkFileAjaxUrl = dateienElement.data('checkFileAjaxUrl');

var pendingFiles = new Object();

$(function() {
		
		
	$('#dateienUploadForm').validate({
		submitHandler: function(form) {

			/*nicht genutzt !?*/
			files    = $('#dateienUploadForm').find('#fileUploadDateien')[0].files;

			$.each(files, function(i, file) {

				if(file["type"] == 'application/pdf' 
					|| file["type"] == 'image/png' 
					|| file["type"] == 'image/jpeg'
					|| file["type"] == 'application/vnd.ms-excel'
					|| file["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
				    || file["type"] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
					|| file["type"] == 'application/msword'
					|| file["type"] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
				    || file["type"] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'
					|| file["type"] == 'application/x-zip-compressed'
				    || file["type"] == 'video/mp4'
				    || file["type"] == 'video/quicktime'
					|| file["type"] == 'application/postscript'
				  ) {
					//console.log('filetype: '+file["type"]);
					submitDateiForm(file);
				} 
				

			});
			
			return false;
	}});
	
	
	// initialize
	function Init() {

		var fileselect = $id("fileUploadDateien"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// file drop
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "inline-block";

			// remove submit button
			submitbutton.style.display = "none";
			fileselect.style.display = "none";
		}

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}
	
	
	$( "#filedrag" ).click(function() {
	  $('#fileUploadDateien').click();
	});
	
	//$('#filedrag')
	
});


// getElementById
function $id(id) {
	return document.getElementById(id);
}


// output information
function Output(msg) {
	var m = $id("messages");
	m.innerHTML = m.innerHTML+msg;
}


var uploadCounter = 0;


	function submitDateiForm(file) {

		var fileMD5 = $.md5(file.name+file.type+file.size);

		if(pendingFiles[fileMD5]) {
			return false;
		}

		if(file["type"] != 'application/pdf' 
			&& file["type"] != 'image/png' 
			&& file["type"] != 'image/jpeg'
			&& file["type"] != 'application/vnd.ms-excel'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
			&& file["type"] != 'application/msword'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
			&& file["type"] != 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'
			&& file["type"] != 'application/x-zip-compressed'
			&& file["type"] != 'video/mp4'
			&& file["type"] != 'video/quicktime'
		   && file["type"] != 'application/postscript'


		  ) {
			
			return false;
		} 
		
		
		$('#uploadOverlay').show();
		$('body').addClass('filedragAbsolute');

		uploadCounter++;

		Output(
			'<div data-unique-check="true" class="fileuploadPending"><hr><p>' + file.name +
			'&nbsp;<span class="proceedCont fileExists">(Datei existiert bereits)</span></p> <progress data-file-size="'+file.size+'" data-file-name="'+file.name+'" class="'+fileMD5+'" min="0" max="100" value="0">0% complete</progress>&nbsp;&nbsp;<span class="fileSizeRemainingWrapper"><span class="fileSizeRemaining">0% - '+formatBytes(file.size,1)+'</span> verbleibend</span><div class="proceedCont"><div class="vorhandeneDatei"></div><div class="btn-group"><a class="btn btn-warning" href="#" data-proceed-action="delete">Vorhandene überschreiben</a><a class="btn btn-warning btn-middle" href="#" data-proceed-action="rename">als Kopie hochladen</a><a class="btn btn-default" data-proceed-action="cancel" href="#">nicht hochladen</a></div></div></div>'
		);


		var formData = new FormData();
		params  = $('#dateienUploadForm').serializeArray();

		formData.append('tx_dslintranet_downloadcenter[newDateien][datei]', file);

		$.each(params, function(i, val) {
			formData.append(val.name, val.value);
		});

		pendingFiles[fileMD5] = {formData:formData,url:$('#dateienUploadForm').attr('action')}

		var checkAjaxJson = {"tx_dslintranet_downloadcenter[fileMD5]":fileMD5,"tx_dslintranet_downloadcenter[fileName]":file.name};
		dslIntranetAjaxCall(checkFileAjaxUrl,checkAjaxJson).done(function (data /* , textStatus, jqXHR */ ) {
			
			var dataJson = JSON.parse($(data).find('textarea#resultJson').val());

			if(dataJson.beginUpload){
				startUpload(dataJson.fileMD5);
			} else {
				askForProceed(dataJson.fileMD5);
				
				
				var progressBarSelector = 'progress.'+fileMD5;
				$(progressBarSelector).closest('.fileuploadPending').find('.vorhandeneDatei').html($(data).find('.vorhandeneDatei').html());

			}
		});

		refreshFileCounter();

		
	}
	function askForProceed(fileMD5){
		var progressBarSelector = 'progress.'+fileMD5;
		$(progressBarSelector).closest('.fileuploadPending').addClass('askForProceed');
		
		$(progressBarSelector).closest('.fileuploadPending').find( ".proceedCont .btn" ).bind( "click", function() {
			
			switch($(this).data('proceed-action')) {
				case 'rename':
					$(this).unbind( "click" );
					$(this).closest('.fileuploadPending').removeClass('askForProceed');
					startUpload(fileMD5);
					break;
				case 'delete':
					pendingFiles[fileMD5].formData.append('tx_dslintranet_downloadcenter[proceedAction]', 'delete');
					pendingFiles[fileMD5].formData.append('tx_dslintranet_downloadcenter[fileName]', $(progressBarSelector).data('file-name'));
					$(this).unbind( "click" );
					$(this).closest('.fileuploadPending').removeClass('askForProceed');
					startUpload(fileMD5);
					break;
				default:
					$(this).closest('.fileuploadPending').remove();
					delete pendingFiles[fileMD5];
					refreshFileCounter();
			}
			
		  	return false;
		});
		
	}

	function startUpload(fileMD5){
		$.ajax({
			url: pendingFiles[fileMD5].url,
			type: 'POST',
			data: pendingFiles[fileMD5].formData,
			contentType: false,
			processData: false,
			success: function(data) {
				
				if(isJsonString(data)){
					dataJson = JSON.parse(data);
					if(dataJson["protokollePendingUid"]) {
						showMailFormProtokollePending(dataJson["protokollePendingUid"]);
					}
				}
				dataTableDateienListReloadRequest = true;
				dataTableReload();
			},
			xhr: function()
				  {
					var xhr = new window.XMLHttpRequest();
					var progressBarSelector = 'progress.'+fileMD5;

					xhr.upload.addEventListener("progress", function(evt){
					  if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						  $(progressBarSelector).val((percentComplete) * 100);
						  $(progressBarSelector).html( Math.ceil((percentComplete*100))+'% Abgeschlossen' );

						  if(percentComplete==1) {
							  $(progressBarSelector).closest('.fileuploadPending').remove();
							  delete pendingFiles[fileMD5];
						  } else {
							  var remaining = evt.total-evt.loaded;
							  $(progressBarSelector).closest('.fileuploadPending').find('.fileSizeRemaining').html(Math.ceil((percentComplete*100))+'% - '+formatBytes(remaining,1));

						  }
						  
						  
						  refreshFileCounter();
						  
					  }
					}, false);

					//Download progress
					xhr.addEventListener("progress", function(evt){
					  if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
					  }
					}, false);
					return xhr;
				  }
		});
		
	}
	function refreshFileCounter(){
		var anzahlUploads = $('.fileuploadPending progress').length;
		var anzahlUploadsAbgeschlossen = $('.fileuploadPending progress[value="100"]').length;
		var anzahlUploadsAusstehend = anzahlUploads-anzahlUploadsAbgeschlossen;

		if(anzahlUploadsAusstehend>1) $('#uploadInformation').html(anzahlUploadsAusstehend+" Dateien werden hochgeladen"); else $('#uploadInformation').html(anzahlUploadsAusstehend+" Datei wird hochgeladen");

		if(anzahlUploadsAbgeschlossen==anzahlUploads) {
		  $('#uploadOverlay').hide();
		  $('body').removeClass('filedragAbsolute');
		}
	}
	function $id(id) {
		return document.getElementById(id);
	}

	// file drag hover
	function FileDragHover(e) {
		
		if(e.target.className != 'bb bb-upload'){
			
			e.stopPropagation();
			e.preventDefault();
			e.target.className = (e.type == "dragover" ? "hover" : "");
		}
	}


	// file selection
	function FileSelectHandler(e) {

		// cancel event and hover styling
		FileDragHover(e);

		// fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			submitDateiForm(f);
			
		}

	}


function setOpenAuftrag(id,href){
	var ajaxJson = {"tx_dslintranet_downloadcenter[switch]":'setOpenAuftrag',"tx_dslintranet_downloadcenter[auftrag]":id};

	dslIntranetAjaxCall(dateienAjaxUrl,ajaxJson).done(function (data /* , textStatus, jqXHR */ ) {
	
		window.location.href = href;
		
	});
	
}

var dataTable = false;
	var dataTableDateienListReloadActive = false;
	var dataTableDateienListReloadRequest = false;

	function dataTableReload(){
		if(dataTableDateienListReloadActive == true)	{
			 dataTableDateienListReloadRequest = true;
		} else {
			dataTableDateienListReloadRequest = false;
			dataTableDateienListReloadActive == true;
			setTimeout(function(){ $('#dateienList').DataTable().ajax.reload(); }, 100);
		}
	}

	

	function dataTableInit(){
		dataTable = $('#dateienList').DataTable({
			
			"rowCallback": function( row, data, index ) {

				$(row).attr('id','dateienListDatei_'+$(row).find("[data-table-callback-id]").data('table-callback-id'));

			},
			
			"lengthMenu": [ [50, 100, -1], [50, 100, "Alle"] ],
			"pageLength": 50,
			"order": [4,'desc'],

			"processing": true,
			"serverSide": true,
			"ajax": dateienAjaxUrl+'&tx_dslintranet_downloadcenter%5Bswitch%5D=dateienList',
		
			"columnDefs": [
				{
					"targets": [ 0 ],
					"orderable": true,
					"width": "350px"
				},
				{
					"targets": [ 1 ],
					"orderable": true,
					"width": "175px"
				},
				
				{
					"targets": [ 2 ],
					"visible": true,
					"orderable": true,
					"width": "340px"
					
				},
				{
					"targets": [ 3 ],
					"orderable": true,
					
				},
				{
					"targets": [ 4 ],
					"width": "130px"
					
				},
				{
					"targets": [ 5 ],
					"orderable": false,
					"width": "100px"
				},
				{
					"targets": [ 6 ],
					"orderable": false,
					"width": "120px"
				}
			],
			"language": {
				"decimal":        "",
				"emptyTable":     "Keine Daten gefunden",
				"info":           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
				"infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
				"infoFiltered":   "(gefiltert von _MAX_ Einträgen)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "_MENU_ &nbsp;&nbsp;pro Seite",
				"loadingRecords": "Lädt...",
				"processing":     '<i class="fa fa-cog fa-spin"></i>',
				"search":         '<a class="btn tableBtnSuche" aria-label="Suche"><i class="fa fa-lg fa-search" aria-hidden="true"></i></a><a class="clearFilter"><i class="fa fa-lg fa-times"></i></a>',
				"searchPlaceholder": "Suche",
				"zeroRecords":    "Keine Ergebnisse gefunden",
				"paginate": {
					"first":      "Erste",
					"last":       "Letzte",
					"next":       "Nächste",
					"previous":   "Vorhergehende"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
			
		});
		dataTable.on('preXhr.dt', function ( e, settings, data ) {
        	dataTableDateienListReloadActive = true;
		});
		
		$('#dateienList_wrapper .clearFilter').on('click', function() {
		  setTimeout(function(){ 
			$('#dateienList_wrapper input[type="search"]').val('');
			dataTable.search( '' ).draw();
			$('#dateienList_wrapper .clearFilter').css('opacity',0);
		  }, 10);
		}); 
		$('#dateienList_wrapper input[type="search"]').keyup(function() {
		  
			if($('#dateienList_wrapper input[type="search"]').val()){
				$('#dateienList_wrapper .clearFilter').css('opacity',1);
			} else {
				$('#dateienList_wrapper .clearFilter').css('opacity',0);
			}
		});
		
		$('#dateienList_wrapper .clearFilter').insertAfter('#dateienList_wrapper input[type="search"]');	
	}
	
	$(document).ready(function() {
	
		dataTableInit();

		$('#dateienList').on( 'draw.dt', function () {

			
			reInitAjaxCalls();
			reInitTitleEdit();
			
			dataTableDateienListReloadActive = false;
			
			if(dataTableDateienListReloadRequest == true) dataTableReload();
			
			
			
		} ).on( 'processing.dt', function ( e, settings, processing ) {
			
			if(processing){
				$('#dateienList').css('opacity',0.6);
				$('#dateienList').css('pointer-events','none');

			} else {
				$('#dateienList').css('opacity',1);			
				$('#dateienList').css('pointer-events','auto');			
			}

		} );
		
		$('.dateienFormFilterSelectpicker').change(function() {
			$(this).parent().addClass('filterHighlighted');
			setFilterNotEmptyClass('.dateienFormFilterSelectpicker' );
			activateSubmitButton();
		});
		setFilterNotEmptyClass('.dateienFormFilterSelectpicker' );
		
		$('#dateienFilterForm').submit(function() {
			
			$('#saveFilter').attr('disabled','disabled');	

			
			$('#dateienListAnzahl').html('<span class="ajaxLoading"><i class="fa fa-cog fa-spin"></i></span>');

			
			$.ajax({
                url: $('#dateienFilterForm').attr('action'),
                type: 'POST',
                data: $('#dateienFilterForm').serialize(),
                success: function(data) {
					
					$('#dateienFilterForm').find('.filterHighlighted').removeClass('filterHighlighted');
					
					 dataJson = JSON.parse(data);
					 

					 $('#dateienListAnzahl').html( '('+dataJson['found']+')' );

					dataTableReload();
					return false;
					



                }
            });
			
		  	return false;
		});
		
		
		
		$("#deleteFilter").click(function() {
		
			$('#filter_typens').selectpicker('deselectAll');
			$('#filter_kundens option').removeAttr('selected');
			$('#filter_kundens').selectpicker('deselectAll');
			

			checkFilterResetButton();

			//return false;
		});
		
		$('#saveFilter').attr('disabled','disabled');
	
		function activateSubmitButton(){
			$('#saveFilter').removeAttr('disabled');	
			checkFilterResetButton();
		}
		checkFilterResetButton();
		
		function checkFilterResetButton(){

		
		if(!$("#filter_kundens").selectpicker('val') &&
			!$("#filter_typens").selectpicker('val')){
			
				$("#deleteFilter").hide();		
				
		} else 	$("#deleteFilter").show();
	}
		
	});

	function reInitTitleEdit(){


		$(".editableBtnDoubleClick").unbind( "dblclick" );
		$( ".editableBtnDoubleClick" ).dblclick(function() {
		  $(this).next().click();
		});

		$(".editableEditInput").unbind( "keypress" );
		$( ".editableEditInput" ).keypress(function( event ) {
		  if ( event.which == 13 ) {
			$(this).parent().find('.editableSave').click();

		  }
		});

		
		$(".editableBtn,.editableAbort,.editableSave").unbind( "click" );
		$('.editableBtn').click(function(){
			$(this).closest('.editableWrapper').toggleClass('editableActive');
			$(this).closest('.editableWrapper').find('.editableEditInput').focus();
			return false;
		});
		$('.editableAbort').click(function(){
			$(this).closest('.editableWrapper').toggleClass('editableActive');
			
			$(this).closest('.editableWrapper').find('.editableEditInput').val($(this).closest('.editableWrapper').find('.editableText .editableTextContent').html());

			return false;
		});
		
		
		$('.editableSave').click(function(){
			
			$(this).closest('.editableWrapper').toggleClass('editableActive');
			
			$(this).closest('.editableWrapper').find('.editableText .editableTextContent').html($(this).closest('.editableWrapper').find('.editableEditInput').val());
			
			if($(this).closest('.editableWrapper').find('.editableText .editableTextContent').html()){
				
				$(this).closest('.editableWrapper').find('.editableText').removeClass('editableTextEmpty');
			} else {
				$(this).closest('.editableWrapper').find('.editableText').addClass('editableTextEmpty');
			}
		
			setDateiTitel('selector',$(this).closest('.editableWrapper').data('uid'),$(this).closest('.editableWrapper').find('.editableEditInput').val());

			return false;
		});
	}