/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/views/**/*.blade.php'
  ],
  theme: {
    extend: {
      colors: {
        // Brand palette (sync with resources/css/apni-theme-tokens.css)
        apni: {
          gulf: '#041C54',
          heather: '#BAC2D2',
          lynch: '#647494',
          bermuda: '#7484A4',
          success: '#10B981',
          warning: '#F59E0B',
          danger: '#EF4444',
          info: '#3B82F6',
          purple: '#8B5CF6',
          pink: '#EC4899',
          cyan: '#06B6D4'
        },
        // Tailwind "primary" mapped to Apni Psychology (Lynch + Gulf)
        primary: {
          50: '#f4f6f9',
          100: '#e8ecf2',
          200: '#d5dce8',
          300: '#BAC2D2',
          400: '#9aa8bc',
          500: '#7484A4',
          600: '#647494',
          700: '#4d5d78',
          800: '#041C54',
          900: '#031340',
          950: '#020c2b'
        },
        // Positive / success accent (#10B981)
        secondary: {
          50: '#ecfdf5',
          100: '#d1fae5',
          200: '#a7f3d0',
          300: '#6ee7b7',
          400: '#34d399',
          500: '#10B981',
          600: '#059669',
          700: '#047857',
          800: '#065f46',
          900: '#064e3b',
          950: '#022c22'
        },
        accent: {
          50: '#fffbeb',
          100: '#fef3c7',
          200: '#fde68a',
          300: '#fcd34d',
          400: '#fbbf24',
          500: '#f59e0b',
          600: '#d97706',
          700: '#b45309',
          800: '#92400e',
          900: '#78350f',
          950: '#451a03'
        },
        gray: {
          50: '#f9fafb',
          100: '#f3f4f6',
          200: '#e5e7eb',
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
          600: '#4b5563',
          700: '#374151',
          800: '#1f2937',
          900: '#111827',
          950: '#030712'
        }
      },
      fontFamily: {
        sans: ['var(--apni-font-body)', 'Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['var(--apni-font-display)', 'Sora', 'ui-sans-serif', 'system-ui', 'sans-serif']
      },
      spacing: {
        18: '4.5rem',
        88: '22rem',
        128: '32rem'
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'bounce-slow': 'bounce 2s infinite'
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        },
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        }
      }
    }
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')]
};
