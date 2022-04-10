const deleteButtons = document.querySelectorAll('.delete-product');
deleteButtons.forEach((button) => {
    button.addEventListener('click', (e) => {
        const productId = e.target.dataset['id']
        if(confirm('Voulez-vous vraiment supprimer le produit?')){
            fetch('/P5/api/products/' + productId, {
                method: 'DELETE',
            }).then(response => response.json())
            .then((res) => {
                if(res.status == 'OK'){
                    document.querySelector('tr[data-id="' + productId + '"]').remove()
                }
            })
        }
    })
})
