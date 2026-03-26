(function(){

    // <span class="dynamic" akhi="500" speed="2000" interval="50" type="int">0</span>

    const counters = document.querySelectorAll('span.dynamic');

    counters.forEach(counter => {
        const targetValue = parseFloat(counter.getAttribute('akhi')); // Valor objetivo
        const speed = parseInt(counter.getAttribute('speed')); // Duración total en ms
        const interval = parseFloat(counter.getAttribute('interval')); // Incremento en cada paso
        const type = counter.getAttribute('type'); // Tipo de número (int o float)
    
        const steps = Math.ceil(targetValue / interval); // Número total de pasos
        const stepDuration = speed / steps; // Tiempo entre cada paso
    
        const animate = () => {
            let currentValue = type === 'int' ? parseInt(counter.innerText) : parseFloat(counter.innerText);
    
            if (currentValue < targetValue) {
                currentValue = Math.min(currentValue + interval, targetValue); // Evitar pasar el valor objetivo
                counter.innerText = type === 'int' ? Math.floor(currentValue) : currentValue.toFixed(1); // Formatear según tipo
                setTimeout(animate, stepDuration); // Repetir después de stepDuration
            } else {
                counter.innerText = type === 'int' ? Math.floor(targetValue) : targetValue.toFixed(1); // Asegurar el valor final
            }
        };
    
        animate(); // Iniciar la animación
    });


})();