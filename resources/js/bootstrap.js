import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add CSRF token to all requests
const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Add authorization header if user is authenticated
const authToken = document.head.querySelector('meta[name="auth-token"]');
if (authToken) {
  window.axios.defaults.headers.common['Authorization'] = `Bearer ${authToken.content}`;
}

// Request interceptor
window.axios.interceptors.request.use(
  config => {
    // Add loading indicator
    if (config.showLoading !== false) {
      document.body.classList.add('loading');
    }
    return config;
  },
  error => {
    document.body.classList.remove('loading');
    return Promise.reject(error);
  }
);

// Response interceptor
window.axios.interceptors.response.use(
  response => {
    document.body.classList.remove('loading');
    return response;
  },
  error => {
    document.body.classList.remove('loading');

    // Handle common errors
    if (error.response) {
      const { status, data } = error.response;

      switch (status) {
        case 401:
          // Unauthorized - redirect to login
          window.location.href = '/login';
          break;
        case 403:
          // Forbidden
          console.error('Forbidden: You do not have permission to perform this action.');
          break;
        case 422:
          // Validation errors
          if (data.errors) {
            const firstError = Object.values(data.errors)[0];
            if (firstError) {
              console.error('Validation error:', Array.isArray(firstError) ? firstError[0] : firstError);
            }
          }
          break;
        case 500:
          // Server error
          console.error('Server error: Something went wrong. Please try again later.');
          break;
        default:
          if (data.message) {
            console.error('Error:', data.message);
          }
      }
    } else if (error.request) {
      // Network error
      console.error('Network error: Please check your connection.');
    }

    return Promise.reject(error);
  }
);

// Global error handler
window.addEventListener('unhandledrejection', event => {
  console.error('Unhandled promise rejection:', event.reason);
});

// Global error handler for JavaScript errors
window.addEventListener('error', event => {
  console.error('JavaScript error:', event.error);
});

// Echo configuration (optional - only if using real-time features)
// Uncomment and configure when you want to use real-time messaging
/*
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST,
    wsPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    disableStats: true,
});
*/
