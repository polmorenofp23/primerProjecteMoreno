import * as Object from './objClasses.js';
import { $projectDomain } from './config.js';

const arrayDiscounts = [];
let filteredDiscounts = [];
let allUserTypes = [];
let isCreatingNewDiscount = false;

/**
 * Load all discounts from API
 */
async function loadDiscounts() {
    try {
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Discount`);
        const json = await res.json();
        const items = json.data ?? json;

        arrayDiscounts.length = 0;
        (items || []).forEach(d => {
            const discount = new Object.Discount(
                d.id,
                d.name,
                d.description,
                d.percentage,
                d.status,
                'user_type',
                null,
                null,
                null,
                null,
                null,
                d.userTypeId
            );
            arrayDiscounts.push(discount);
        });

        filteredDiscounts = [...arrayDiscounts];
        applyDiscountsFilters();
        return items;
    } catch (err) {
        console.error('Failed to load discounts', err);
        window.showResponseToast?.('Failed to load discounts', { level: 'danger', title: 'Error', delay: 3000 });
        return [];
    }
}

/**
 * Load all user types from API (for filters and display)
 */
async function loadUserTypes() {
    try {
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=User&action=getUserTypes`);
        const json = await res.json();
        const items = json.data ?? json;

        if (!items || !Array.isArray(items)) {
            console.error('Invalid user types response:', json);
            return [];
        }

        allUserTypes = items.map(ut => ({ id: ut.id, name: ut.name }));
        populateUserTypeSelects();
        return allUserTypes;
    } catch (err) {
        console.error('Failed to load user types', err);
        return [];
    }
}

/**
 * Populate user type filter select
 */
function populateUserTypeSelects() {
    const filterUserType = document.getElementById('filterUserType');
    if (filterUserType) {
        const currentValue = filterUserType.value;
        filterUserType.innerHTML = '<option value="">All User Types</option>';
        allUserTypes.forEach(ut => {
            const option = document.createElement('option');
            option.className = 'text-uppercase fs-16';
            option.value = ut.id;
            option.textContent = ut.name;
            filterUserType.appendChild(option);
        });
        if (currentValue) filterUserType.value = currentValue;
    }
}

/**
 * Render discounts table content
 */
