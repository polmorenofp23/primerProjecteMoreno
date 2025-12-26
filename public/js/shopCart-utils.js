// Para usarlo en php guardariamos las ids 
// fer el carrito en una taula nova  ala base ded ades


const cart = [
    { id: 1, name: 'Product 1', quantity: 2, price: 10.0 },
    { id: 2, name: 'Product 2', quantity: 1, price: 20.0 },
];

localStorage.setItem('shopCart', JSON.stringify(cart));

const shopCart = JSON.parse(localStorage.getItem('shopCart'));