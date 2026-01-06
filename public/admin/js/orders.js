import * as Object from './objClasses.js';
import { formatCurrency } from './freeCurrencyApi-utils.js';

const arrayOrders = [];
let filteredOrders = [];
let editingOrderId = null;
let allUsers = [];
let allProducts = [];

/** 
 * Format user info for display 
 */
function formatUserLabel(user) {
    if (!user) return '-';
    return `#${user.id} ${user.firstName} ${user.lastName || ''}`.trim();
}

function formatProductLabel(productId, productName) {
    if (!productId) return '-';
    const resolvedName = productName || allProducts.find(p => String(p.id) === String(productId))?.name;
    return resolvedName ? `#${productId} ${resolvedName}` : `#${productId}`;
}

/** 
* Load all users from API
*/
async function loadUsers() {
    try {
        const res = await fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=User');
        const json = await res.json();
        allUsers = (json.data ?? json) || [];
        populateUserSelects();
        return allUsers;
    } catch (err) {
        console.error('Failed to load users', err);
        return [];
    }
}

/**
 * Populate user select elements ( used to fill the select in the modals and in the fiklter)
 */
function populateUserSelects(selectId = '#orderUserId', defaultLabel = 'Select user...', isDisabled = true) {
    const selects = selectId.startsWith('#') && selectId.includes(',') === false && document.getElementById(selectId)
        ? [document.getElementById(selectId)]
        : document.querySelectorAll(selectId);

    selects.forEach(select => {
        if (!select) return;
        const currentValue = select.value;
        select.innerHTML = `<option value="" ${isDisabled ? 'disabled' : ''}>${defaultLabel}</option>`;
        allUsers.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = formatUserLabel(user);
            select.appendChild(option);
        });
        if (currentValue && allUsers.some(u => String(u.id) === String(currentValue))) {
            select.value = currentValue;
        }
    });
}

/**
 * Populate product select elements with format "#id - name"
 */
function populateProductSelect(selectElement) {
    if (!selectElement) return;
    
    selectElement.innerHTML = '<option value="">Select a product...</option>';
    
    allProducts.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id;
        option.textContent = `#${product.id} - ${product.name}`;
        selectElement.appendChild(option);
    });
}

/**
 * Load all products from API
 */
async function loadProducts() {
    try {
        const res = await fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=Product');
        const json = await res.json();
        allProducts = (json.data ?? json) || [];
        return allProducts;
    } catch (err) {
        console.error('Failed to load products', err);
        return [];
    }
}

/** 
 * Render all content into the orders table
 */
