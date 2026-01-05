// ---- ADMIN LAST SECTION UTILS -----
/**
 * Get last active admin section
 */
export function getLastAdminSection() {
    return getItem('adminLS', 'admin');
}

/**
 * Set last active admin section
 */
export function setLastAdminSection(section) {
    setItem('adminLS', section);
}

/* HELPERS */
/**
 * Get an item from localStorage
 */
export function getItem(key, defaultValue = null) {
    const item = localStorage.getItem(key);
    return item || defaultValue;
}

/**
 * Set an item in localStorage
 */
export function setItem(key, value) {
    localStorage.setItem(key, value);
}