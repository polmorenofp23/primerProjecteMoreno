import * as Object from './objClasses.js';
import { exchangeCoinTo } from './freeCurrencyApi-utils.js';

const arrayProducts = [];

async function renderArrayProducts() {
    const tbody = document.getElementById('products-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';
    for (const prod of arrayProducts) {
        const tr = document.createElement('tr');

        const tdName = document.createElement('td'); tdName.classList.add('align-middle'); tdName.textContent = prod.name || '';
        const tdId = document.createElement('td'); tdId.classList.add('align-middle', 'text-center'); tdId.textContent = prod.id ?? '';
        const tdDish = document.createElement('td'); tdDish.classList.add('align-middle', 'text-center'); tdDish.textContent = prod.dishType || '';

        const tdStatus = document.createElement('td');
        tdStatus.classList.add('align-middle', 'text-center');
        const iconStatus = document.createElement('i');
        iconStatus.setAttribute('data-lucide', prod.available ? 'circle-check' : 'circle-x');
        iconStatus.className = prod.available ? 'text-success' : 'text-danger';
        tdStatus.appendChild(iconStatus);

        const tdPrice = document.createElement('td');
        tdPrice.classList.add('align-middle', 'text-end');
        const targetCurrency = (typeof window !== 'undefined' && window.currentCurrency) ? window.currentCurrency : 'EUR';
        const priceConverted = await exchangeCoinTo(Number(prod.price || 0), 'EUR', targetCurrency);
        tdPrice.textContent = new Intl.NumberFormat(undefined, { style: 'currency', currency: targetCurrency }).format(priceConverted);

        const tdActions = document.createElement('td');
        tdActions.classList.add('align-middle', 'text-center', 'd-flex', 'justify-content-end', 'gap-3', 'pe-3');
        const btnModify = document.createElement('button'); btnModify.className = 'btn-white p-1'; btnModify.textContent = 'Modify';
        const btnDelete = document.createElement('button'); btnDelete.className = 'btn-red p-1'; btnDelete.textContent = 'Delete';
        btnDelete.dataset.productId = prod.id;
        btnDelete.addEventListener('click', async (ev) => {
            const id = ev.currentTarget.dataset.productId;
            if (!id) return;
            if (!confirm('Are you sure you want to delete this product? This will remove its ingredients as well.')) return;
            try {
                const res = await fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=Product&id=' + encodeURIComponent(id), { method: 'DELETE' });
                if (!res.ok) {
                    const j = await res.json().catch(() => null);
                    window.showResponseToast(j?.message || ('Failed to delete product: ' + res.statusText), { level: 'danger', title: 'Delete failed', delay: 5000 });
                    return;
                }
                await loadProducts();
                window.showResponseToast('Product deleted', { level: 'success', title: 'Deleted', delay: 3000 });
            } catch (e) {
                console.error('Delete failed', e);
                window.showResponseToast('Failed to delete product', { level: 'danger', title: 'Error', delay: 5000 });
            }
        });
        tdActions.appendChild(btnModify);
        tdActions.appendChild(btnDelete);

        tr.appendChild(tdName);
        tr.appendChild(tdId);
        tr.appendChild(tdDish);
        tr.appendChild(tdStatus);
        tr.appendChild(tdPrice);
        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    }
}

function loadProducts() {
    return fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=Product')
        .then(r => r.json())
        .then(json => {
            const items = json.data ?? json;
            arrayProducts.length = 0; // reset
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
            });

            renderArrayProducts();
            return items;
        })
        .catch(err => { console.error('Failed to load products', err); throw err; });
}

if (typeof window !== 'undefined') {
    window.loadProducts = loadProducts;

    async function initProductsSection() {
        if (document.getElementById('products-table-body')) {
            await loadProducts();
        }
        document.addEventListener('currencyChanged', () => renderArrayProducts());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductsSection);
    } else {
        initProductsSection();
    }
}