function renderDiscountsTable() {
    const tbody = document.getElementById('discounts-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';

    for (const disc of filteredDiscounts) {
        const tr = document.createElement('tr');
        tr.className = 'align-middle';

        const tdId = document.createElement('td');
        tdId.className = 'text-start align-middle';
        tdId.textContent = `#${disc.id}`;

        const tdName = document.createElement('td');
        tdName.className = 'text-start align-middle';
        tdName.textContent = disc.name || '-';

        const tdDesc = document.createElement('td');
        tdDesc.className = 'text-center align-middle';
        tdDesc.textContent = disc.description || '-';

        const tdPerc = document.createElement('td');
        tdPerc.className = 'text-center align-middle';
        const percInput = document.createElement('input');
        percInput.type = 'number';
        percInput.min = '0';
        percInput.max = '100';
        percInput.step = '1';
        percInput.className = 'form-control form-control-sm text-center';
        percInput.value = disc.percentage ?? 0;
        percInput.addEventListener('change', async () => {
            const val = parseInt(percInput.value, 10);
            if (Number.isNaN(val) || val < 0 || val > 100) {
                window.showResponseToast?.('Percentage must be between 0 and 100', { level: 'warning', title: 'Validation', delay: 2000 });
                percInput.value = disc.percentage ?? 0;
                return;
            }
            await updateDiscount(disc.id, { percentage: val, status: disc.status });
        });
        tdPerc.appendChild(percInput);

        const tdStatus = document.createElement('td');
        tdStatus.className = 'text-center align-middle';
        const statusSelect = createStatusSelect(disc.status || 'active');
        statusSelect.addEventListener('change', async () => {
            await updateDiscount(disc.id, { percentage: disc.percentage, status: statusSelect.value });
        });
        tdStatus.appendChild(statusSelect);

        const tdUserType = document.createElement('td');
        tdUserType.className = 'text-center align-middle';
        const userTypeSelect = createUserTypeSelect(disc.userTypeId);
        userTypeSelect.addEventListener('change', async () => {
            if (userTypeSelect.value) {
                await updateDiscount(disc.id, { userTypeId: parseInt(userTypeSelect.value) });
            }
        });
        tdUserType.appendChild(userTypeSelect);

        const tdActions = document.createElement('td');
        tdActions.className = 'text-end align-middle';
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-sm bg-transparent border-0 p-2';
        deleteBtn.setAttribute('aria-label', 'Delete discount');
        const trashIcon = document.createElement('i');
        trashIcon.setAttribute('data-lucide', 'trash-2');
        trashIcon.className = 'icon-red';
        deleteBtn.appendChild(trashIcon);
        deleteBtn.addEventListener('click', async () => {
            if (confirm(`Delete discount #${disc.id}?`)) {
                await deleteDiscount(disc.id);
            }
        });
        tdActions.appendChild(deleteBtn);

        tr.appendChild(tdId);
        tr.appendChild(tdName);
        tr.appendChild(tdDesc);
        tr.appendChild(tdPerc);
        tr.appendChild(tdStatus);
        tr.appendChild(tdUserType);
        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    }

    setTimeout(() => window.initLucideIcons?.(), 0);
}

/**
 * Update discount (percentage/status/userTypeId)
 */
async function updateDiscount(discountId, { percentage, status, userTypeId }) {
    try {
        const payload = {};
        if (percentage !== undefined) payload.percentage = percentage;
        if (status !== undefined) payload.status = status;
        if (userTypeId !== undefined) payload.userTypeId = userTypeId;

        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Discount&id=${encodeURIComponent(discountId)}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!res.ok) {
            window.showResponseToast?.(json.message || 'Failed to update discount', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        const disc = arrayDiscounts.find(d => d.id === discountId);
        if (disc) {
            if (percentage !== undefined) disc.percentage = percentage;
            if (status !== undefined) disc.status = status;
            if (userTypeId !== undefined) disc.userTypeId = userTypeId;
        }

        window.showResponseToast?.('Discount updated', { level: 'success', title: 'Success', delay: 2000 });
        applyDiscountsFilters();
    } catch (err) {
        console.error('Failed to update discount', err);
        window.showResponseToast?.('Failed to update discount: ' + err.message, { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/**
 * Create discount (only user_type). This will be used together with user types if a form exists.
 */
async function createDiscount({ name, description, percentage, status = 'active', userTypeId }) {
    try {
        const payload = { name, description, percentage: Number(percentage), status, userTypeId: Number(userTypeId) };
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Discount`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!res.ok) {
            window.showResponseToast?.(json.message || 'Failed to create discount', { level: 'danger', title: 'Error', delay: 3000 });
            return null;
        }
        window.showResponseToast?.('Discount created', { level: 'success', title: 'Success', delay: 2000 });
        await loadDiscounts();
        return json.data ?? json;
    } catch (err) {
        console.error('Failed to create discount', err);
        window.showResponseToast?.('Failed to create discount: ' + err.message, { level: 'danger', title: 'Error', delay: 3000 });
        return null;
    }
}

/**
 * Delete discount
 */
async function deleteDiscount(discountId) {
    try {
        const res = await fetch(`${$projectDomain}/public/?controller=api&resource=Discount&id=${encodeURIComponent(discountId)}`, {
            method: 'DELETE'
        });
        const json = await res.json();
        if (!res.ok) {
            window.showResponseToast?.(json.message || 'Failed to delete discount', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }
        const idx = arrayDiscounts.findIndex(d => d.id === discountId);
        if (idx > -1) arrayDiscounts.splice(idx, 1);
        applyDiscountsFilters();
        window.showResponseToast?.('Discount deleted', { level: 'success', title: 'Success', delay: 2000 });
    } catch (err) {
        console.error('Failed to delete discount', err);
        window.showResponseToast?.('Failed to delete discount: ' + err.message, { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/**
 * Apply filters
 */
function applyDiscountsFilters() {
    const filterUserType = document.getElementById('filterUserType');
    const filterStatus = document.getElementById('filterStatus');

    const userTypeFilter = filterUserType?.value || '';
    const statusFilter = filterStatus?.value || '';

    filteredDiscounts = arrayDiscounts.filter(d => {
        if (userTypeFilter && String(d.userTypeId) !== String(userTypeFilter)) return false;
        if (statusFilter && d.status !== statusFilter) return false;
        return true;
    });

    renderDiscountsTable();
}

/**
 * Clear filters
 */
function clearDiscountsFilters() {
    const filterUserType = document.getElementById('filterUserType');
    const filterStatus = document.getElementById('filterStatus');
    if (filterUserType) filterUserType.value = '';
    if (filterStatus) filterStatus.value = '';
    filteredDiscounts = [...arrayDiscounts];
    renderDiscountsTable();
}

/**
 * Show new discount row at the top of the table
 */
function showNewDiscountRow() {
    const tbody = document.getElementById('discounts-table-body');
    if (!tbody || isCreatingNewDiscount) return;

    isCreatingNewDiscount = true;

    const tr = document.createElement('tr');
    tr.className = 'align-middle bg-light';
    tr.id = 'new-discount-row';

    const tdId = document.createElement('td');
    tdId.className = 'text-start align-middle';
    tdId.textContent = '-';
    tr.appendChild(tdId);

    const tdName = document.createElement('td');
    tdName.className = 'text-start align-middle';
    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.className = 'form-control form-control-sm';
    nameInput.placeholder = 'Discount name';
    tdName.appendChild(nameInput);
    tr.appendChild(tdName);

    const tdDesc = document.createElement('td');
    tdDesc.className = 'text-center align-middle';
    const descInput = document.createElement('input');
    descInput.type = 'text';
    descInput.className = 'form-control form-control-sm';
    descInput.placeholder = 'Description';
    tdDesc.appendChild(descInput);
    tr.appendChild(tdDesc);

    const tdPerc = document.createElement('td');
    tdPerc.className = 'text-center align-middle';
    const percInput = document.createElement('input');
    percInput.type = 'number';
    percInput.min = '0';
    percInput.max = '100';
    percInput.step = '1';
    percInput.className = 'form-control form-control-sm text-center';
    percInput.placeholder = '0';
    percInput.value = '0';
    tdPerc.appendChild(percInput);
    tr.appendChild(tdPerc);

    const tdStatus = document.createElement('td');
    tdStatus.className = 'text-center align-middle';
    const statusSelect = createStatusSelect('active');
    tdStatus.appendChild(statusSelect);
    tr.appendChild(tdStatus);

    const tdUserType = document.createElement('td');
    tdUserType.className = 'text-center align-middle';
    const userTypeSelect = createUserTypeSelect();
    tdUserType.appendChild(userTypeSelect);
    tr.appendChild(tdUserType);

    const tdActions = document.createElement('td');
    tdActions.className = 'text-end align-middle d-flex gap-2 justify-content-end';
    
    const createBtn = document.createElement('button');
    createBtn.type = 'button';
    createBtn.className = 'btn btn-sm btn-white p-2';
    createBtn.innerHTML = '<i data-lucide="circle-plus"></i>';
    createBtn.addEventListener('click', async () => {
        const name = nameInput.value.trim();
        const description = descInput.value.trim();
        const percentage = parseInt(percInput.value, 10);
        const status = statusSelect.value;
        const userTypeId = userTypeSelect.value;

        const validationError = validateNewDiscount(name, percentage, userTypeId);
        if (validationError) {
            window.showResponseToast?.(validationError, { level: 'warning', title: 'Validation', delay: 2000 });
            return;
        }

        createBtn.disabled = true;
        const result = await createDiscount({
            name,
            description: description || null,
            percentage,
            status,
            userTypeId: parseInt(userTypeId, 10)
        });
        createBtn.disabled = false;

        if (result) {
            isCreatingNewDiscount = false;
            renderDiscountsTable();
        }
    });
    tdActions.appendChild(createBtn);
    
    tr.appendChild(tdActions);

    if (tbody.firstChild) {
        tbody.insertBefore(tr, tbody.firstChild);
    } else {
        tbody.appendChild(tr);
    }

    setTimeout(() => window.initLucideIcons?.(), 0);
}

/* HELPERS */
/**
 * Validate new discount form data
 */
function validateNewDiscount(name, percentage, userTypeId) {
    if (!name) return 'Name is required';
    if (Number.isNaN(percentage) || percentage < 0 || percentage > 100) return 'Percentage must be between 0 and 100';
    if (!userTypeId) return 'User Type is required';
    return null;
}

/**
 * Create and populate a status select element
 */
function createStatusSelect(selectedValue = 'active') {
    const select = document.createElement('select');
    select.className = 'form-select form-select-sm text-uppercase';
    ['active', 'inactive'].forEach(st => {
        const opt = document.createElement('option');
        opt.value = st;
        opt.textContent = st.charAt(0).toUpperCase() + st.slice(1);
        select.appendChild(opt);
    });
    select.value = selectedValue;
    return select;
}

/**
 * Create and populate a userType select element
 */
function createUserTypeSelect(selectedValue = '') {
    const select = document.createElement('select');
    select.className = 'form-select form-select-sm text-uppercase';
    const defaultOpt = document.createElement('option');
    defaultOpt.value = '';
    defaultOpt.textContent = 'Select user type...';
    select.appendChild(defaultOpt);
    allUserTypes.forEach(ut => {
        const opt = document.createElement('option');
        opt.value = String(ut.id);
        opt.textContent = ut.name;
        select.appendChild(opt);
    });
    if (selectedValue) select.value = String(selectedValue);
    return select;
}

if (typeof window !== 'undefined') {
    window.loadDiscounts = loadDiscounts;
    window.createDiscount = createDiscount;

    async function initDiscountsSection() {
        if (document.getElementById('discounts-table-body')) {
            await loadUserTypes();
            await loadDiscounts();

            const filterUserType = document.getElementById('filterUserType');
            const filterStatus = document.getElementById('filterStatus');
            const refreshBtn = document.getElementById('refreshDiscountsBtn');
            const clearBtn = document.getElementById('clearDiscountsFiltersBtn');
            const newBtn = document.getElementById('newDiscountBtn');

            filterUserType?.addEventListener('change', applyDiscountsFilters);
            filterStatus?.addEventListener('change', applyDiscountsFilters);
            refreshBtn?.addEventListener('click', async () => {
                await loadDiscounts();
            });
            clearBtn?.addEventListener('click', clearDiscountsFilters);
            newBtn?.addEventListener('click', showNewDiscountRow);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDiscountsSection);
    } else {
        initDiscountsSection();
    }
}