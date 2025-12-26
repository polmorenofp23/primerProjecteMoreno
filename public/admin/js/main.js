import * as Object from './objClasses.js';

const breadcrumb = document.querySelector('.breadcrumb');           // Obtain the breadcrumb element
const sectionTitle = document.querySelector('.section-title h1');   // Obtain the section title element
const botonesMenu = document.querySelectorAll('.menu-btn');        // Obtenin botons del menu
const sections = document.querySelectorAll('.content-section');     // Obtenin seccions

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
}

/**
 * Loads the ontent of an html archive into a placeholder div
 */
async function loadHtmlInto(targetId) {
    // Minimal loader: fetch fragment, inject, move styles to head, execute scripts.
    const url = '/admin/html/' + targetId + '.html';
    const selector = '#' + targetId + '-placeholder';
    const res = await fetch(url);
    const html = await res.text();
    const container = document.querySelector(selector);
    if (!container) return null;

    container.innerHTML = html;

    // Move stylesheet links into head (no duplicate checks)
    container.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
        document.head.appendChild(link);
    });

    // Execute scripts by creating new script elements (don't await)
    const scripts = Array.from(container.querySelectorAll('script'));
    scripts.forEach(old => {
        const s = document.createElement('script');
        if (old.type) s.type = old.type;
        if (old.src) s.src = old.src;
        else s.textContent = old.textContent;
        document.body.appendChild(s);
        old.remove();
    });

    return container;
}