
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