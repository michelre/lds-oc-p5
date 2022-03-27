let cart = JSON.parse(localStorage.getItem('cart') || '{}')

function cartTotalCalculate(){
    let total = 0;
    Object.values(cart).forEach(p => {
        total += p.price * p.quantity
    })
    return total;
}

const formAddToCart = document.querySelector('#addToCart');


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
        const trTotal = document.createElement('tr');
        const tdTotalLabel = document.createElement('td');
        const tdTotal = document.createElement('td');
        tdTotalLabel.textContent = 'Total';
        tdTotalLabel.colSpan = '2'
        tdTotalLabel.style.textAlign = 'left';
        tdTotal.textContent = cartTotalCalculate() + '€'
        trTotal.appendChild(tdTotalLabel)
        trTotal.appendChild(tdTotal)
        cartDOM.querySelector('tbody').appendChild(trTotal)
    }   


}


const cartFormDOM = document.querySelector('#cart-form');

if(cartFormDOM){

    cartFormDOM.addEventListener('submit', (e) => {
        e.preventDefault()
        fetch('/P5/api/order', {
            method: 'POST',
            body: JSON.stringify({
                firstname: e.target.firstname.value,
                lastname: e.target.lastname.value,
                products: Object.values(cart).map(p => ({id: p.id, quantity: p.quantity}))
            })
        }).then(res => {
            if(res.status === 200){
                return res.json()
            }
            alert('Formulaire invalide')
        }).then(res => {
            window.location.href = '/P5/confirmation?orderId=' + res.order
            localStorage.setItem('cart', '{}');
        })
    })

}