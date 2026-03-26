(function(){

    let header = document.querySelector('.header');
    if (header && !document.querySelector('.no_scroll')) {
    
        function toggleHeaderClass() {
            if (window.scrollY > window.innerHeight) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    
        window.addEventListener('scroll', toggleHeaderClass);
    }

})();