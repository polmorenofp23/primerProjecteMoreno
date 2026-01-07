import * as Object from './objClasses.js';
import { formatCurrency } from './freeCurrencyApi-utils.js';
import { $projectDomain } from './config.js';

const arrayProducts = [];

/**
 * Render products table from arrayProducts
 */
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
        const priceFormatted = await formatCurrency(Number(prod.price || 0), 'EUR');
        tdPrice.textContent = priceFormatted;

        const tdActions = document.createElement('td');
        tdActions.classList.add('align-middle', 'text-center', 'd-flex', 'justify-content-end', 'gap-3', 'pe-3');
        const btnModify = document.createElement('button'); btnModify.className = 'btn-white p-1'; btnModify.textContent = 'Modify';
        btnModify.addEventListener('click', async (ev) => {
            ev.preventDefault();
            const productId = prod.id;
            await openEditModal(productId);
        });
        const btnDelete = document.createElement('button'); btnDelete.className = 'btn-red p-1'; btnDelete.textContent = 'Delete';
        btnDelete.dataset.productId = prod.id;
        btnDelete.addEventListener('click', async (ev) => {
            const id = ev.currentTarget.dataset.productId;
            if (!id) return;
            if (!confirm('Are you sure you want to delete this product? This will remove its ingredients as well.')) return;
            try {
                const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Product&id=${encodeURIComponent(id)}`, { method: 'DELETE' });
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
    
    setTimeout(() => window.initLucideIcons?.(), 0);        // Initialize Lucide icons after rendering
}

/**
 * Load products from API
 */
function loadProducts() {
    return fetch(`${$projectDomain}/public/?controller=api&resource=Product`)
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

// ============ INGREDIENTS HELPER SECTION ============

const DISH_TYPE_MAX_GRAMS = { appetiser: 250, main: 500, dessert: 180, drink: null };
let allIngredients = [];
let selectedIngredients = [];
let editingProductId = null; // Track if editing an existing product

async function loadIngredientsFromAPI() {
    try {
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Ingredient`);
        const data = await res.json();
        if (data.status && Array.isArray(data.data)) {
            allIngredients = data.data.filter(ing => ing.available);
        }
    } catch (e) {
        console.error('Failed to load ingredients', e);
    }
}

function loadIngredientsAvailable(selectEl) {
    selectEl.innerHTML = '<option value="" disabled selected>Select an ingredient...</option>' +
    allIngredients.map(ing => `<option value="${ing.id}">${ing.name} (${ing.pricePer100g}€/100g) - ${ing.category.toUpperCase()}</option>`).join('');
}