async function renderArrayOrders() {
    const tbody = document.getElementById('orders-table-body');
    if (!tbody) return;
    tbody.innerHTML = '';
    
    for (const order of filteredOrders) {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.classList.add('align-middle', 'text-start');
        tdId.textContent = `#${order.id ?? ''}`;

        const tdUserId = document.createElement('td');
        tdUserId.classList.add('align-middle', 'text-center');
        const user = allUsers.find(u => u.id === order.userId);
        tdUserId.textContent = formatUserLabel(user);

        const tdTime = document.createElement('td');
        tdTime.classList.add('align-middle', 'text-center');
        if (order.createdAt) {
            const dateObj = new Date(order.createdAt);
            tdTime.textContent = dateObj.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
        } else {
            tdTime.textContent = '-';
        }

        const tdDate = document.createElement('td');
        tdDate.classList.add('align-middle', 'text-center');
        if (order.createdAt) {
            const dateObj = new Date(order.createdAt);
            tdDate.textContent = dateObj.toLocaleDateString('en-GB');
        } else {
            tdDate.textContent = '-';
        }

        const tdOrderStatus = document.createElement('td');
        tdOrderStatus.classList.add('align-middle', 'text-center', 'text-uppercase', 'font-sting-regular', 'fs-14');
        const statusText = order.orderStatus ? order.orderStatus.replace('-', ' ') : '-';
        tdOrderStatus.textContent = statusText;


        const tdPaymentStatus = document.createElement('td');
        tdPaymentStatus.classList.add('align-middle', 'text-center', 'text-uppercase', 'font-sting-regular', 'fs-14');
        const paymentText = order.paymentStatus ? order.paymentStatus.replace('-', ' ') : '-';
        tdPaymentStatus.textContent = paymentText;

        const tdTable = document.createElement('td');
        tdTable.classList.add('align-middle', 'text-center');
        tdTable.textContent = order.tableId ? `${order.tableId}` : '-';

        const tdDiscount = document.createElement('td');
        tdDiscount.classList.add('align-middle', 'text-end');
        const discountColor = order.discountAmount > 0 ? 'text-success' : '';
        tdDiscount.className = `align-middle text-end ${discountColor}`;
        (async () => {
            const discountPrefix = order.discountAmount > 0 ? '-' : '';
            const discountFormatted = await formatCurrency(Number(order.discountAmount || 0), 'EUR');
            tdDiscount.textContent = `${discountPrefix}${discountFormatted}`;
        })();

        const tdTotal = document.createElement('td');
        tdTotal.classList.add('align-middle', 'text-end');
        (async () => {
            const totalFormatted = await formatCurrency(Number(order.totalAmount || 0), 'EUR');
            tdTotal.textContent = totalFormatted;
        })();

        const tdActions = document.createElement('td');
        tdActions.classList.add('align-middle', 'text-center', 'd-flex', 'justify-content-end', 'gap-2', 'pe-3');

        const btnView = document.createElement('button');
        btnView.className = 'btn btn-sm bg-transparent border-0 p-2';
        btnView.title = 'View details';
        const iconView = document.createElement('i');
        iconView.setAttribute('data-lucide', 'eye');
        iconView.className = 'icon-grey';
        btnView.appendChild(iconView);
        btnView.addEventListener('click', async (ev) => {
            ev.preventDefault();
            const orderId = order.id;
            await openViewModal(orderId);
        });

        const btnModify = document.createElement('button');
        btnModify.className = 'btn-white p-1';
        btnModify.textContent = 'Modify';
        btnModify.addEventListener('click', async (ev) => {
            ev.preventDefault();
            const orderId = order.id;
            await openEditModal(orderId);
        });

        const btnDelete = document.createElement('button');
        btnDelete.className = 'btn-red p-1';
        btnDelete.textContent = 'Delete';
        btnDelete.dataset.orderId = order.id;
        btnDelete.addEventListener('click', async (ev) => {
            const id = ev.currentTarget.dataset.orderId;
            if (!id) return;
            if (!confirm('Are you sure you want to delete this order?')) return;
            try {
                const res = await fetch(`http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order&id=${encodeURIComponent(id)}`, { method: 'DELETE' });
                if (!res.ok) {
                    const j = await res.json().catch(() => null);
                    window.showResponseToast(j?.message || (`Failed to delete order: ${res.statusText}`), { level: 'danger', title: 'Delete failed', delay: 5000 });
                    return;
                }
                await loadOrders();
                window.showResponseToast('Order deleted', { level: 'success', title: 'Deleted', delay: 3000 });
            } catch (e) {
                console.error('Delete failed', e);
                window.showResponseToast('Failed to delete order', { level: 'danger', title: 'Error', delay: 5000 });
            }
        });

        tdActions.appendChild(btnView);
        tdActions.appendChild(btnModify);
        tdActions.appendChild(btnDelete);

        tr.appendChild(tdId);
        tr.appendChild(tdUserId);
        tr.appendChild(tdTime);
        tr.appendChild(tdDate);
        tr.appendChild(tdOrderStatus);
        tr.appendChild(tdPaymentStatus);
        tr.appendChild(tdTable);
        tr.appendChild(tdDiscount);
        tr.appendChild(tdTotal);
        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    }
    
    setTimeout(() => window.initLucideIcons?.(), 0); // Initialize Lucide icons after rendering
}

/**
 * Load orders from API
 */    
