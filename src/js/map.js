(function(){

    let map_data = document.querySelector('#map_data');
    let urlTheme = document.querySelector('[name="urlTheme"]');

    if(map_data){

        var lat = map_data.getAttribute('data-lat');
        var lng = map_data.getAttribute('data-lng');
    
        var map = L.map('map_canvas', {
        center: [lat, lng],
            zoom: 15,
            scrollWheelZoom: true,
            dragging: true,
            doubleClickZoom: true,
            zoomControl: true
        });
    
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: ''
        }).addTo(map);
    
        var customIcon = L.icon({
            iconUrl: `${urlTheme.value}/images/pin.svg`, // Coloca aquí la ruta de tu imagen
            iconSize: [20, 30], // Tamaño del icono
            iconAnchor: [22, 38], // Punto donde el icono se "ancla" al marcador
        });
    
        // Añadir el marcador con el icono personalizado
        L.marker([lat, lng], { icon: customIcon }).addTo(map);
    
    }


})();