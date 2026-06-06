/**
 * @company : e-magineurs
 * @website : www.e-magineurs.com
 * @author  : Ian SEBBAGH
 * @contact : isebbagh@e-magineurs.com
 * @copyright : Tous droits réservés
 **/

jQuery(document).ready(function () {
  initECPublish();
  initSelectAllPdf();
  initDeletePdfButtons();
  initSelectOnClick();
});

/**
 * Select or deselect all PDFs
 * @param {boolean} checked
 */
function selectAllPdf(checked) {
  var pdf_box = document.getElementsByName("pdfs2import[]");
  for (var i = 0; i < pdf_box.length; i++) {
    if (!pdf_box[i].disabled) pdf_box[i].checked = checked;
  }
  return true;
}

/**
 * Initialize the publish button click event
 */
function initECPublish() {
  jQuery("#submitECPublish").click(function (event) {
    event.preventDefault();
    publishCheckedPdf();
  });
}

/**
 * Publish all checked PDFs via AJAX
 */
function publishCheckedPdf() {
  jQuery('input[type="checkbox"].pdfs2import').each(function () {
    var checkbox = jQuery(this);
    if (!checkbox.is(":checked")) return;

    var fullPath = checkbox.val();
    
    var filename = fullPath.split("fileadmin/").pop();

    if (/[\uFFFD\x00-\x1F\x7F]/.test(filename)) {
      console.error("Fichier avec caractères invalides ignoré :", filename);
      markStatus(checkbox, "error", "Nom de fichier invalide");
      return;
    }

    var ajaxUrl = TYPO3.settings.ajaxUrls["calemeopublish"];

    checkbox.prop("disabled", true);
    var statusImg = checkbox.closest("tr").find(".status img");
    
    // Get spinner path - use window.ecalameoIconPath or extract from current image
    var spinnerPath = window.ecalameoIconPath || "";
    if (!spinnerPath) {
      var currentSrc = statusImg.attr("src");
      if (currentSrc && currentSrc.includes("/") && !currentSrc.includes("spinner") && !currentSrc.includes("/typo3/sysext/core/")) {
        spinnerPath = currentSrc.substring(0, currentSrc.lastIndexOf("/") + 1);
      }
    }
    
    var spinnerIcon = spinnerPath ? (spinnerPath + "spinner-circle.svg") : "spinner-circle.svg";
    statusImg.attr("src", spinnerIcon).attr("width", "48").attr("height", "48");

    var formData = new FormData();
    formData.append("file", filename);

    fetch(ajaxUrl, {
      method: "POST",
      body: formData,
    })
      .then(function (response) {
        return response.json().then(function(data) {
          if (response.ok && data.success === true) {
            return data;
          }
          if (data && data.success === true) {
            return data;
          }
          throw new Error(data.error || "HTTP error " + response.status);
        }).catch(function(jsonError) {
          if (response.ok) {
            throw new Error("Invalid JSON response");
          }
          throw new Error("HTTP error " + response.status);
        });
      })
      .then(function (data) {
        if (data && data.success === true) {
          markStatus(checkbox, "success", "Publié avec succès");
          checkbox.prop("disabled", true);
        } else {
          markStatus(checkbox, "error", data.error || "Échec de la publication");
        }
      })
      .catch(function (error) {
        console.error("Erreur publication:", error);
        markStatus(checkbox, "error", error.message || "Erreur lors de la publication");
      });
  });
}

function markStatus(checkbox, type, title) {
  checkbox.prop("disabled", true);
  var statusImg = checkbox.closest("tr").find(".status img");
  
  // Get icon path - first try to extract from existing status images (they have full paths)
  var iconPath = null;
  var existingImg = jQuery('.status img').not('[src*="spinner"]').not('[src*="/typo3/sysext/core/"]').first();
  if (existingImg.length) {
    var src = existingImg.attr("src");
    if (src && src.includes("/")) {
      iconPath = src.substring(0, src.lastIndexOf("/") + 1);
    }
  }
  
  // Fallback to window variable
  if (!iconPath) {
    iconPath = window.ecalameoIconPath || "";
  }
  
  // Last resort: extract from current img if it has a valid path
  if (!iconPath) {
    var currentSrc = statusImg.attr("src");
    if (currentSrc && currentSrc.includes("/") && !currentSrc.includes("spinner") && !currentSrc.includes("/typo3/sysext/core/")) {
      iconPath = currentSrc.substring(0, currentSrc.lastIndexOf("/") + 1);
    }
  }
  
  // Build full icon path
  var iconName = type === "success" ? "actions-check.svg" : "actions-edit-upload.svg";
  var icon = iconPath ? (iconPath + iconName) : iconName;

  statusImg.attr("src", icon).attr("title", title).attr("width", "48").attr("height", "48");
}

/**
 * Delete a PDF record via AJAX
 * @param {HTMLElement} element - The clicked delete button
 * @param {string|number} idPDF - PDF ID to delete
 */
window.deletePdf = function(element, idPDF) {
  if (!confirm("Attention, ceci supprimera l'enregistrement. Voulez-vous continuer?")) {
    return false;
  }

  var ajaxUrl = (TYPO3 && TYPO3.settings && TYPO3.settings.ajaxUrls && TYPO3.settings.ajaxUrls["calemeodelete"]) 
    ? TYPO3.settings.ajaxUrls["calemeodelete"]
    : window.location.origin + '/typo3/ajax/calemeodelete';

  var $element = jQuery(element);
  var $row = $element.closest("tr");
  $element.prop("disabled", true).css("opacity", "0.5");

  var formData = new FormData();
  formData.append("idPDF", idPDF);

  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
    credentials: 'same-origin'
  })
    .then(function (response) {
      if (!response.ok) {
        return response.json().then(function(data) {
          throw new Error(data.error || "HTTP error " + response.status);
        });
      }
      return response.json();
    })
    .then(function (data) {
      if (data && data.success) {
        $row.fadeOut(300, function () {
          jQuery(this).remove();
        });
      } else {
        throw new Error(data.error || data.message || "Échec de la suppression");
      }
    })
    .catch(function (e) {
      alert("Erreur lors de la suppression du PDF: " + e.message);
      $element.prop("disabled", false).css("opacity", "1");
    });
};

/**
 * Initialize select all PDF checkbox
 */
function initSelectAllPdf() {
  jQuery("#selectAllPdf").on("change", function () {
    selectAllPdf(this.checked);
  });
}

function initDeletePdfButtons() {
  jQuery(document).on("click", ".delete-pdf-btn", function (e) {
    e.preventDefault();
    var pdfId = jQuery(this).data("pdf-id");
    if (pdfId) {
      deletePdf(this, pdfId);
    }
    return false;
  });
}

/**
 * Initialize select-on-click textareas
 */
function initSelectOnClick() {
  jQuery(document).on("click", ".select-on-click", function () {
    this.select();
  });
}