function loadOrders() {
    return fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order')
        .then(r => r.json())
        .then(json => {
            const items = json.data ?? json;
            arrayOrders.length = 0;
            (items || []).forEach(o => {
                const orderLines = (o.orderLines || []).map(ol => {
                    const line = new Object.OrderLine(
                        ol.lineId,
                        ol.orderId,
                        ol.productId,
                        ol.quantity,
                        ol.unitPrice,
                        ol.ingredients || []
                    );
                    if (allProducts.length > 0) {
                        const productName = allProducts.find(p => String(p.id) === String(ol.productId))?.name || ol.productName;
                        if (productName) line.productName = productName;
                    }
                    return line;
                });

                const order = new Object.Orders(
                    o.id,
                    o.userId,
                    o.idDiscount,
                    o.totalAmount,
                    o.discountAmount,
                    o.tableId,
                    o.orderStatus,
                    o.paymentStatus,
                    o.createdAt,
                    o.updatedAt,
                    orderLines
                );
                arrayOrders.push(order);
            });

            filteredOrders = [...arrayOrders];
            applyOrdersFilters();
            return items;
        })
        .catch(err => { console.error('Failed to load orders', err); throw err; });
}

/** 
 * Apply to the orders list the filters selected by the filter 
 */
function applyOrdersFilters() {
    const userFilter = document.getElementById('filterUser');
    const dateFilter = document.getElementById('filterDate');
    const minPriceInput = document.getElementById('filterMinPrice');
    const maxPriceInput = document.getElementById('filterMaxPrice');
    const sortSelect = document.getElementById('filterSort');

    const userId = userFilter?.value || '';
    const dateValue = dateFilter?.value || '';
    const minPrice = minPriceInput?.value ? parseFloat(minPriceInput.value) : NaN;
    const maxPrice = maxPriceInput?.value ? parseFloat(maxPriceInput.value) : NaN;
    const sortValue = sortSelect?.value || '';

    filteredOrders = arrayOrders.filter(order => {
        if (userId && String(order.userId) !== String(userId)) return false;

        if (dateValue) {
            if (!order.createdAt) return false;
            const orderDate = new Date(order.createdAt);
            const isoDate = orderDate.toISOString().slice(0, 10);
            if (isoDate !== dateValue) return false;
        }

        const total = Number(order.totalAmount || 0);
        if (!Number.isNaN(minPrice) && total < minPrice) return false;
        if (!Number.isNaN(maxPrice) && total > maxPrice) return false;

        return true;
    });

    filteredOrders.sort((a, b) => {
        switch (sortValue) {
            case 'date-asc':
                return new Date(a.createdAt) - new Date(b.createdAt);
            case 'date-desc':
                return new Date(b.createdAt) - new Date(a.createdAt);
            case 'price-asc':
                return Number(a.totalAmount || 0) - Number(b.totalAmount || 0);
            case 'price-desc':
                return Number(b.totalAmount || 0) - Number(a.totalAmount || 0);
            default:
                return 0;
        }
    });

    renderArrayOrders();
}

/** 
 * Clear all the filters setted for the orders list
 */
function clearOrdersFilters() {
    const userFilter = document.getElementById('filterUser');
    const dateFilter = document.getElementById('filterDate');
    const minPriceInput = document.getElementById('filterMinPrice');
    const maxPriceInput = document.getElementById('filterMaxPrice');
    const sortSelect = document.getElementById('filterSort');

    if (userFilter) userFilter.value = '';
    if (dateFilter) dateFilter.value = '';
    if (minPriceInput) minPriceInput.value = '';
    if (maxPriceInput) maxPriceInput.value = '';
    if (sortSelect) sortSelect.value = '';

    filteredOrders = [...arrayOrders];
    renderArrayOrders();
}

