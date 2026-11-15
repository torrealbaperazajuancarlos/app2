const root = document.documentElement;

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const isDark = root.classList.toggle('dark');

        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
});

const sidebar = document.querySelector('[data-sidebar]');
const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
const sidebarToggles = document.querySelectorAll('[data-sidebar-toggle]');

const setSidebarOpen = (isOpen) => {
    if (!sidebar) {
        return;
    }

    sidebar.classList.toggle('-translate-x-full', !isOpen);
    sidebar.classList.toggle('translate-x-0', isOpen);
    sidebarOverlay?.classList.toggle('hidden', !isOpen);
    document.body.classList.toggle('overflow-hidden', isOpen);

    sidebarToggles.forEach((toggle) => {
        toggle.setAttribute('aria-expanded', String(isOpen));
    });
};

sidebarToggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
        setSidebarOpen(sidebar?.classList.contains('-translate-x-full') ?? false);
    });
});

sidebarOverlay?.addEventListener('click', () => setSidebarOpen(false));

window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
    if (event.matches) {
        setSidebarOpen(false);
    }
});

const deleteModal = document.getElementById('confirm-delete-modal');
const deleteForm = deleteModal?.querySelector('form');
const deleteName = deleteModal?.querySelector('[data-delete-name]');

document.querySelectorAll('[data-delete], [data-delete-author]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!deleteModal || !deleteForm) {
            return;
        }

        deleteForm.action = button.dataset.deleteUrl ?? '';
        deleteName.textContent = button.dataset.deleteName ?? button.dataset.authorName ?? '';

        deleteModal.showModal();
    });
});

deleteModal?.querySelector('[data-modal-cancel]')?.addEventListener('click', () => deleteModal.close());

deleteModal?.addEventListener('click', (event) => {
    if (event.target === deleteModal) {
        deleteModal.close();
    }
});

const getScrollBehavior = () => (window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth');

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-carousel-track]');
    const items = Array.from(carousel.querySelectorAll('[data-carousel-item]'));
    const dots = Array.from(carousel.querySelectorAll('[data-carousel-dot]'));
    const previousButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    const status = carousel.querySelector('[data-carousel-status]');

    if (!track || items.length === 0) {
        return;
    }

    const getStep = () => {
        const gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;

        return items[0].getBoundingClientRect().width + gap;
    };

    const getVisibleCount = () => {
        const step = getStep();

        if (step === 0) {
            return 1;
        }

        const gap = step - items[0].getBoundingClientRect().width;

        return Math.max(1, Math.min(items.length, Math.round((track.clientWidth + gap) / step)));
    };

    const getPageCount = () => Math.max(1, items.length - getVisibleCount() + 1);

    const getCurrentIndex = () => {
        const step = getStep();

        if (step === 0) {
            return 0;
        }

        return Math.min(Math.max(Math.round(track.scrollLeft / step), 0), getPageCount() - 1);
    };

    const goTo = (index) => {
        const target = Math.min(Math.max(index, 0), getPageCount() - 1);

        track.scrollTo({ left: target * getStep(), behavior: getScrollBehavior() });
    };

    const update = () => {
        const visibleCount = getVisibleCount();
        const pageCount = getPageCount();
        const currentIndex = getCurrentIndex();
        const firstVisible = currentIndex + 1;
        const lastVisible = Math.min(currentIndex + visibleCount, items.length);

        if (status) {
            status.textContent = lastVisible > firstVisible
                ? `Mostrando ${firstVisible}–${lastVisible} de ${items.length} comentarios`
                : `Mostrando ${firstVisible} de ${items.length} comentarios`;
        }

        dots.forEach((dot, index) => {
            dot.classList.toggle('hidden', index >= pageCount);
            dot.setAttribute('aria-current', index === currentIndex ? 'true' : 'false');
        });

        if (previousButton) {
            previousButton.disabled = currentIndex <= 0;
        }

        if (nextButton) {
            nextButton.disabled = currentIndex >= pageCount - 1;
        }
    };

    previousButton?.addEventListener('click', () => goTo(getCurrentIndex() - 1));
    nextButton?.addEventListener('click', () => goTo(getCurrentIndex() + 1));

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goTo(index));
    });

    track.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);

    update();
});
