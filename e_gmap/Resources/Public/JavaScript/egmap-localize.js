document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('EGmapValidateButton');
    if (button) {
        button.addEventListener('click', EGmapValidate);
    }

    const tableSelect = document.getElementById('table');
    if (tableSelect) {
        tableSelect.addEventListener('change', EGmapValidate);
    }
});

function EGmapValidate() {
    document.getElementById("EGmapForm").submit();
}

var eGmapGeocoder;
var eGmapId = '';
var eGmapPageId = '';
var eGmapUrlUpdate = '';

function EGmapInit() {
    eGmapGeocoder = new google.maps.Geocoder();
}

function EGmapLocalize() {
    var todo = TYPO3.jQuery('.egmap_localize.db_list_normal.egmap_todo');
    if (todo.length) {
        eGmapId = todo.eq(0).attr('id');
        var coord = TYPO3.jQuery('#coord_' + eGmapId).html();
        
        eGmapGeocoder.geocode({ 'address': coord }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var bounds = results[0].geometry.bounds;
                if (!bounds) {
                    bounds = new google.maps.LatLngBounds(
                        results[0].geometry.viewport.getSouthWest(), 
                        results[0].geometry.viewport.getNorthEast()
                    );
                }
                var center = bounds.getCenter();
                var lat = center.lat();
                var lng = center.lng();
                TYPO3.jQuery('#lat_' + eGmapId).html(lat);
                TYPO3.jQuery('#lng_' + eGmapId).html(lng);
                TYPO3.jQuery('#status_' + eGmapId).html(
                    TYPO3.jQuery('#egmap_bouton_ok').html()
                );
                TYPO3.jQuery('#' + eGmapId).removeClass('egmap_todo').addClass('egmap_ok');
                EGmapUpdateBdd(eGmapId, lat, lng);
            } else {
                TYPO3.jQuery('#lat_' + eGmapId).html('Geocode was not successful for the following reason: ');
                TYPO3.jQuery('#lng_' + eGmapId).html(status);
                TYPO3.jQuery('#status_' + eGmapId).html(
                    TYPO3.jQuery('#egmap_bouton_error').html()
                );
            }
        });
    }
}

function EGmapUpdateBdd(id, lat, lng) {
    var data = {
        pageid: eGmapPageId,
        id: id.replace('localize_', ''),
        lat: lat,
        lng: lng
    };

    TYPO3.jQuery.ajax({
        url: eGmapUrlUpdate,
        data: data,
        type: 'POST',
        success: function(result) {
            // Handle success
        },
        error: function(error) {
            console.error('Error updating coordinates:', error);
        }
    });
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener for table select
    var tableSelect = document.querySelector('.egmap-table-select');
    console.log(tableSelect);
    if (tableSelect) {
        tableSelect.addEventListener('change', function() {
            EGmapValidate();
        });
    }

    // Set dynamic variables from data attributes if needed
    var scriptElement = document.currentScript || document.querySelector('script[src*="egmap-localize.js"]');
    if (scriptElement) {
        eGmapPageId = scriptElement.getAttribute('data-pageid') || '';
        eGmapUrlUpdate = scriptElement.getAttribute('data-update-url') || '';
    }
    
    // Initialize Google Maps
    if (typeof google !== 'undefined' && google.maps) {
        google.maps.event.addDomListener(window, 'load', EGmapInit);
    }
});
