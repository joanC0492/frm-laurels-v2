import { Splide } from '@splidejs/splide';
import "@splidejs/splide/css";
import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';

import GLightbox from 'glightbox';
import GLightboxCSS from 'glightbox/dist/css/glightbox.min.css';

(function(){

    // jQuery.datetimepicker.setLocale('en');

    if(document.querySelector('#apartments')){
        new Splide('#apartments', {
            type: 'loop',
            rewind: true,
            autoWidth: true,
            arrows: false,
            drag: false,
            gap: '1.667vw',
            pagination: false,
            autoScroll: {
                pauseOnFocus: false,
                pauseOnHover: false,
                speed: 0.5
            },
            breakpoints: {
                1300: {
                    autoScroll: {
                        speed: 0.5
                    }
                },
                1200: {
                    gap: '18px',
                    autoScroll: {
                        speed: 0.5
                    }
                },
                576: {
                    speed: 750,
                },
                500: {
                    autoScroll: {
                        speed: 0.4
                    },
                    drag: true,
                    perMove: 1,
                }
            }
        }).mount({ AutoScroll });
    }

    if(document.querySelector('#teammates')){
        new Splide('#teammates', {
            type: 'loop',
            rewind: true,
            autoWidth: true,
            arrows: true,
            gap: '1.667vw',
            pagination: false,
            autoScroll: {
                pauseOnFocus: false,
                pauseOnHover: false,
                speed: 0.55
            },
            breakpoints: {
                1200: {
                    gap: '18px'
                },
                576: {
                    gap: '1.5rem',
                    autoWidth: true,
                    padding: {
                        left: '3%',
                        right: '3%',
                    },
                    speed: 800,
                }
            }
        }).mount({ AutoScroll });
    }

    if(document.querySelector('#clients')){
        new Splide('#clients', {
            type: 'loop',
            rewind: true,
            autoWidth: true,
            arrows: false,
            gap: '1.667vw',
            pagination: false,
            breakpoints: {
                1200: {
                    gap: '18px'
                },
                576: {
                    autoWidth: false,
                    perPage: 1,
                    perMove: 1,
                    padding: {
                        left: '4%',
                        right: '4%',
                    },
                    speed: 750
                }
            }
        }).mount();
    }

    if(document.querySelector('#property_photos')){
        new Splide('#property_photos', {
            type: 'loop',
            arrows: true,
            pagination: false,
            perPage: 1,
            perMove: 1
        }).mount();
    }

    if(document.querySelector('.glightbox3-toggle')){
        let lightboxImages = GLightbox({
            touchNavigation: true,
            loop: true,
            selector: '.glightbox3'
        });
        let lightboxImagesButton = document.querySelector('.glightbox3-toggle');
        if(lightboxImagesButton){
            lightboxImagesButton.addEventListener('click', (e)=>{
                e.preventDefault();
                lightboxImages.open();
            })
        }
    }

    // ---------------------------------------

    let popup_toggle = document.querySelectorAll('.popup_toggle');
    if(popup_toggle){
        Array.from(popup_toggle).forEach(pt=>{
            pt.addEventListener('click', (e)=>{
                e.preventDefault();
                let id = e.currentTarget.getAttribute('data-id');
                console.log(id)

                if(id){
                    let popup = document.querySelector(`[data-popup="${id}"]`);
                    popup.classList.toggle('active');
                }
            })
        })
    }

    let heroSection = document.querySelector('section.hero');
    if(heroSection){
        document.addEventListener('scroll', function () {
            const scrollPosition = window.scrollY;
            const triggerHeight = window.innerHeight * 1.5;
        
            if (scrollPosition > triggerHeight) {
                heroSection.classList.add('nonopacity');
            } else {
                heroSection.classList.remove('nonopacity');
            }
        });
    }
    

})();