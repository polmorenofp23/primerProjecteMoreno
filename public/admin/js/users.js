import * as Object from './objClasses.js';

const arrayUsers = [];
let filteredUsers = [];
let allUserTypes = [];

/** 
 * Load all users from API without filters
 */
async function loadUsers() {
    try {
        const res = await fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=User');
        const json = await res.json();
        const items = json.data ?? json;
        
        arrayUsers.length = 0;
        (items || []).forEach(u => {
            const user = new Object.User(
                u.id,
                u.username,
                u.email,
                u.role,
                u.userTypeId,
                u.firstName,
                u.lastName,
                u.phone,
                u.registeredAt
            );
            arrayUsers.push(user);
        });
        
        filteredUsers = [...arrayUsers];
        applyUsersFilters();
        return items;
    } catch (err) {
        console.error('Failed to load users', err);
        window.showResponseToast('Failed to load users', { level: 'danger', title: 'Error', delay: 3000 });
        return [];
    }
}

/** 
 * Load all user types from API 
 */
async function loadUserTypes() {
    try {
        const res = await fetch('http://localhost/primerProjecteMoreno/public/?controller=api&resource=User&action=getUserTypes');
        const json = await res.json();
        const items = json.data ?? json;
        
        allUserTypes = (items || []).map(ut => ({
            id: ut.id,
            name: ut.name
        }));
        
        populateUserTypeSelects();
        return allUserTypes;
    } catch (err) {
        console.error('Failed to load user types', err);
        return [];
    }
}

/** 
 * Populate user type filter and row selects 
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

    document.querySelectorAll('select.user-type-field').forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">Select user type...</option>';
        allUserTypes.forEach(ut => {
            const option = document.createElement('option');
            option.value = ut.id;
            option.textContent = ut.name;
            select.appendChild(option);
        });
        if (currentValue) select.value = currentValue;
    });
}

/**
 * Render users table content
 * */
function renderUsersTable() {
    const tbody = document.getElementById('users-table-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    for (const user of filteredUsers) {
        const tr = document.createElement('tr');
        tr.className = 'align-middle';

        const tdId = document.createElement('td');
        tdId.className = 'text-start align-middle';
        tdId.textContent = `#${user.id}`;

        const tdUsername = document.createElement('td');
        tdUsername.className = 'text-center align-middle';
        tdUsername.textContent = user.username || '-';

        const tdName = document.createElement('td');
        tdName.className = 'text-center align-middle';
        const fullName = [user.firstName, user.lastName].filter(Boolean).join(' ');
        tdName.textContent = fullName || '-';

        const tdEmail = document.createElement('td');
        tdEmail.className = 'text-center align-middle';
        tdEmail.textContent = user.email || '-';

        const tdPhone = document.createElement('td');
        tdPhone.className = 'text-center align-middle';
        tdPhone.textContent = user.phone || '-';

        const tdRole = document.createElement('td');
        tdRole.className = 'text-center align-middle';
        const roleSelect = document.createElement('select');
        roleSelect.className = 'form-select form-select-sm role-field text-uppercase';
        ['client', 'admin'].forEach(role => {
            const opt = document.createElement('option');
            opt.value = role;
            opt.textContent = role.charAt(0).toUpperCase() + role.slice(1);
            roleSelect.appendChild(opt);
        });
        roleSelect.value = user.role || 'client';
        roleSelect.addEventListener('change', async () => {
            await updateUser(user.id, roleSelect.value, user.userTypeId);
        });
        tdRole.appendChild(roleSelect);

        const tdUserType = document.createElement('td');
        tdUserType.className = 'text-center align-middle';
        const userTypeSelect = document.createElement('select');
        userTypeSelect.className = 'form-select form-select-sm user-type-field text-uppercase';
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = 'Select user type...';
        userTypeSelect.appendChild(defaultOpt);
        allUserTypes.forEach(ut => {
            const opt = document.createElement('option');
            opt.value = ut.id;
            opt.textContent = ut.name;
            userTypeSelect.appendChild(opt);
        });
        userTypeSelect.value = user.userTypeId || '';
        userTypeSelect.addEventListener('change', async () => {
            await updateUser(user.id, user.role, userTypeSelect.value);
        });
        tdUserType.appendChild(userTypeSelect);

        const tdCreatedAt = document.createElement('td');
        tdCreatedAt.className = 'text-center align-middle';
        tdCreatedAt.innerHTML = formatDateTime(user.registeredAt);

        const tdActions = document.createElement('td');
        tdActions.className = 'text-end align-middle';
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-sm bg-transparent border-0 p-2';
        deleteBtn.setAttribute('aria-label', 'Delete user');
        const trashIcon = document.createElement('i');
        trashIcon.setAttribute('data-lucide', 'trash-2');
        trashIcon.className = 'icon-red';
        deleteBtn.appendChild(trashIcon);
        deleteBtn.addEventListener('click', async () => {
            if (confirm(`Are you sure you want to delete user #${user.id}?`)) {
                await deleteUser(user.id);
            }
        });
        tdActions.appendChild(deleteBtn);

        tr.appendChild(tdId);
        tr.appendChild(tdUsername);
        tr.appendChild(tdName);
        tr.appendChild(tdEmail);
        tr.appendChild(tdPhone);
        tr.appendChild(tdRole);
        tr.appendChild(tdUserType);
        tr.appendChild(tdCreatedAt);
        tr.appendChild(tdActions);

        tbody.appendChild(tr);
    }
    
    setTimeout(() => window.initLucideIcons?.(), 0);
}

