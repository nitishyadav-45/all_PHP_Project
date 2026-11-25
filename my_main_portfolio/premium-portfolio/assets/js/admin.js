document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const storedTheme = localStorage.getItem('portfolioAdminTheme') || 'dark';
    const themeToggle = document.getElementById('themeToggle');
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    const applyTheme = (theme) => {
        root.setAttribute('data-admin-theme', theme);
        localStorage.setItem('portfolioAdminTheme', theme);
        const icon = themeToggle?.querySelector('i');
        if (icon) {
            icon.className = theme === 'dark' ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
        }
    };

    applyTheme(storedTheme);

    themeToggle?.addEventListener('click', () => {
        const nextTheme = root.getAttribute('data-admin-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(nextTheme);
    });

    const openSidebar = () => {
        sidebar?.classList.add('open');
        sidebarBackdrop?.classList.add('show');
    };

    const closeSidebar = () => {
        sidebar?.classList.remove('open');
        sidebarBackdrop?.classList.remove('show');
    };

    sidebarToggle?.addEventListener('click', openSidebar);
    sidebarBackdrop?.addEventListener('click', closeSidebar);

    document.querySelectorAll('.confirm-delete').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm('Delete this item permanently?')) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('.image-preview-input').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const preview = document.createElement('img');
            preview.className = 'current-image mt-3';
            preview.alt = 'Selected image preview';
            preview.src = URL.createObjectURL(file);

            const panel = input.closest('.upload-panel') || input.parentElement;
            panel?.querySelector('.generated-preview')?.remove();
            preview.classList.add('generated-preview');
            panel?.appendChild(preview);
        });
    });
});

