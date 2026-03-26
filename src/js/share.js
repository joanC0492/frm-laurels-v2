(function(){

    let shares = document.querySelectorAll('.share');
    const copyContent = document.querySelector('.value_url');

    if(shares){
        Array.from(shares).forEach(share=>{

            share.querySelector('.share_button').addEventListener('click', (e)=>{
                e.preventDefault();
                share.classList.toggle('active');
            });
            
            share.querySelector('.copy_url').addEventListener('click', (e)=>{
                e.preventDefault();
                
                navigator.clipboard.writeText(copyContent.value);
    
                if(share.classList.contains('active')){
                    share.classList.remove('active');
                }
            })
            
        })
    }

})();