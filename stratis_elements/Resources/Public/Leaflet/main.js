function initMap(lafletMapId, img, latlng = '408.1875,721') {
    console.log('initMap called with:', lafletMapId, 'Leaflet available:', typeof L !== 'undefined');
    const mapElement = document.getElementById(lafletMapId);
    if (!mapElement) {
        console.error('Map element not found:', lafletMapId);
        return;
    }
    
    mapElement.style.height = "400px";

    const calculateMinZoom = ((imgWidth, imgHeight) => {
        const {offsetWidth, offsetHeight} = mapElement;
        const xRatio = offsetWidth / imgWidth;
        const yRatio = offsetHeight / imgHeight;
        return Math.max(xRatio, yRatio);
    });

    let attempts = 0;
    const maxAttempts = 50;

    const mapInterval = setInterval(function () {
        attempts++;
        
        if (typeof L !== "undefined") {
            console.log('Leaflet loaded, creating map for:', lafletMapId);
            clearInterval(mapInterval);

            const {naturalWidth, naturalHeight} = img;
            const bounds = [[0, 0], [naturalHeight, naturalWidth]];
            const minZoom = Math.log2(calculateMinZoom(naturalWidth, naturalHeight));

            let map = L.map(lafletMapId, {
                crs: L.CRS.Simple,
                zoomControl: false,
                minZoom,
                maxZoom: minZoom + 5,
                detectRetina: true,
                maxBounds: bounds,
            });

            L.imageOverlay(img.src, bounds).addTo(map);
            map.fitBounds(bounds);

            let marker;

            const input = document.getElementById('input_' + lafletMapId);

            if (latlng && latlng.length) {
                latlng = latlng.split(',');
                if (latlng.length === 2) {
                    const lat = parseFloat(latlng[0]);
                    const lng = parseFloat(latlng[1]);
                    marker = L.marker([lat, lng]).addTo(map);
                    
                    // Set the initial value in the input field
                    if (input) {
                        input.value = lat + ',' + lng;
                    }
                }
            }

            map.on('click', function (e) {
                const {lat, lng} = e.latlng;

                input.value = lat + ',' + lng

                if (!marker) {
                    marker = L.marker([lat, lng]).addTo(map);
                } else {
                    marker.setLatLng([lat, lng]);
                }
            });
        } else if (attempts >= maxAttempts) {
            clearInterval(mapInterval);
            console.error('Leaflet library failed to load after 10 seconds');
        }
    }, 200);
}

function getMainImageUrl(fileId, callback) {
    const url = '/index.php?eID=dumpFileUrl&f=' + fileId;
    let xhr = new XMLHttpRequest();

    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            callback(xhr.responseText);
        } else {
            console.error('Failed to load image URL for file UID:', fileId, 'Status:', xhr.status, 'Response:', xhr.responseText);
            callback(null);
        }
    };
    xhr.onerror = function() {
        console.error('XHR error loading image for file UID:', fileId);
        callback(null);
    };
    xhr.send();
}

function initLafletElement(lafletMapId, lafletMainImageElement, latlng) {
    let imageField = document.getElementsByName(lafletMainImageElement)[0];
    if (!imageField) {
        console.error('Image field not found:', lafletMainImageElement);
        return;
    }
    
    let imageId = parseInt(imageField.value);
    if (!imageId || isNaN(imageId)) {
        console.error('Invalid image ID:', imageField.value);
        return;
    }

    getMainImageUrl(imageId, function(imageUrl) {
        if (!imageUrl) {
            console.error('No image URL returned for file UID:', imageId);
            return;
        }
        
        var img = new Image();
        img.src = imageUrl;
        img.onload = function () {
            setTimeout(function () {
                initMap(lafletMapId, img, latlng);
            }, 200);
        };
        img.onerror = function() {
            console.error('Failed to load image from URL:', imageUrl);
        };
    });
}

window.initLafletElement = initLafletElement;

function addLafletElement(lafletMapId, lafletMainImageElement, latlng = '408.1875,721') {
    const initInterval = setInterval(function () {
        if (typeof window.initLafletElement !== "undefined") {
            clearInterval(initInterval);
            window.initLafletElement(lafletMapId, lafletMainImageElement, latlng);
        }
    }, 200);
}

function initializeAllMaps() {
    const mapContainers = document.querySelectorAll('.leaflet-map-container[data-map-id]');
    
    mapContainers.forEach(container => {
        const mapId = container.getAttribute('data-map-id');
        const imageUrl = container.getAttribute('data-image-url');
        const coords = container.getAttribute('data-coords') || '408.1875,721';
        
        if (container.classList.contains('leaflet-initialized')) {
            return;
        }
        
        container.classList.add('leaflet-initialized');
        
        if (imageUrl && imageUrl.length > 0) {
            console.log('Loading map image:', imageUrl, 'for map:', mapId);
            var img = new Image();
            img.src = imageUrl;
            img.onload = function () {
                console.log('Image loaded successfully, initializing map in 200ms');
                setTimeout(function () {
                    initMap(mapId, img, coords);
                }, 200);
            };
            img.onerror = function() {
                console.error('Failed to load map image:', imageUrl);
            };
        } else {
            console.error('No image URL found for map:', mapId);
        }
    });
}

window.addEventListener('load', function () {
    setTimeout(function (){
        const sectionHeaders = document.querySelectorAll('.t3js-flex-section-header');
        sectionHeaders.forEach(header => {
            header.click();
        });
        
        setTimeout(initializeAllMaps, 500);
    }, 1000);
});

window.addEventListener('DOMContentLoaded', function() {
    if (typeof MutationObserver !== 'undefined' && document.body) {
        const observer = new MutationObserver(function(mutations) {
            initializeAllMaps();
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
});
