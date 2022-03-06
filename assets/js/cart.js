const formAddToCart = document.querySelector('#addToCart');
let cart = JSON.parse(localStorage.getItem('cart') || '{}')

if(formAddToCart){
    formAddToCart.addEventListener('submit', (e) =>{
        e.preventDefault() // Evite que le formulaire soit envoyé
        const quantity = parseInt(e.target.quantity.value)
        const id = e.target.id.value
        const name = e.target.name.value
        const price = parseInt(e.target.price.value)
        const product = {
            id, name, price, quantity
        }
       
        // Si le produit est déjà dans le panier, on incrémente la quantité
        if(cart.hasOwnProperty(id)){
            cart[id].quantity += quantity
        } else {
            // Si le produit n'existe pas, on l'ajoute au panier
            cart = {...cart, [id]: product}
        }


        localStorage.setItem('cart', JSON.stringify(cart))
    })
}

const cartDOM = document.querySelector('#cart');

if(cartDOM){
    const products = Object.values(cart)

    if(products.length === 0){
        cartDOM.innerHTML = 'Panier vide'
    } else {
        products.forEach((product) => {
            const tr = document.createElement('tr');
            const tdName = document.createElement('td')
            tdName.textContent = product.name
            const tdQuantity = document.createElement('td')
            tdQuantity.textContent = product.quantity
            const tdPrice = document.createElement('td')
            tdPrice.textContent = `${product.quantity * product.price}€`
            tr.appendChild(tdName)
            tr.appendChild(tdQuantity)
            tr.appendChild(tdPrice)
    
            cartDOM.querySelector('tbody').appendChild(tr)
        })
    }

    // TODO : Afficher le prix total + suppression d'un produit + formulaire d'envoi de commande

   


}