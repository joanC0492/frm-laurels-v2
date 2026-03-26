(function(){

    let featuresImages = document.querySelectorAll('.feature_images');

    if(featuresImages){
        Array.from(featuresImages).forEach(container=>{
            const divs = Array.from(container.querySelectorAll('div')); // Lista de <div>
        
            divs.forEach((image, index) => {
                image.addEventListener('mouseover', (e) => {
                    container.setAttribute("data-hover", index + 1)
                });
                
                image.addEventListener('mouseout', (e) => {
                    container.removeAttribute("data-hover")
                });
            });
        })
    }

})();