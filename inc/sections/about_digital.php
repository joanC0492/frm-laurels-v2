<section class="about_digital with_sticky">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/about.mp4">
    </video>
    <div class="container about_digital-box">
        <div class="overflow about_digital-title">
            <h2>At Laurels, we blend <b>digital marketing</b> with <b>personal service,</b> providing a <b>dedicated consultant</b> to handle everything from <b>viewings</b> to <b>floorplans.</b></h2>
        </div>
        <div class="about_digital-description">
            <div class="overflow">
                <h3>Our <b>award-winning team,</b> rated in the <b>top 5% by EA Masters,</b> operates on a <b>no-sale, no-fee basis,</b> ensuring <b>exceptional results.</b></h3>
            </div>
            <a href="<?php echo esc_url(home_url('about')); ?>" class="wow animate__animated animate__fadeInUp animate__delay-1s" title="More About Us">More About Us</a>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const aboutSection = document.querySelector(".about_digital");
        const aboutBox = document.querySelector(".about_digital-box");

        if (aboutSection && aboutBox) {
            const observer = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                aboutBox.classList.add("active");
                            }, 1000); // Delay de 1 segundo.
                            observer.unobserve(entry.target); // Detiene la observación después de activar.
                        }
                    });
                }, {
                    threshold: 0.3 // Activa cuando el 30% de la sección es visible.
                }
            );

            observer.observe(aboutSection);
        }
    });
</script>