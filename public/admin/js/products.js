import * as Object from './objClasses.js';

const arrayProducts = [];

function loadProducts() {
    return fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=Product')
        .then(r => r.json())
        .then(json => {
            const items = json.data ?? json;
            const tbody = document.getElementById('products-table-body');
            if (!tbody) return items;
            tbody.innerHTML = '';
            (items || []).forEach(p => {
                const pis = (p.productIngredients || []).map(pi => new Object.ProductIngredient(
                    pi.productId,
                    pi.ingredientId,
                    pi.gramsPerPortion,
                    pi.portionPrice,
                    pi.isDefault
                ));

                const prod = new Object.Product(
                    p.id,
                    p.name,
                    p.description,
                    p.dishType,
                    p.price,
                    p.imgDir,
                    p.available,
                    p.createdAt,
                    p.updatedAt,
                    pis
                );
                arrayProducts.push(prod);

                const tr = document.createElement('tr');
                const tdEmpty = document.createElement('td');
                const tdName = document.createElement('td'); tdName.textContent = prod.name || '';
                const tdId = document.createElement('td'); tdId.textContent = prod.id ?? '';
                const tdDish = document.createElement('td'); tdDish.textContent = prod.dishType || '';
                const tdStatus = document.createElement('td'); tdStatus.textContent = prod.available ? 'Available' : 'Unavailable';
                const tdPrice = document.createElement('td'); tdPrice.textContent = prod.price ?? '';
                const tdActions = document.createElement('td');
                const btnModify = document.createElement('button'); btnModify.className = 'btn-white p-1 me-3'; btnModify.textContent = 'Modify';
                const btnDelete = document.createElement('button'); btnDelete.className = 'btn-red p-1'; btnDelete.textContent = 'Delete';
                tdActions.appendChild(btnModify);
                tdActions.appendChild(btnDelete);

                tr.appendChild(tdEmpty);
                tr.appendChild(tdName);
                tr.appendChild(tdId);
                tr.appendChild(tdDish);
                tr.appendChild(tdStatus);
                tr.appendChild(tdPrice);
                tr.appendChild(tdActions);

                tbody.appendChild(tr);
            });
            return items;
        })
        .catch(err => { console.error('Failed to load products', err); throw err; });
}


if (typeof window !== 'undefined') {
    window.loadProducts = loadProducts;
    if (document.getElementById('products-table-body')) {
        loadProducts();
    }
}