if (typeof window !== 'undefined') {
    window.loadOrders = loadOrders;

    async function initOrdersSection() {
        if (document.getElementById('orders-table-body')) {
            await loadUsers();
            await loadProducts();
            populateUserSelects('#orderUserId', 'Select user...', true);      // For modals
            populateUserSelects('#filterUser', 'All Users', false);           // For the filter
            await loadOrders();

            const userFilter = document.getElementById('filterUser');
            const dateFilter = document.getElementById('filterDate');
            const minPriceInput = document.getElementById('filterMinPrice');
            const maxPriceInput = document.getElementById('filterMaxPrice');
            const sortSelect = document.getElementById('filterSort');
            const refreshBtn = document.getElementById('refreshOrdersBtn');
            const clearBtn = document.getElementById('clearOrdersFiltersBtn');

            userFilter?.addEventListener('change', applyOrdersFilters);
            dateFilter?.addEventListener('change', applyOrdersFilters);
            minPriceInput?.addEventListener('input', () => {
                if (minPriceInput.value && maxPriceInput) {
                    const minValue = parseFloat(minPriceInput.value);
                    maxPriceInput.min = (minValue + 0.01).toFixed(2);
                    if (maxPriceInput.value && parseFloat(maxPriceInput.value) < minValue + 0.01) {
                        maxPriceInput.value = '';
                    }
                } else if (maxPriceInput) {
                    maxPriceInput.min = '0';
                }
                applyOrdersFilters();
            });
            maxPriceInput?.addEventListener('input', applyOrdersFilters);
            sortSelect?.addEventListener('change', applyOrdersFilters);
            refreshBtn?.addEventListener('click', () => loadOrders());
            clearBtn?.addEventListener('click', clearOrdersFilters);
        }
        document.addEventListener('currencyChanged', () => renderArrayOrders());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOrdersSection);
    } else {
        initOrdersSection();
    }
}

/** ---------------- MODALS GESTION ------------ */
/**
 * Show the modal with order details
 */
