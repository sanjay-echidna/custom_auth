import './new-top-panel-header';

const headerNavigation = document.querySelector('.header__navigation') as HTMLElement;

function makeHeaderNavigationSticky() {
    const stickyOffset = headerNavigation.offsetTop;

    // eslint-disable-next-line deprecation/deprecation
    if (window.pageYOffset >= stickyOffset) {
        headerNavigation.classList.add('sticky', 'fadeInDown');
    } else {
        headerNavigation.classList.remove('sticky', 'fadeInDown');
    }
}

function handleScroll() {
    makeHeaderNavigationSticky();

    // eslint-disable-next-line deprecation/deprecation
    if (window.pageYOffset === 0) {
        headerNavigation.classList.remove('sticky', 'fadeInDown');
    }
}

if (headerNavigation != null) {

    window.addEventListener('scroll', handleScroll);
}


