$(document).ready(function() {
    center_venue();
    
        if(exists($('#map_canvas'))){
        initialize_google_maps();
        var e = $("#map_canvas");
        latm = e.attr('data-lat');
        lngm = e.attr('data-lng');
        
        setMap({noAutocomplete: true, lat: latm, lng: lngm});
    }

});


function center_venue(){
    var el = $('#lugar .venue_place');
    var w = el.width()/2;
    var css = {"margin-left" :'-'+w+'px'};
    el.css(css);
}


initialize_google_maps = function () {    
        var t = new google.maps.places.Autocomplete(document.getElementById("lugar"));
        google.maps.event.addListener(t, "place_changed", setMap)
    }, setMap = function (t) {
        var t = t || {}, e = e || document.getElementById("map_canvas"),
            i = i || document.getElementById("lugar"),
            n = t.noAutocomplete ? null : this,
            r = t.lat,
            s = t.lng,
            o = t.noAutocomplete ? !1 : n.getPlace();
        o && (r = o.geometry.location.lat(), s = o.geometry.location.lng(), attachPlaceToForm(o, r, s));
        var a = new google.maps.LatLng(r, s),
            l = {
                zoom: 18,
                center: a,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }, h = new google.maps.Map(e, l);
        optionsMarker = {
            map: h,
            position: a
        }, marker = new google.maps.Marker(optionsMarker), $(e).show()
    }, attachPlaceToForm = function (t, e, i) {
        var t = t || !1;
        if (t) {
            for (var n, r = t.name, s = t.address_components, o = o || document.getElementById("event_address_components"), a = {
                    place: r,
                    lat: e,
                    lng: i
                }, l = 0; n = s[l]; l++) {
                var h = defKeyName(n.types[0]);
                a[h] = n.short_name
            }
            o.value = JSON.stringify(a)
        }
    }, defKeyName = function (t) {
        switch (t) {
        case "route":
            return "street_name";
        case "administrative_area_level_1":
            return "region";
        default:
            return t
        }
    }