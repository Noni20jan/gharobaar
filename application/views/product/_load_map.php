<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFvh43Z_rwc8tuVkvhBk59tBHiJ2YnKnM&callback=initAutocomplete&libraries=places&v=weekly" defer></script> -->


<div class="map-container">
    <!-- <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $map_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" id="IframeMap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe> -->

    <div id="map" style="width: auto; height:400px"></div>
</div>
<script>
    // $(document).ready(function() {
    //     $("#IframeMap").attr("src", "https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $map_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true");
    // });
</script>


<script>
    function initAutocomplete() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 28.612912,
                lng: 77.2295097
            },
            zoom: 13,
            mapTypeId: "roadmap",
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const latlng = {
                    lat: parseFloat(place.geometry.location.lat()),
                    lng: parseFloat(place.geometry.location.lng()),
                };
                const marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                });

                markers.push(
                    new google.maps.Marker({
                        map,
                        marker,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );
                console.log('{latitude:' + place.geometry.location.lat() + ',longitude:' + place.geometry.location.lng() + '}');
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }
</script>