(function(){

    let hover_video = document.querySelectorAll('.hover_video');

    if(hover_video){
        Array.from(hover_video).forEach(hover=>{
            hover.addEventListener('mouseover', function(){
                setTimeout(() => {
                    hover.querySelector('video').play();
                }, 500);
            });
            
            hover.addEventListener('mouseout', function(){
                setTimeout(() => {
                    hover.querySelector('video').pause();
                }, 500);
            });
        })
    }

})();