async function openViewModal(orderId) {
    try {
        if (allProducts.length === 0) {
            await loadProducts();
        }
        const res = await fetch(`http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order&id=${encodeURIComponent(orderId)}`);
        const json = await res.json();
        const order = json.data;

        if (!order) {
            window.showResponseToast('Order not found', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        const user = allUsers.find(u => u.id === order.userId);

        document.querySelector('[data-field="id"]').textContent = `#${order.id}`;
        document.querySelector('[data-field="createdAt"]').textContent = new Date(order.createdAt).toLocaleString('en-GB');
        document.querySelector('[data-field="user"]').textContent = formatUserLabel(user);
        document.querySelector('[data-field="tableId"]').textContent = order.tableId || '-';
        document.querySelector('[data-field="orderStatus"]').textContent = order.orderStatus?.replace('-', ' ') || '-';
        document.querySelector('[data-field="paymentStatus"]').textContent = order.paymentStatus?.replace('-', ' ') || '-';

        const totalFormatted = await formatCurrency(Number(order.totalAmount || 0), 'EUR');
        const discountFormatted = await formatCurrency(Number(order.discountAmount || 0), 'EUR');
        document.querySelector('[data-field="totalAmount"]').textContent = totalFormatted;
        const discountPrefix = order.discountAmount > 0 ? '-' : '';
        document.querySelector('[data-field="discountAmount"]').textContent = `${discountPrefix}${discountFormatted}`;

        const orderDetailsLines = document.getElementById('orderDetailsLines');
        orderDetailsLines.innerHTML = '';
        
        for (const line of (order.orderLines || [])) {
            const tr = document.createElement('tr');
            
            const tdLineId = document.createElement('td');
            tdLineId.classList.add('align-middle', 'text-start');
            tdLineId.textContent = line.lineId;
            
            const tdProductId = document.createElement('td');
            tdProductId.classList.add('align-middle', 'text-start');
            tdProductId.textContent = formatProductLabel(line.productId, line.productName);
            
            const tdQuantity = document.createElement('td');
            tdQuantity.classList.add('align-middle', 'text-center');
            tdQuantity.textContent = 'x' + line.quantity;
            
            const tdUnitPrice = document.createElement('td');
            tdUnitPrice.classList.add('align-middle', 'text-center');
            const unitPriceFormatted = await formatCurrency(Number(line.unitPrice || 0), 'EUR');
            tdUnitPrice.textContent = unitPriceFormatted;
            
            const tdTotal = document.createElement('td');
            tdTotal.classList.add('align-middle', 'text-end');
            const lineTotalFormatted = await formatCurrency(Number(line.quantity * line.unitPrice || 0), 'EUR');
            tdTotal.textContent = lineTotalFormatted;
            
            tr.appendChild(tdLineId);
            tr.appendChild(tdProductId);
            tr.appendChild(tdQuantity);
            tr.appendChild(tdUnitPrice);
            tr.appendChild(tdTotal);
            
            orderDetailsLines.appendChild(tr);
        }

        const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
        modal.show();
    } catch (err) {
        console.error('Failed to load order:', err);
        window.showResponseToast('Failed to load order', { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/**
 * Show the modal to edit/create an order
 */
async function openEditModal(orderId) {
    try {
        const res = await fetch(`http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order&id=${encodeURIComponent(orderId)}`);
        const json = await res.json();
        const order = json.data;

        if (!order) {
            window.showResponseToast('Order not found', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        if (allProducts.length === 0) {
            await loadProducts();
        }

        document.getElementById('orderModalLabel').textContent = 'Modify Order';
        document.getElementById('orderInfoBtn').textContent = 'Save Updates';
        document.getElementById('orderIdLabel').textContent = `#${order.id}`;
        document.getElementById('orderDateLabel').textContent = new Date(order.createdAt).toLocaleString('en-GB');
        document.getElementById('orderUserId').value = order.userId || '';
        document.getElementById('orderTableId').value = order.tableId || '';
        document.getElementById('orderStatus').value = order.orderStatus || '';
        document.getElementById('paymentStatus').value = order.paymentStatus || '';
        document.getElementById('orderTotalAmount').value = order.totalAmount || '0.00';
        document.getElementById('orderDiscountAmount').value = order.discountAmount || '0.00';

        const orderLinesTableBody = document.getElementById('orderLinesTableBody');
        orderLinesTableBody.innerHTML = (order.orderLines || []).map(line => {
            const total = (Number(line.quantity) * Number(line.unitPrice || 0)).toFixed(2);
            const unit = Number(line.unitPrice || 0).toFixed(2);
            return `
            <tr data-line-id="${line.lineId}" data-unit-price="${unit}" class="py-3 existing-line">
                <td class="text-start align-middle">#${line.lineId}</td>
                <td class="text-start align-middle">${formatProductLabel(line.productId, line.productName)}</td>
                <td class="text-center align-middle py-0">
                    <div class="input-group input-group-sm">
                        <select class="form-select form-select-sm quantity-field rounded-0 py-2" required>
                            ${Array.from({length: 10}, (_, i) => i + 1).map(num => 
                                `<option value="${num}"${num === line.quantity ? ' selected' : ''}>${num}</option>`
                            ).join('')}
                        </select>
                    </div>
                </td>
                <td class="text-center align-middle">${unit} €</td>
                <td class="text-end align-middle"><span class="line-total-field">${total} €</span></td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm bg-transparent border-0 p-2 delete-existing-line-btn" aria-label="Delete line">
                        <i data-lucide="trash-2" class="icon-red"></i>
                    </button>
                </td>
            </tr>`;
        }).join('');

        orderLinesTableBody.querySelectorAll('tr[data-line-id]').forEach(tr => {
            const qtyInput = tr.querySelector('.quantity-field');
            const totalSpan = tr.querySelector('.line-total-field');
            const unit = parseFloat(tr.dataset.unitPrice || '0');
            qtyInput.addEventListener('change', () => {
                const q = parseInt(qtyInput.value) || 0;
                totalSpan.textContent = `${(unit * q).toFixed(2)} €`;
            });
            
            
            const deleteBtn = tr.querySelector('.delete-existing-line-btn');
            if (deleteBtn) {            // DELETE EXISTING LINE HANDLER
                deleteBtn.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    tr.querySelectorAll('td').forEach(td => {
                        td.classList.add('text-primary-grey');
                    });
                    tr.classList.add('text-primary-grey');
                    qtyInput.disabled = true;
                    qtyInput.classList.add('text-primary-grey');
                    deleteBtn.disabled = true;
                    tr.dataset.deleted = 'true';
                });
            }
        });

        editingOrderId = orderId;

        const modal = new bootstrap.Modal(document.getElementById('orderInfoModal'));
        modal.show();

        setTimeout(() => window.initLucideIcons?.(), 0);
    } catch (err) {
        console.error('Failed to load order:', err);
        window.showResponseToast('Failed to load order', { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/** 
 * Reset the order modal to default state
 */
function resetModal() {
    document.getElementById('orderModalLabel').textContent = 'Info Order';
    document.getElementById('orderInfoBtn').textContent = 'Save';
    document.getElementById('orderIdLabel').textContent = '—';
    document.getElementById('orderDateLabel').textContent = '—';
    editingOrderId = null;
}

/**
 * Setup the order modal for create mode (changing some things of the edittion mode)
 */
function setupCreateMode() {
    document.getElementById('orderModalLabel').textContent = 'Create Order';
    document.getElementById('orderInfoBtn').textContent = 'Create';
    document.getElementById('orderIdLabel').textContent = '—';
    document.getElementById('orderDateLabel').textContent = '—';
    document.getElementById('orderInfoForm').reset();
    const linesBody = document.getElementById('orderLinesTableBody');
    if (linesBody) linesBody.innerHTML = '';
    editingOrderId = null;
}

/**
 * Setup all the content for all the components
 */
function setupOrdersUI() {
    const modal = document.getElementById('orderInfoModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', async (e) => {
            if (!editingOrderId) {
                setupCreateMode();
            }
            if (allUsers.length === 0) {
                await loadUsers();
            }
            populateUserSelects();
        });

        modal.addEventListener('hidden.bs.modal', () => {
            resetModal();
        });
    }

    const addLineBtn = document.getElementById('addOrderLineBtn');
    if (addLineBtn) {      // ADD ORDER LINE HANDLER
        addLineBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const tbody = document.getElementById('orderLinesTableBody');
            const tr = document.createElement('tr');
            tr.className = 'new-line-entry order-line-row';
            tr.innerHTML = `
                <td class="text-start align-middle">—</td>
                <td class="text-start align-middle">
                    <div class="input-group input-group-sm">
                        <select class="form-control form-control-sm product-select rounded-0 py-2" required>
                            <option value="">Select a product...</option>
                        </select>
                    </div>
                </td>
                <td class="text-center align-middle">
                    <div class="input-group input-group-sm">
                        <select class="form-select form-select-sm quantity-field rounded-0 py-2" required>
                            ${Array.from({ length: 10 }, (_, i) => i + 1).map(num => `
                                <option value="${num}">${num}</option>
                            `).join('')}
                        </select>
                    </div>
                </td>
                <td class="text-center align-middle"><span class="unit-price-field">0.00 €</span></td>
                <td class="text-end align-middle"><span class="line-total-field">0.00 €</span></td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm bg-transparent border-0 p-2 remove-line-btn" aria-label="Remove line">
                        <i data-lucide="trash-2" class="icon-red"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);

            const productSelect = tr.querySelector('.product-select');
            populateProductSelect(productSelect);
            setTimeout(() => window.initLucideIcons?.(), 0);

            const updateTotals = () => {
                const productId = productSelect.value;
                const qty = parseInt(tr.querySelector('.quantity-field').value) || 0;
                const product = allProducts.find(p => String(p.id) === String(productId));
                const unit = product ? Number(product.price || 0) : 0;
                tr.querySelector('.unit-price-field').textContent = `${unit.toFixed(2)} €`;
                tr.querySelector('.line-total-field').textContent = `${(unit * qty).toFixed(2)} €`;
            };

            productSelect.addEventListener('change', updateTotals);
            tr.querySelector('.quantity-field').addEventListener('change', updateTotals);
            tr.querySelector('.remove-line-btn').addEventListener('click', (ev) => {
                ev.preventDefault();
                tr.remove();
            });
        });
    }

    const orderInfoForm = document.getElementById('orderInfoForm');
    if (orderInfoForm) {
        orderInfoForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const userId = parseInt(document.getElementById('orderUserId').value);
            const tableIdValue = document.getElementById('orderTableId').value;
            const tableId = tableIdValue ? parseInt(tableIdValue) : 1;
            const orderStatus = document.getElementById('orderStatus').value || 'pending';
            const paymentStatus = document.getElementById('paymentStatus').value || 'pending';

            if (!userId) {
                window.showResponseToast('Please select a user', { level: 'warning', title: 'Validation Error', delay: 3000 });
                return;
            }

            try {
                let orderData;
                if (!editingOrderId) {      // CREATE MODE: products array
                    const productLines = Array.from(document.querySelectorAll('#orderLinesTableBody .new-line-entry')).map(tr => {
                        const productId = parseInt(tr.querySelector('.product-select').value);
                        const quantity = parseInt(tr.querySelector('.quantity-field').value);
                        return { productId, quantity };
                    });

                    if (productLines.length === 0) {
                        window.showResponseToast('Please add at least one product', { level: 'warning', title: 'Validation Error', delay: 3000 });
                        return;
                    }

                    orderData = {
                        userId,
                        orderStatus,
                        paymentStatus,
                        tableId,
                        products: productLines
                    };
                } else {                // EDIT MODE:  order fields + orderLines with actions
                    const orderLines = [];
                    document.querySelectorAll('#orderLinesTableBody tr[data-line-id]').forEach(tr => {
                        const lineId = parseInt(tr.dataset.lineId);
                        const isDeleted = tr.dataset.deleted === 'true';
                        if (isDeleted) {
                            orderLines.push({
                                action: 'delete',
                                lineId: lineId
                            });
                        } else {
                            const quantityInput = tr.querySelector('.quantity-field');
                            const newQuantity = parseInt(quantityInput.value); 
                            orderLines.push({
                                action: 'update',
                                lineId: lineId,
                                quantity: newQuantity
                            });
                        }
                    });

                    document.querySelectorAll('#orderLinesTableBody .new-line-entry').forEach(tr => {
                        const productId = parseInt(tr.querySelector('.product-select').value);
                        const quantity = parseInt(tr.querySelector('.quantity-field').value);
                        if (productId && quantity > 0) {
                            orderLines.push({
                                action: 'add',
                                productId: productId,
                                quantity: quantity
                            });
                        }
                    });

                    orderData = {
                        userId,
                        orderStatus,
                        paymentStatus,
                        tableId,
                        orderLines
                    };
                }

                console.log('Order data to send:', orderData);
                const method = editingOrderId ? 'PUT' : 'POST';
                const url = editingOrderId 
                    ? `http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order&id=${encodeURIComponent(editingOrderId)}`
                    : 'http://localhost/primerProjecteMoreno/public/?controller=api&resource=Order';

                const res = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(orderData)
                });

                const responseText = await res.text();
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (parseErr) {
                    console.error('Failed to parse response:', responseText);
                    throw new Error('Invalid response from server');
                }

                if (!res.ok) {
                    const errors = result.errors || result.message || 'Unknown error';
                    window.showResponseToast(String(errors), { level: 'danger', title: 'Request failed', delay: 5000 });
                    return;
                }

                const message = editingOrderId ? 'Order updated successfully' : 'Order created successfully';
                window.showResponseToast(message, { level: 'success', title: 'Success', delay: 3000 });
                
                orderInfoForm.reset();
                resetModal();
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('orderInfoModal'));
                document.activeElement?.blur();
                modalInstance?.hide();
                await loadOrders();

            } catch (err) {
                console.error('Error saving order:', err);
                window.showResponseToast('Failed to save order: ' + err.message, { level: 'danger', title: 'Error', delay: 5000 });
            }
        });
    }
}

if (typeof window !== 'undefined' && document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupOrdersUI);
} else if (typeof window !== 'undefined') {
    setupOrdersUI();
}