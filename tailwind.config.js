import preset from "./vendor/filament/support/tailwind.config.preset";
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
    ],
    darkMode: 'class',
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            colors: {
                primary: {
                    50: '#fff8f0',
                    100: '#ffebd6',
                    200: '#ffd4a8',
                    300: '#ffb86b',
                    400: '#FF6B00', // Couleur principale RHDP
                    500: '#e66100',
                    600: '#cc5600',
                    700: '#b34c00',
                    800: '#994100',
                    900: '#803600',
                    DEFAULT: '#FF6B00',
                },
                secondary: {
                    DEFAULT: '#1a1a1a',
                    ...colors.gray,
                },
                dark: {
                    DEFAULT: '#1a1a1a',
                },
                light: {
                    DEFAULT: '#f8f9fa',
                },
                accent: {
                    DEFAULT: '#ff8c00',
                },
                success: colors.green,
                danger: colors.red,
                warning: colors.amber,
                info: colors.blue,
            },
            fontFamily: {
                sans: ['Poppins', 'Arial', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
                heading: ['Poppins', 'sans-serif'],
            },
            fontSize: {
                'xs': '0.75rem',     // 12px
                'sm': '0.875rem',    // 14px
                'base': '1rem',      // 16px
                'lg': '1.125rem',    // 18px
                'xl': '1.25rem',     // 20px
                '2xl': '1.5rem',     // 24px
                '3xl': '1.875rem',   // 30px
                '4xl': '2.25rem',    // 36px
                '5xl': '3rem',       // 48px
                '6xl': '3.75rem',    // 60px
            },
            spacing: {
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
                '128': '32rem',
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'DEFAULT': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
                'none': 'none',
            },
            borderRadius: {
                'none': '0',
                'sm': '0.125rem',
                'DEFAULT': '0.25rem',
                'md': '0.375rem',
                'lg': '0.5rem',
                'xl': '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
                'full': '9999px',
            },
            zIndex: {
                '0': 0,
                '10': 10,
                '20': 20,
                '30': 30,
                '40': 40,
                '50': 50,
                'auto': 'auto',
            },
            animation: {
                'fadeIn': 'fadeIn 0.3s ease-in-out',
                'slideDown': 'slideDown 0.3s ease-in-out',
                'pulse': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'bounce': 'bounce 1s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideDown: {
                    '0%': { transform: 'translateY(-10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                pulse: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '.5' },
                },
                bounce: {
                    '0%, 100%': {
                        transform: 'translateY(-25%)',
                        animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)',
                    },
                    '50%': {
                        transform: 'translateY(0)',
                        animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)',
                    },
                },
            },
            transitionProperty: {
                'none': 'none',
                'all': 'all',
                'DEFAULT': 'background-color, border-color, color, fill, stroke, opacity, box-shadow, transform',
                'colors': 'background-color, border-color, color, fill, stroke',
                'opacity': 'opacity',
                'shadow': 'box-shadow',
                'transform': 'transform',
            },
            transitionDuration: {
                'DEFAULT': '150ms',
                '75': '75ms',
                '100': '100ms',
                '150': '150ms',
                '200': '200ms',
                '300': '300ms',
                '500': '500ms',
                '700': '700ms',
                '1000': '1000ms',
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active', 'group-hover', 'responsive'],
            borderColor: ['active', 'group-hover', 'responsive'],
            boxShadow: ['active', 'group-hover', 'responsive'],
            opacity: ['disabled', 'group-hover', 'hover'],
            textColor: ['active', 'group-hover', 'responsive'],
            translate: ['group-hover', 'hover'],
            scale: ['group-hover', 'hover'],
            rotate: ['group-hover', 'hover'],
        },
    },
    corePlugins: {
        // Désactiver les styles de base
        preflight: true,
    },
    plugins: [
        require('@tailwindcss/forms')({
            strategy: 'class', // Utilisez la stratégie de classe pour éviter les conflits
        }),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
