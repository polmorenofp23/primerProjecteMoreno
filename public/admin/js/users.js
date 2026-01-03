
const arrayUsers = [];
fetch('http://localhost/primerProjecteMoreno/public/?controller=User&action=getAllUsers')
    .then(response => response.json())
    .then(usersData => {
        (usersData || []).forEach(user => {
            const newUser = new Object.User(
                user.id,
                user.username,
                user.email,
                user.role,
                user.userType,
                user.firstName,
                user.lastName,
                user.phone,
                user.registeredAt
            );
            arrayUsers.push(newUser);
            console.log(newUser);
        });
    })
    .catch(err => console.warn('Failed to load users', err));

    // Para usarlo en php guardariamos las ids 
// fer el carrito en una taula nova  ala base ded ades


// const cart = [
//     { id: 1, name: 'Product 1', quantity: 2, price: 10.0 },
//     { id: 2, name: 'Product 2', quantity: 1, price: 20.0 },
// ];

// localStorage.setItem('shopCart', JSON.stringify(cart));

// const shopCart = JSON.parse(localStorage.getItem('shopCart'));