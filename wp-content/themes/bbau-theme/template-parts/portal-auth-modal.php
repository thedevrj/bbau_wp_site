<?php 
$media_base = getenv('DJANGO_MEDIA_URL');
?>

<!-- Login Modal -->
<div class="sc-modal" id="login-modal">
    <div class="sc-modal-overlay" onclick="toggleModal('login-modal', false)"></div>
    <div class="sc-modal-box">
        <button class="sc-modal-close" onclick="toggleModal('login-modal', false)">&times;</button>
        <div class="sc-modal-header">
            <h3>Portal Authentication</h3>
            <!-- <p class="sc-modal-subtitle">access for Faculty & Staff</p> -->
        </div>
        <div class="sc-modal-body">
            <form id="staff-login-form">
                <div class="sc-input-group">
                    <label class="sc-input-label">Username</label>
                    <input type="text" name="username" class="sc-input" placeholder="Enter your Username" required>
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Password</label>
                    <input type="password" name="password" class="sc-input" placeholder="••••••••" required>
                </div>
                <div id="login-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-login-submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal (First Login) -->
<div class="sc-modal" id="password-modal">
    <div class="sc-modal-overlay"></div>
    <div class="sc-modal-box">
        <div class="sc-modal-header">
            <h3>Update Security</h3>
            <p class="sc-modal-subtitle">Set a new password for your account</p>
        </div>
        <div class="sc-modal-body">
            <form id="change-password-form">
                <div class="sc-input-group">
                    <label class="sc-input-label">New Password</label>
                    <input type="password" id="new-password" name="new_password" class="sc-input"
                        placeholder="Min. 8 characters" required>
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Confirm Password</label>
                    <input type="password" id="confirm-password" class="sc-input"
                        placeholder="Confirm your new password" required>
                </div>
                <div id="password-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-pass-submit">
                    Set New Password
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Modal Base Styles */
.sc-modal {
    position: fixed;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.sc-modal.active {
    display: flex;
}

.sc-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.sc-modal-box {
    background: #fff;
    width: 100%;
    max-width: 480px;
    position: relative;
    border-radius: 28px;
    padding: 60px;
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(201, 168, 76, 0.2);
    transform: translateY(30px);
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.sc-modal.active .sc-modal-box {
    transform: translateY(0);
    opacity: 1;
}

.sc-modal-header {
    text-align: center;
    margin-bottom: 40px;
}

.sc-modal-header h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: #8B1A1A;
    margin-bottom: 8px;
}

.sc-modal-subtitle {
    color: #64748b;
    font-size: 0.95rem;
}

.sc-modal-close {
    position: absolute;
    top: 25px;
    right: 30px;
    background: none;
    border: none;
    font-size: 2rem;
    color: #94a3b8;
    cursor: pointer;
    transition: 0.3s;
    line-height: 1;
}

.sc-modal-close:hover {
    color: #c9a84c;
    transform: rotate(90deg);
}

.sc-input-group {
    margin-bottom: 30px;
    text-align: left;
}

.sc-input-label {
    display: block;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 12px;
    color: #8B1A1A;
}

.sc-input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #f1f1f1;
    padding: 12px 0;
    font-size: 1.1rem;
    outline: none;
    background: transparent;
    font-family: 'Nunito', sans-serif;
    transition: all 0.3s;
}

.sc-input:focus {
    border-bottom-color: #8B1A1A;
}

.btn-sc-submit {
    width: 100%;
    background: #8B1A1A;
    color: #fff;
    border: none;
    padding: 18px;
    border-radius: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.9rem;
    transition: 0.3s;
    cursor: pointer;
    box-shadow: 0 10px 20px rgba(139, 26, 26, 0.2);
}

.btn-sc-submit:hover {
    background: #5c1010;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(139, 26, 26, 0.3);
}

/* Auth Buttons */
.btn-auth-trigger {
    background-color: #8B1A1A;
    color: #fff;
    border: 1px solid #8B1A1A;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-auth-trigger:hover {
    background-color: #5c1010;
    color: #fff;
    border-color: #5c1010;
    sc-modal-subtitle
}

.btn-auth-logout {
    background-color: #fff;
    color: #dc3545;
    border: 1px solid #dc3545;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-auth-logout:hover {
    background-color: #dc3545;
    color: #fff;
}
</style>

<script>
function toggleModal(id, show) {
    const modal = document.getElementById(id);
    if (show) modal.classList.add('active');
    else modal.classList.remove('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const mediaBase = "<?= $media_base ?>";
    const apiBase = isLocal ? 'http://localhost:8001/api/v1/' : `${mediaBase}/api/v1/`;
    const authApiBase = apiBase.replace('/api/v1/', '');
    let firstLoginOldPassword = '';
    let firstLoginUsername = '';

    // Handle Login Submit
    const loginForm = document.getElementById('staff-login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(e.target).entries());
            const loginError = document.getElementById('login-error');
            loginError.classList.add('d-none');

            try {
                const res = await fetch(`${authApiBase}/portal/api/login/`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                const resData = await res.json();

                if (res.ok) {
                    if (resData.force_password_change) {
                        firstLoginOldPassword = data.password;
                        firstLoginUsername = data.username;
                        toggleModal('login-modal', false);
                        toggleModal('password-modal', true);
                        return;
                    }

                    localStorage.setItem('portal_user', data.username);
                    toggleModal('login-modal', false);
                    document.dispatchEvent(new Event('portalAuthStatusChanged'));
                } else {
                    loginError.textContent = resData.detail || "Login failed.";
                    loginError.classList.remove('d-none');
                }
            } catch (i) {
                loginError.textContent = "Network error. Please try again.";
                loginError.classList.remove('d-none');
            }
        });
    }

    // Handle Password Change Submit
    const passForm = document.getElementById('change-password-form');
    if (passForm) {
        passForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newPass = document.getElementById('new-password').value;
            const confirmPass = document.getElementById('confirm-password').value;
            const passError = document.getElementById('password-error');
            passError.classList.add('d-none');

            if (newPass !== confirmPass) {
                passError.textContent = "Passwords do not match.";
                passError.classList.remove('d-none');
                return;
            }


            try {
                const res = await fetch(`${authApiBase}/portal/api/change-password/`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        old_password: firstLoginOldPassword,
                        new_password: newPass,
                        confirm_password: confirmPass
                    })
                });

                if (res.ok) {
                    firstLoginOldPassword = '';
                    localStorage.setItem('portal_user', firstLoginUsername);

                    toggleModal('password-modal', false);
                    document.dispatchEvent(new Event('portalAuthStatusChanged'));
                } else {
                    const data = await res.json();
                    passError.textContent = JSON.stringify(data);
                    passError.classList.remove('d-none');
                }
            } catch (err) {
                passError.textContent = "Network error.";
                passError.classList.remove('d-none');
            }
        });
    }

    // Handle Global Logout
    document.addEventListener('click', function(e) {
        if (e.target.matches('.btn-auth-logout') || e.target.closest('.btn-auth-logout')) {
            fetch(`${authApiBase}/portal/logout/`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'X-CSRFToken': document.cookie.split('; ').find(row => row.startsWith('csrftoken='))?.split('=')[1] || ''
                }
            }).finally(() => {
                localStorage.removeItem('portal_user');
                document.dispatchEvent(new Event('portalAuthStatusChanged'));
            });
        }
        if (e.target.matches('.btn-auth-trigger') || e.target.closest('.btn-auth-trigger')) {
            toggleModal('login-modal', true);
        }
    });
});
</script>
