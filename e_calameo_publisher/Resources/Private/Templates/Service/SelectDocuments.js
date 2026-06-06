function addValue(newValue) {
	champHidden = document.getElementsByName("{itemFormElName}");
	champHidden = champHidden[0];
	hiddenValue = champHidden.value;
	if(hiddenValue != "") {
		champHidden.value += ",";
	}
	
	champHidden.value += newValue;
}

function removeValue(oldValue) {
	champHidden = document.getElementsByName("{itemFormElName}");
	champHidden = champHidden[0];
	hiddenValue = champHidden.value;
	hiddenValueArray = hiddenValue.split(",");
	newHiddenValue = "";
	var j =0;
	for(var i = 0; i < hiddenValueArray.length ; i++) {
		if(hiddenValueArray[i] != oldValue) {
			if(j > 0 ) {
				newHiddenValue += ",";
			}
			
			newHiddenValue += hiddenValueArray[i];
			j++;
		}
	}
	
	champHidden.value = newHiddenValue;
}

function changeValue(newValue, checked) {
	if(checked) {
		addValue(newValue);
	} else {
		removeValue(newValue);
	}
}
			
			
function selectAllPdf(checked){
	champHidden = document.getElementsByName("{itemFormElName}");
	champHidden = champHidden[0];
	newHiddenValue = "";
	
	var pdf_box = document.getElementsByName("pdfs2display[]");
	
	for (i = 0; i < pdf_box.length; i++) {
		pdf_box[i].checked = checked;
		if(checked) {
			if(i>0) {
				newHiddenValue += ",";
			}
			
			newHiddenValue += pdf_box[i].value;
		}
	}
	
	champHidden.value = newHiddenValue;
	return true;
}