// resources/js/app.js
import axios from 'axios';
import './bootstrap';

// Configure axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// Token management
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Global state
window.App = {
    user: null,
    isAuthenticated: false,
    userRole: null,

    init() {
        console.log('🚀 App initializing...');
        this.checkAuth();
        this.setupEventListeners();
        
        // Show initial loading state
        const navLinks = document.getElementById('navLinks');
        if (navLinks) {
            navLinks.innerHTML = `
                <li class="nav-item">
                    <span class="nav-link">
                        <div class="spinner-border spinner-border-sm text-light me-1" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Loading...
                    </span>
                </li>
            `;
        }
    },

    async checkAuth() {
        const token = localStorage.getItem('token');
        if (token) {
            try {
                console.log('🔑 Token found, fetching user...');
                const response = await axios.get('/api/auth/me');
                console.log('👤 User data:', response.data);

                // Fix: Extract data properly
                this.user = response.data.data || response.data;
                this.isAuthenticated = true;
                this.userRole = this.user.role;
                console.log('✅ User authenticated:', this.user.email, 'Role:', this.userRole);
            } catch (error) {
                console.error('❌ Auth check failed:', error);
                this.handleAuthError();
            }
        } else {
            console.log('👤 No token found, showing guest menu');
            this.isAuthenticated = false;
            this.user = null;
        }
        
        // Always update nav after auth check
        this.updateNav();
    },

    handleAuthError() {
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];
        this.user = null;
        this.isAuthenticated = false;
        this.userRole = null;
    },

    updateNav() {
        console.log('🔄 Updating navigation...');
        const navLinks = document.getElementById('navLinks');

        if (!navLinks) {
            console.error('❌ navLinks element not found!');
            return;
        }

        let html = '';

        if (this.isAuthenticated && this.user) {
            console.log('👤 Building authenticated menu for:', this.user.role);
            
            // Always show Courses
            html += `<li class="nav-item"><a class="nav-link" href="/courses"><i class="bi bi-book"></i> Courses</a></li>`;

            // Role specific menus
            if (this.user.role === 'instructor') {
                html += `
                    <li class="nav-item"><a class="nav-link" href="/instructor/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/courses/create"><i class="bi bi-plus-circle"></i> Create Course</a></li>
                `;
            }
            
            if (this.user.role === 'student') {
                html += `<li class="nav-item"><a class="nav-link" href="/my-courses"><i class="bi bi-collection"></i> My Courses</a></li>`;
            }

            // User dropdown
            html += `
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> ${this.user.name}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#" onclick="App.showProfile()"><i class="bi bi-person"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="App.logout()"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            `;
        } else {
            console.log('👤 Building guest menu');
            html = `
                <li class="nav-item"><a class="nav-link" href="/courses"><i class="bi bi-book"></i> Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                <li class="nav-item"><a class="nav-link" href="/register"><i class="bi bi-person-plus"></i> Register</a></li>
            `;
        }

        navLinks.innerHTML = html;
        console.log('✅ Navigation updated successfully');

        // Reinitialize dropdowns
        setTimeout(() => {
            this.initDropdowns();
        }, 100);
    },

    initDropdowns() {
        if (typeof bootstrap !== 'undefined') {
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                try {
                    new bootstrap.Dropdown(dropdown);
                } catch (e) {
                    console.warn('Dropdown init error:', e);
                }
            });
        }
    },

    async logout() {
        console.log('🚪 Logging out...');
        try {
            await axios.post('/api/auth/logout');
            this.showToast('Logged out successfully', 'success');
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            this.handleAuthError();
            this.updateNav();
            window.location.href = '/';
        }
    },

    async login(email, password) {
        console.log('🔑 Attempting login...');
        this.showLoader();
        
        try {
            const response = await axios.post('/api/auth/login', {
                email: email,
                password: password
            });

            console.log('Login response:', response.data);

            if (response.data && response.data.data) {
                const { token, user } = response.data.data;

                localStorage.setItem('token', token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                this.user = user;
                this.isAuthenticated = true;
                this.userRole = user.role;
                
                this.updateNav();
                this.showToast('Login successful!', 'success');
                
                // Redirect based on role
                setTimeout(() => {
                    if (user.role === 'instructor') {
                        window.location.href = '/instructor/dashboard';
                    } else if (user.role === 'student') {
                        window.location.href = '/my-courses';
                    } else {
                        window.location.href = '/courses';
                    }
                }, 500);
                
                return { success: true };
            }
        } catch (error) {
            console.error('Login error:', error);
            this.showToast(error.response?.data?.message || 'Login failed', 'error');
            return { success: false, error: error.response?.data?.message };
        } finally {
            this.hideLoader();
        }
    },

    showProfile() {
        this.showToast('Profile feature coming soon!', 'info');
    },

    showLoader() {
        const loader = document.getElementById('loader');
        if (loader) loader.classList.add('active');
    },

    hideLoader() {
        const loader = document.getElementById('loader');
        if (loader) loader.classList.remove('active');
    },

    showToast(message, type = 'info') {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 3000 });
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    },

    setupEventListeners() {
        console.log('Setting up event listeners...');
        
        // Login form
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            console.log('Login form found');
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const email = document.getElementById('email')?.value;
                const password = document.getElementById('password')?.value;

                if (email && password) {
                    await this.login(email, password);
                }
            });
        }

        // Register form
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            console.log('Register form found');
            registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                this.showToast('Registration feature coming soon!', 'info');
            });
        }
    }
};

// Initialize app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('📄 DOM loading...');
        window.App.init();
    });
} else {
    console.log('📄 DOM already loaded');
    window.App.init();
}