async function openEditModal(productId) {

    try {
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Product&id=${encodeURIComponent(productId)}`);
        const json = await res.json();
        const product = json.data;

        if (!product) {
            window.showResponseToast('Product not found', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        if (allIngredients.length === 0) {
            await loadIngredientsFromAPI();
        }

        document.getElementById('productModalLabel').textContent = 'Modify Product';
        document.getElementById('productInfoBtn').textContent = 'Save Updates';
        document.getElementById('productIdLabel').textContent = product.id || '—';
        document.getElementById('productName').value = product.name || '';
        document.getElementById('productPrice').value = product.price || '';
        document.getElementById('productDishType').value = product.dishType || '';
        document.getElementById('productDescription').value = product.description || '';
        document.getElementById('productAvailable').checked = Boolean(product.available);

        selectedIngredients = [];
        if (product.productIngredients && Array.isArray(product.productIngredients)) {
            selectedIngredients = product.productIngredients.map(pi => ({
                id: pi.ingredientId,
                name: allIngredients.find(ing => ing.id === pi.ingredientId)?.name || '',
                pricePer100g: allIngredients.find(ing => ing.id === pi.ingredientId)?.pricePer100g || 0,
                category: allIngredients.find(ing => ing.id === pi.ingredientId)?.category || '',
                grams: pi.gramsPerPortion,
                isDefault: pi.isDefault
            }));
        }

        const productIngredients = document.getElementById('productIngredients');
        if (selectedIngredients.length > 0) {
            renderSelectedIngredients();
        } else {
            productIngredients.innerHTML = '';
        }

        const dishType = product.dishType;
        const maxGrams = DISH_TYPE_MAX_GRAMS[dishType];
        document.getElementById('dishTypeMaxGr').textContent = maxGrams === null ? '(Drinks max gr: Variable)' : `(Max ${maxGrams}g)`;
        document.getElementById('ingredientSelect').disabled = true;
        editingProductId = productId;

        const modal = new bootstrap.Modal(document.getElementById('productInfoModal'));
        modal.show();
    } catch (err) {
        console.error('Failed to load product:', err);
        window.showResponseToast('Failed to load product', { level: 'danger', title: 'Error', delay: 3000 });
    }
}

function resetModal() {
    document.getElementById('productModalLabel').textContent = 'Info Product';
    document.getElementById('productInfoBtn').textContent = 'Save';
    document.getElementById('productIdLabel').textContent = '—';
    document.getElementById('dishTypeMaxGr').textContent = '(Max gr for dish type)';
    editingProductId = null;
    selectedIngredients = [];
}
function setupCreateMode() {
    document.getElementById('productModalLabel').textContent = 'Create Product';
    document.getElementById('productInfoBtn').textContent = 'Create';
    document.getElementById('productIdLabel').textContent = '—';
    document.getElementById('productInfoForm').reset();
    document.getElementById('productAvailable').checked = true;
    selectedIngredients = [];
    document.getElementById('productIngredients').innerHTML = '';
    document.getElementById('ingredientSelect').disabled = true;
    document.getElementById('dishTypeMaxGr').textContent = '(Max gr for dish type)';
    editingProductId = null;
}

function renderSelectedIngredients() {
    const productIngredients = document.getElementById('productIngredients');
    productIngredients.innerHTML = selectedIngredients.map(ing => `
        <div class="d-flex justify-content-between align-items-center border border-1 border-secondary-white rounded-0 p-3 w-100">
            <div class="col-auto form-check me-3">
                <input class="form-check-input rounded-0 p-2" type="checkbox" id="ingredientDefault${ing.id}" ${ing.isDefault ? 'checked' : ''} title="Default ingredient in product">
            </div>
            <div class="col d-flex gap-3 align-items-center w-100">
                <span class="p-2 bg-secondary-white rounded-0 text-primary-black text-nowrap w-100">${ing.name} (${ing.pricePer100g}€/100g) - ${ing.category.toUpperCase()}</span>
                <div class="d-flex gap-1 align-items-center w-25">
                    <input type="number" class="form-control form-control-sm rounded-0 w-100 py-2" placeholder="gr" value="${ing.grams}" min="0" data-ing-id="${ing.id}">
                    <span class="font-sting-regular fs-14">g</span>
                </div>
                <button type="button" class="btn bg-transparent border-0 p-2 ms-1" data-ing-id="${ing.id}">
                    <i data-lucide="x" class="icon-grey"></i> 
                </button>
            </div>
        </div>
    `).join('');

    productIngredients.querySelectorAll('input').forEach(inp => {
        inp.addEventListener('change', (e) => {
            const ing = selectedIngredients.find(i => i.id === parseInt(e.target.dataset.ingId));
            if (ing) ing.grams = parseFloat(e.target.value) || 0;
        });
    });

    productIngredients.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = parseInt(btn.dataset.ingId);
            selectedIngredients = selectedIngredients.filter(i => i.id !== id);
            renderSelectedIngredients();
        });
    });

    setTimeout(() => window.initLucideIcons?.(), 0);
}

function setupIngredientsUI() {
    const dishTypeSelect = document.getElementById('productDishType');
    const ingredientSelect = document.getElementById('ingredientSelect');
    const productIngredients = document.getElementById('productIngredients');
    const dishTypeMaxGr = document.getElementById('dishTypeMaxGr');
    let ingredientsLoaded = false;

    // Setup modal to show CREATE mode when opened via the "CREATE NEW PRODUCT" button
    const modal = document.getElementById('productInfoModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', (e) => {
            if (!editingProductId) {
                setupCreateMode();
            }
        });
    }

    dishTypeSelect.addEventListener('change', async () => {
        const dishType = dishTypeSelect.value;
        const maxGrams = DISH_TYPE_MAX_GRAMS[dishType];
        dishTypeMaxGr.textContent = maxGrams === null ? '(Drinks max gr: Variable)' : `(Max ${maxGrams}g)`;
        ingredientSelect.disabled = !dishType;
        if (dishType) {
            ingredientSelect.value = '';
            if (!ingredientsLoaded) {
                await loadIngredientsFromAPI();
                loadIngredientsAvailable(ingredientSelect);
                ingredientsLoaded = true;
            }
        }
    });

    ingredientSelect.addEventListener('change', () => {
        const ingredientId = parseInt(ingredientSelect.value);
        if (!ingredientId) return;

        const ingredient = allIngredients.find(i => i.id === ingredientId);
        if (!ingredient || selectedIngredients.some(s => s.id === ingredientId)) {
            ingredientSelect.value = '';
            return;
        }

        selectedIngredients.push({ id: ingredientId, name: ingredient.name, pricePer100g: ingredient.pricePer100g, category: ingredient.category, grams: 0, isDefault: true });
        renderSelectedIngredients();
        ingredientSelect.value = '';
    });

    // Event listener to the product form
    const productInfoForm = document.getElementById('productInfoForm');
    if (productInfoForm) {
        productInfoForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const productName = document.getElementById('productName').value.trim();
            const productPrice = parseFloat(document.getElementById('productPrice').value);
            const productDishType = document.getElementById('productDishType').value;
            const productDescription = document.getElementById('productDescription').value.trim();
            const productAvailable = document.getElementById('productAvailable').checked;

            if (!productName) {
                window.showResponseToast('Please enter a product name', { level: 'warning', title: 'Validation Error', delay: 3000 });
                return;
            }
            if (!productDishType) {
                window.showResponseToast('Please select a dish type', { level: 'warning', title: 'Validation Error', delay: 3000 });
                return;
            }
            if (selectedIngredients.length === 0) {
                window.showResponseToast('Please add at least one ingredient', { level: 'warning', title: 'Validation Error', delay: 3000 });
                return;
            }

            try {
                const productData = {
                    name: productName,
                    price: productPrice || 0,
                    dish_type: productDishType,
                    description: productDescription,
                    available: productAvailable ? 1 : 0,
                    productIngredients: selectedIngredients.map(ing => ({
                        ingredientId: ing.id,
                        gramsPerPortion: ing.grams,
                        portionPrice: 0,
                        isDefault: document.getElementById(`ingredientDefault${ing.id}`)?.checked || false
                    }))
                };

                console.log('Product data to send:', productData);

                const method = editingProductId ? 'PUT' : 'POST';
                const url = editingProductId 
                    ? `${$projectDomain}/public/?controller=api&resource=Product&id=${encodeURIComponent(editingProductId)}`
                    : `${$projectDomain}/public/?controller=api&resource=Product`;

                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(productData)
                });

                const responseText = await res.text();
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (e) {
                    console.error('Server response:', responseText);
                    window.showResponseToast('Server error: Invalid JSON response', { level: 'danger', title: 'Error', delay: 5000 });
                    return;
                }

                if (!res.ok) {
                    window.showResponseToast(result.message || 'Failed to save product', { level: 'danger', title: 'Error', delay: 5000 });
                    return;
                }

                const message = editingProductId ? 'Product updated successfully' : 'Product created successfully';
                window.showResponseToast(message, { level: 'success', title: 'Success', delay: 3000 });
                
                productInfoForm.reset();
                resetModal();
                const modal = bootstrap.Modal.getInstance(document.getElementById('productInfoModal'));
                // Remove focus from any element before hiding modal
                document.activeElement?.blur();
                modal?.hide();
                await loadProducts();

            } catch (err) {
                console.error('Error saving product:', err);
                window.showResponseToast('Failed to save product: ' + err.message, { level: 'danger', title: 'Error', delay: 5000 });
            }
        });
    }
}

if (typeof window !== 'undefined' && document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupIngredientsUI);
} else if (typeof window !== 'undefined') {
    setupIngredientsUI();
}