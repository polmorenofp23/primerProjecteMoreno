import * as Object from './objClasses.js';

const breadcrumb = document.querySelector('.breadcrumb');           // Obtain the breadcrumb element
const sectionTitle = document.querySelector('.section-title h1');   // Obtain the section title element
const botonesMenu = document.querySelectorAll('.menu-btn');        // Obtenin botons del menu
const sections = document.querySelectorAll('.content-section');     // Obtenin seccions
const globalCurrencySelector = document.getElementById('global-currency'); // obtenain currency selector element

window.currentCurrency = window.currentCurrency || 'EUR'; // Global currency (default EUR)

botonesMenu.forEach( button => {
    button.addEventListener('click', () => {
        const target= button.getAttribute('data-target');
        setActiveSection(target);
    });
});

// Funcio per establir seccio activa, changin title and breadcrumb content
function setActiveSection(targetId) {
    let sectionName = null
    botonesMenu.forEach(button => {
        button.classList.remove('active'); 
        if (button.getAttribute('data-target') === targetId) {
            button.classList.add('active');
            sectionName = button.textContent.charAt(0).toUpperCase() + button.textContent.slice(1);
        }
    });

    let breadcrumbActiveLi = breadcrumb.querySelector('li[aria-current="page"]');
    if (breadcrumbActiveLi) breadcrumbActiveLi.remove();
    breadcrumbActiveLi = document.createElement('li');
    breadcrumbActiveLi.className = 'breadcrumb-item text-primary-grey text-capitalize active';
    breadcrumbActiveLi.setAttribute('aria-current', 'page');
    breadcrumbActiveLi.textContent = sectionName || '';
    breadcrumb.appendChild(breadcrumbActiveLi);

    sectionTitle.textContent = sectionName;

    sections.forEach(section => {
        section.classList.remove('active-section');
    });
    document.getElementById(targetId).classList.add('active-section');
    const ph = document.getElementById(targetId + '-placeholder');
    if (ph && ph.innerHTML.trim() === '') {
        loadHtmlInto(targetId).catch(e => console.error(e));
    }

    if (globalCurrencySelector) {
        if (targetId === 'products' || targetId === 'orders') globalCurrencySelector.classList.remove('d-none');
        else globalCurrencySelector.classList.add('d-none');
    }
}

/**
 * Loads the ontent of an html archive into a placeholder div
 */
async function loadHtmlInto(targetId) {
   
    const url = '/admin/html/' + targetId + '.html';
    const selector = '#' + targetId + '-placeholder';
    const res = await fetch(url);
    const html = await res.text();
    const container = document.querySelector(selector);
    if (!container) return null;
    container.innerHTML = html;

    const scripts = Array.from(container.querySelectorAll('script'));
    scripts.forEach(old => {
        const s = document.createElement('script');
        if (old.type) s.type = old.type;
        if (old.src) s.src = old.src;
        else s.textContent = old.textContent;
        document.body.appendChild(s);
        old.remove();
    });
    
    window.lucide?.createIcons?.();

    return container;
}

// Update currency icons across the admin UI
function setCurrencyIcon() {
    const ids = ['currency-icon', 'currency-display-icon', 'global-currency-icon'];
    const cur = (typeof window !== 'undefined' && window.currentCurrency) ? window.currentCurrency : 'EUR';
    ids.forEach(id => {
        const iconSpan = document.getElementById(id);
        if (!iconSpan) return;
        iconSpan.innerHTML = '';
        const i = document.createElement('i');
        i.setAttribute('data-lucide', cur === 'EUR' ? 'euro' : (cur === 'GBP' ? 'pound-sterling' : 'dollar-sign'));
        iconSpan.appendChild(i);
    });
    if (typeof window !== 'undefined' && window.lucide) {
        if (typeof window.lucide.createIcons === 'function') window.lucide.createIcons();
        else if (typeof window.lucide.replace === 'function') window.lucide.replace();
    }
}

// Initialize global currency selector wiring
function initGlobalCurrencySelector() {
    const currOptions = document.getElementById('global-currency-options');
    if (!currOptions) return;

    const activate = (btn, emit = true) => {
        currOptions.querySelectorAll('.currency-btn').forEach(b => b.classList.toggle('active', b === btn));
        const c = btn.dataset.currency;
        window.currentCurrency = c;
        setCurrencyIcon();
        if (emit) document.dispatchEvent(new CustomEvent('currencyChanged', { detail: { currency: c } }));
    };

    currOptions.addEventListener('click', (e) => {
        const btn = e.target.closest('.currency-btn');
        if (btn && currOptions.contains(btn)) activate(btn, true);
    });

    window.currentCurrency = 'EUR';
    const eurBtn = currOptions.querySelector('.currency-btn[data-currency="EUR"]') || currOptions.querySelector('.currency-btn');
    if (eurBtn) activate(eurBtn, false);
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initGlobalCurrencySelector);
else initGlobalCurrencySelector();
