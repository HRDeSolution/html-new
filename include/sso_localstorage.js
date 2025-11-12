/**
 * SSO LocalStorage Token Manager
 * Aligns legacy site with html-solution SSO flow.
 */
const SSOTokenManager = {
    TOKEN_KEY: 'jwt',
    PAYLOAD_KEY: 'jwt_payload',
    EXPIRES_KEY: 'jwt_expires',
    LEGACY_TOKEN_KEY: 'hrde_sso_token',
    LEGACY_PAYLOAD_KEY: 'hrde_sso_payload',
    LEGACY_EXPIRES_KEY: 'hrde_sso_expires',

    init() {
        const isLoggedIn = this.checkLoginStatus();

        if (isLoggedIn) {
            const token = this.getToken();

            if (!token || this.isTokenExpired()) {
                this.generateAndStoreToken();
            } else {
                this.checkTokenRefresh();
            }
        } else {
            this.clearToken();
        }
    },

    checkLoginStatus() {
        const userElement = document.querySelector('[data-user-id]');
        if (userElement !== null) {
            return true;
        }

        if (window.__HRDE_SSO_USER_ID) {
            return true;
        }

        return false;
    },

    generateAndStoreToken() {
        fetch('/public/member/sso_token_generator.php', {
            method: 'GET',
            credentials: 'include',
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    localStorage.setItem(this.TOKEN_KEY, data.token);
                    localStorage.setItem(this.PAYLOAD_KEY, JSON.stringify(data.payload));
                    localStorage.setItem(this.EXPIRES_KEY, data.expires_at);

                    localStorage.setItem(this.LEGACY_TOKEN_KEY, data.token);
                    localStorage.setItem(this.LEGACY_PAYLOAD_KEY, JSON.stringify(data.payload));
                    localStorage.setItem(this.LEGACY_EXPIRES_KEY, data.expires_at);

                    const expiresDate = new Date(data.expires_at);
                    const maxAge = Math.floor((expiresDate - new Date()) / 1000);

                    document.cookie = `jwt=${data.token}; domain=.hrdeedu.co.kr; path=/; max-age=${maxAge}; samesite=lax`;
                    document.cookie = `jwt_payload=${encodeURIComponent(JSON.stringify(data.payload))}; domain=.hrdeedu.co.kr; path=/; max-age=${maxAge}; samesite=lax`;
                    document.cookie = `jwt_expires=${data.expires_at}; domain=.hrdeedu.co.kr; path=/; max-age=${maxAge}; samesite=lax`;

                    window.dispatchEvent(
                        new CustomEvent('ssoTokenReady', {
                            detail: { token: data.token, payload: data.payload },
                        })
                    );
                } else {
                    console.error('[SSO] Token generation failed:', data.error);
                }
            })
            .catch((error) => {
                console.error('[SSO] Error generating token:', error);
            });
    },

    getToken() {
        let token = localStorage.getItem(this.TOKEN_KEY);

        if (!token) {
            token = this.getCookie('jwt');
        }

        return token;
    },

    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }
        return null;
    },

    getPayload() {
        const payloadStr = localStorage.getItem(this.PAYLOAD_KEY);
        return payloadStr ? JSON.parse(payloadStr) : null;
    },

    isTokenExpired() {
        const payload = this.getPayload();
        if (!payload || !payload.exp) {
            return true;
        }

        const now = Math.floor(Date.now() / 1000);
        return now >= payload.exp;
    },

    checkTokenRefresh() {
        const payload = this.getPayload();
        if (!payload || !payload.exp) {
            return;
        }

        const now = Math.floor(Date.now() / 1000);
        const expiresIn = payload.exp - now;
        const oneDayInSeconds = 24 * 60 * 60;

        if (expiresIn < oneDayInSeconds) {
            this.generateAndStoreToken();
        }
    },

    clearToken() {
        localStorage.removeItem(this.TOKEN_KEY);
        localStorage.removeItem(this.PAYLOAD_KEY);
        localStorage.removeItem(this.EXPIRES_KEY);
        localStorage.removeItem(this.LEGACY_TOKEN_KEY);
        localStorage.removeItem(this.LEGACY_PAYLOAD_KEY);
        localStorage.removeItem(this.LEGACY_EXPIRES_KEY);

        document.cookie = 'jwt=; domain=.hrdeedu.co.kr; path=/; max-age=0';
        document.cookie = 'jwt_payload=; domain=.hrdeedu.co.kr; path=/; max-age=0';
        document.cookie = 'jwt_expires=; domain=.hrdeedu.co.kr; path=/; max-age=0';
    },

    goToLiveSite(openHandler) {
        const token = this.getToken();

        if (!token) {
            alert('SSO 토큰이 없습니다. 다시 로그인해주세요.');
            return;
        }

        if (this.isTokenExpired()) {
            alert('SSO 토큰이 만료되었습니다. 페이지를 새로고침해주세요.');
            return;
        }

        const targetUrl = 'https://live.hrdeedu.co.kr';

        if (typeof openHandler === 'function') {
            openHandler(targetUrl);
        } else {
            window.open(targetUrl, 'hrdeLive');
        }
    },

    getTokenInfo() {
        const token = this.getToken();
        const payload = this.getPayload();
        const expires = localStorage.getItem(this.EXPIRES_KEY);

        return {
            hasToken: !!token,
            payload,
            expiresAt: expires,
            isExpired: this.isTokenExpired(),
        };
    },
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        SSOTokenManager.init();
    });
} else {
    SSOTokenManager.init();
}

window.addEventListener('beforeunload', () => {
    SSOTokenManager.checkTokenRefresh();
});

window.SSOTokenManager = SSOTokenManager;

