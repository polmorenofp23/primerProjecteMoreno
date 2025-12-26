
// Para usarlo en php guardariamos las ids 
// fer el carrito en una taula nova  ala base ded ades


    const usersInfo = [
        { id: 1, name: 'Product 1', quantity: 2, price: 10.0 },
        { id: 2, name: 'Product 2', quantity: 1, price: 20.0 },
];
const userId = 123; // Example user ID

localStorage.setItem('userLoggedId', JSON.stringify(userId));

const userLogged = JSON.parse(localStorage.getItem('userLoggedId'));