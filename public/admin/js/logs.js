import { BCLogs } from './objClasses.js';

let logsData = [];
let filteredLogs = [];

/**
 * Render the logs table
 */
function renderLogsTable() {
    const tbody = document.getElementById('logs-table-body');
    tbody.innerHTML = '';

    if (filteredLogs.length === 0) {
        showNoDataMessage();
        return;
    }

    filteredLogs.forEach(log => {
        const row = createLogRow(log);
        tbody.appendChild(row);
    });

    setTimeout(() => window.initLucideIcons?.(), 0);
}

/**
 * Fetch all logs from the API
 */
async function loadLogs(tableName = null) {
    try {
        let url = '/?controller=api&resource=BCLogs';
        if (tableName && tableName !== '') {
            url += `&table_name=${encodeURIComponent(tableName)}`;
        }

        const response = await fetch(url);
        const data = await response.json();

        if (data.status === true && Array.isArray(data.data)) {
            logsData = data.data.map(log => new BCLogs(
                log.id,
                log.operation,
                log.table_name,
                log.row_ids,
                log.performed_at,
                log.details
            ));
            filteredLogs = [...logsData];
            renderLogsTable();
            populateTableNameFilter();
        } else {
            console.error('Error fetching logs:', data);
            showNoDataMessage();
        }
    } catch (error) {
        console.error('Error fetching logs:', error);
        showNoDataMessage('Error loading logs. Please try again.');
    }
}

/**
 * Create a table row for a log
 */
function createLogRow(log) {
    const tr = document.createElement('tr');

    const tdId = document.createElement('td');
    tdId.className = 'font-sting-light fs-14 text-start align-middle';
    tdId.textContent = log.id;
    tr.appendChild(tdId);

    const tdOperation = document.createElement('td');
    tdOperation.className = 'font-sting-regular fs-16 text-center align-middle text-uppercase';
    tdOperation.textContent = log.operation;
    tr.appendChild(tdOperation);

    const tdTableName = document.createElement('td');
    tdTableName.className = 'font-sting-regular fs-14 text-center align-middle text-uppercase';
    tdTableName.textContent = log.tableName;
    tr.appendChild(tdTableName);

    const tdRowIds = document.createElement('td');
    tdRowIds.className = 'font-sting-light fs-12 text-center align-middle';
    tdRowIds.innerHTML = formatRowIds(log.rowIds);
    tr.appendChild(tdRowIds);

    const tdPerformedAt = document.createElement('td');
    tdPerformedAt.className = 'font-sting-light fs-14 text-center align-middle';
    tdPerformedAt.innerHTML = formatDateTime(log.performedAt);
    tr.appendChild(tdPerformedAt);

    const tdDetails = document.createElement('td');
    tdDetails.className = 'font-sting-light fs-12 text-end align-middle';
    tdDetails.textContent = log.details || '—';
    tr.appendChild(tdDetails);

    return tr;
}

/**
 * Format row_ids JSON object into readable string
 */
function formatRowIds(rowIds) {
    if (!rowIds || typeof rowIds !== 'object') {
        return '—';
    }

    const entries = Object.entries(rowIds);
    if (entries.length === 0) {
        return '—';
    }

    return entries
        .map(([key, value]) => `<strong>${key}:</strong> ${value}`)
        .join('<br>');
}

/**
 * Format datetime string
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

/**
 * Show no data message
 */
function showNoDataMessage(message = 'No logs found') {
    const tbody = document.getElementById('logs-table-body');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-5 text-muted">
                <i data-lucide="inbox" class="icon-40 mb-3"></i>
                <p class="fs-18">${message}</p>
            </td>
        </tr>
    `;

    setTimeout(() => window.initLucideIcons?.(), 0);
}

/**
 * Populate the table name filter dropdown
 */
function populateTableNameFilter() {
    const select = document.getElementById('filterTableName');
    const currentValue = select.value;

    const tableNames = [...new Set(logsData.map(log => log.tableName))].sort();
    select.innerHTML = '<option value="">All Tables</option>';
    tableNames.forEach(tableName => {
        const option = document.createElement('option');
        option.value = tableName;
        option.textContent = tableName.toUpperCase();
        select.appendChild(option);
    });

    if (currentValue && tableNames.includes(currentValue)) {
        select.value = currentValue;
    }
}

/**
 * Handle filter change
 */
function handleFilterChange() {
    const tableName = document.getElementById('filterTableName').value;

    if (tableName === '') {
        filteredLogs = [...logsData];
    } else {
        filteredLogs = logsData.filter(log => log.tableName === tableName);
    }

    renderLogsTable();
}

/**
 * Handle refresh button click
 */
function handleRefreshClick() {
    const tableName = document.getElementById('filterTableName').value;
    loadLogs(tableName || null);
}

/**
 * Initialize the page when DOM elements become available
 */
async function initializePage() {
    await loadLogs();

    const checkElements = setInterval(() => {
        const filterElement = document.getElementById('filterTableName');
        const refreshButton = document.getElementById('refreshLogsBtn');
        
        if (filterElement && refreshButton) {
            clearInterval(checkElements);
            filterElement.addEventListener('change', handleFilterChange);      
            refreshButton.addEventListener('click', handleRefreshClick);
            setTimeout(() => window.initLucideIcons?.(), 0);
        }
    }, 100);

    setTimeout(() => {
        clearInterval(checkElements);
    }, 5000);
}

initializePage();
