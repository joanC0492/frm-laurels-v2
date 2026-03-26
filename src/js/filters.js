(function(){

    let filterButtons = document.querySelectorAll('.filter-button'),
        containerProperties = document.querySelector('.for_sale-list');

    if(filterButtons){
        Array.from(filterButtons).forEach(filterButton => {
            filterButton.addEventListener('click', (e)=>{
                e.preventDefault();
                
                let classes = e.currentTarget.classList,
                option = e.currentTarget.getAttribute('data-option');
                
                if(classes.contains('active')){
                    e.currentTarget.classList.remove('active');

                    if(classes.contains('prop')){
                        containerProperties.removeAttribute('data-property-type');
                    }
                    if(classes.contains('bedr')){
                        containerProperties.removeAttribute('data-bedrooms');
                    }

                    return
                }

                if(classes.contains('prop')){
                    Array.from(document.querySelectorAll('.filter-button.prop')).forEach(p=>{
                        if(p.classList.contains('active')){p.classList.remove('active');}
                    })
                    containerProperties.setAttribute('data-property-type', option);
                    e.currentTarget.classList.add('active');
                }
                if(classes.contains('bedr')){
                    Array.from(document.querySelectorAll('.filter-button.bedr')).forEach(b=>{
                        if(b.classList.contains('active')){b.classList.remove('active');}
                    })
                    containerProperties.setAttribute('data-bedrooms', option);
                    e.currentTarget.classList.add('active');
                }
            })
        })
    }

    let searchField = document.querySelector('.search-field');
    const resultsList = document.querySelector('ul.results');
    const base_url = document.querySelector('[name="base_url"]');

    if (searchField && resultsList) {
        searchField.addEventListener('input', (e) => {
            
            const id = e.currentTarget.value.toLowerCase(),
                url = 'https://api.uk.rexsoftware.com/v1/rex/listings/search',
                headers = {'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json'},
                body = {'offset': 0, 'limit': 100};

            if (!id.trim()) {
                resultsList.innerHTML = '';
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(body),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.result.rows) {
                        const filteredRows = data.result.rows
                            .filter(row => {
                                const searchKey = row.property && row.property.system_search_key 
                                    ? row.property.system_search_key.toLowerCase() 
                                    : '';
                                return searchKey.includes(id);
                            })
                            .map(row => ({
                                system_search_key: row.property && row.property.system_search_key 
                                    ? row.property.system_search_key 
                                    : '',
                                id: row.property && row.property.id 
                                    ? row.property.id 
                                    : ''
                            }));

                        // Limpia la lista de resultados antes de agregar los nuevos
                        resultsList.innerHTML = '';

                        // Itera sobre los resultados filtrados y crea los elementos <li>
                        filteredRows.forEach(row => {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `<a href="${base_url.value}/single-property/?id=${row.id}">${row.system_search_key}</a>`;
                            resultsList.appendChild(listItem);
                        });

                        // console.log('Resultados filtrados:', filteredRows);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                });
        });

        // Escucha el evento `blur` para agregar la clase `desactived`
        searchField.addEventListener('blur', () => {
            if(!resultsList.classList.contains('desactived') && searchField.value == ''){
                resultsList.classList.add('desactived');
            }
        });
    
        // Escucha el evento `focus` para quitar la clase `desactived`
        searchField.addEventListener('focus', () => {
            if(resultsList.classList.contains('desactived')){
                resultsList.classList.remove('desactived');
            }
        });


    }

})();