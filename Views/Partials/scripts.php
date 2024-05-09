<script src="/js/bootstrap.js"></script>
<script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', event => {
            console.log(1)
            if(event.target.classList.contains('dropdown-toggle') ){
                event.target.classList.toggle('toggle-change');
            }
            else if(event.target.parentElement.classList.contains('dropdown-toggle')){
                event.target.parentElement.classList.toggle('toggle-change');
            }
        })
    });
</script>
