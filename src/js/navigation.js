(function(){

    let navPosts = document.querySelector('#nav_posts'),
        uri = document.querySelector('[name="uri"]');

    if(navPosts){
        navPosts.addEventListener('change', (e)=>{
            e.preventDefault();
            let current = navPosts.value;

            setTimeout(() => {
                window.location.href = `${uri.value}?show=${current}`;
            }, 500);
        })
    }

})();