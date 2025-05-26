import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                'primary': '#FF6B00',
                'secondary': '#1a1a1a',
                'light': '#f8f9fa',
                'dark': '#1a1a1a',
                'orange': {
                    '50': '#fff8f0',
                    '100': '#ffebd6',
                    '200': '#ffd4a8',
                    '300': '#ffb86b',
                    '400': '#FF6B00',
                    '500': '#e66100',
                    '600': '#cc5600',
                    '700': '#b34c00',
                    '800': '#994100',
                    '900': '#803600',
                },
                'gray': {
                    '50': '#f9f9f9',
                    '100': '#f2f2f2',
                    '200': '#e6e6e6',
                    '300': '#d9d9d9',
                    '400': '#bfbfbf',
                    '500': '#8c8c8c',
                    '600': '#737373',
                    '700': '#595959',
                    '800': '#404040',
                    '900': '#1a1a1a',
                },
            },
            fontFamily: {
                sans: ['Arial', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
            boxShadow: {
                'lg': '0 5px 15px rgba(0, 0, 0, 0.1)',
                'xl': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            },
            animation: {
                'fadeIn': 'fadeIn 0.3s ease-in-out',
                'slideDown': 'slideDown 0.3s ease-in-out',
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
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
