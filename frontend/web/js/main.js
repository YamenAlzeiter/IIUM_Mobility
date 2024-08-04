document.addEventListener('DOMContentLoaded', function() {
    loader();
    loadSideNavSaved();
});

const subs = document.querySelectorAll('.collapse-container');
const sidebarState = localStorage.getItem('sidebarState');

const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId);

    if (toggle && nav && bodypd && headerpd) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('show-sidenav');
            nav.classList.toggle('collapse-sidenav');
            bodypd.classList.toggle('body-pd');
            headerpd.classList.toggle('body-pd');

            handleSubMenu(nav.classList.contains('collapse-sidenav'));
            localStorage.setItem('sidebarState', nav.classList.contains('show-sidenav') ? 'expanded' : 'collapsed');
        });
    }
};

const subMenus = document.querySelectorAll('.collapse-trigger');
subMenus.forEach(submenu => {
    submenu.addEventListener('click', event => {
        event.preventDefault();
        const targetId = submenu.getAttribute('data-target');
        const target = document.querySelector(targetId);
        if (target) {
            target.classList.toggle('show');
            submenu.classList.toggle('mb-1');
        }
        const chevronIcon = submenu.querySelector('.ti-chevron-down');
        if (chevronIcon) {
            chevronIcon.classList.toggle('chevron-rotate');
        }
    });
});

function handleSubMenu(forceAllCollapse) {
    subs.forEach(sub => {
        if (forceAllCollapse) {
            sub.classList.remove('show');
        } else {
            const subUrl = sub.querySelector('.sub-active');
            if (subUrl) {
                const parent = subUrl.parentNode;
                const submenu = document.querySelector(`[data-target="#${parent.getAttribute('id')}"]`);
                if (submenu) {
                    submenu.classList.add('mb-1');
                    parent.classList.add('show');
                    const chevronIcon = submenu.querySelector('.ti-chevron-down');
                    if (chevronIcon) {
                        chevronIcon.classList.add('chevron-rotate');
                    }
                }
            }
        }
    });
}

function loader() {
    const minLoadTime = 700;
    let isPageLoaded = false;

    function hideLoader() {
        const loader = document.getElementById('preloader');
        if (loader) {
            loader.style.display = 'none';
        }
    }

    setTimeout(() => {
        if (isPageLoaded) {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader);
        }
    }, minLoadTime);

    window.addEventListener('load', () => {
        isPageLoaded = true;
        setTimeout(hideLoader, Math.max(0, minLoadTime - performance.now()));
    });
}

function loadSideNavSaved() {
    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

    const nav = document.getElementById('nav-bar');
    const bodypd = document.getElementById('body-pd');
    const headerpd = document.getElementById('header');

    if (sidebarState === 'expanded') {
        bodypd.classList.add('body-pd');
        headerpd.classList.add('body-pd');
        nav.classList.add('show-sidenav');
        nav.classList.remove('collapse-sidenav');
        handleSubMenu(false);
    } else if (sidebarState === 'collapsed') {
        nav.classList.remove('show-sidenav');
        bodypd.classList.remove('body-pd');
        headerpd.classList.remove('body-pd');
        nav.classList.add('collapse-sidenav');
        handleSubMenu(true);
    } else {
        bodypd.classList.add('body-pd');
        headerpd.classList.add('body-pd');
        nav.classList.add('show-sidenav');
    }
}