/** 
 * Update user via API (only role or userTypeId)
 */
async function updateUser(userId, role, userTypeId) {
    try {
        const payload = {
            role: role,
            userTypeId: userTypeId ? parseInt(userTypeId) : null
        };

        const res = await fetch(`http://localhost/primerProjecteMoreno/public/?controller=api&resource=User&id=${encodeURIComponent(userId)}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const json = await res.json();

        if (!res.ok) {
            window.showResponseToast(json.message || 'Failed to update user', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        const user = arrayUsers.find(u => u.id === userId);
        if (user) {
            user.role = role;
            user.userTypeId = userTypeId ? parseInt(userTypeId) : null;
        }

        window.showResponseToast('User updated successfully', { level: 'success', title: 'Success', delay: 2000 });
    } catch (err) {
        console.error('Failed to update user', err);
        window.showResponseToast('Failed to update user: ' + err.message, { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/** 
 * Delete user via API 
 */
async function deleteUser(userId) {
    try {
        const res = await fetch(`http://localhost/primerProjecteMoreno/public/?controller=api&resource=User&id=${encodeURIComponent(userId)}`, {
            method: 'DELETE'
        });

        const json = await res.json();

        if (!res.ok) {
            window.showResponseToast(json.message || 'Failed to delete user', { level: 'danger', title: 'Error', delay: 3000 });
            return;
        }

        const index = arrayUsers.findIndex(u => u.id === userId);
        if (index > -1) {
            arrayUsers.splice(index, 1);
        }

        applyUsersFilters();
        window.showResponseToast('User deleted successfully', { level: 'success', title: 'Success', delay: 2000 });
    } catch (err) {
        console.error('Failed to delete user', err);
        window.showResponseToast('Failed to delete user: ' + err.message, { level: 'danger', title: 'Error', delay: 3000 });
    }
}

/** 
 * Apply filters to users list 
 */
function applyUsersFilters() {
    const filterUserType = document.getElementById('filterUserType');
    const filterRole = document.getElementById('filterRole');

    const userTypeFilter = filterUserType?.value || '';
    const roleFilter = filterRole?.value || '';

    filteredUsers = arrayUsers.filter(user => {
        if (userTypeFilter && String(user.userTypeId) !== String(userTypeFilter)) return false;
        if (roleFilter && user.role !== roleFilter) return false;
        return true;
    });

    renderUsersTable();
}

/** 
 * Clear all filters 
 */
function clearUsersFilters() {
    const filterUserType = document.getElementById('filterUserType');
    const filterRole = document.getElementById('filterRole');
    
    if (filterUserType) filterUserType.value = '';
    if (filterRole) filterRole.value = '';

    filteredUsers = [...arrayUsers];
    renderUsersTable();
}

/* HELPERS */
/**
 * Format datetime to show date and time
 */
function formatDateTime(datetime) {
    if (!datetime) return '—';

    const date = new Date(datetime);
    const dateStr = date.toLocaleDateString('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
    const timeStr = date.toLocaleTimeString('en-GB', {
        hour: '2-digit',
        minute: '2-digit'
    });

    return `${dateStr}<br><small class="fs-12 text-muted">${timeStr}</small>`;
}

if (typeof window !== 'undefined') {
    window.loadUsers = loadUsers;

    async function initUsersSection() {
        if (document.getElementById('users-table-body')) {
            await loadUserTypes();
            await loadUsers();

            const filterUserType = document.getElementById('filterUserType');
            const filterRole = document.getElementById('filterRole');
            const refreshBtn = document.getElementById('refreshUsersBtn');
            const clearFiltersBtn = document.getElementById('clearUsersFiltersBtn');

            filterUserType?.addEventListener('change', applyUsersFilters);
            filterRole?.addEventListener('change', applyUsersFilters);
            refreshBtn?.addEventListener('click', async () => {
                await loadUsers();
            });
            clearFiltersBtn?.addEventListener('click', clearUsersFilters);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initUsersSection);
    } else {
        initUsersSection();
    }
}
