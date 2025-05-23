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
                'primary': '#ff8c00',
                'secondary': '#003366',
                'light': '#f8f9fa',
                'dark': '#343a40',
                'orange': {
                    '50': '#fff8f0',
                    '100': '#ffebd6',
                    '200': '#ffd4a8',
                    '300': '#ffb86b',
                    '400': '#ff8c00',
                    '500': '#f97d00',
                    '600': '#e66a00',
                    '700': '#c24e00',
                    '800': '#9a3e02',
                    '900': '#7e3509',
                },
                'blue': {
                    '50': '#f0f7ff',
                    '100': '#e0effe',
                    '200': '#b9deff',
                    '300': '#7cc4ff',
                    '400': '#36a0ff',
                    '500': '#0c7ae3',
                    '600': '#005fcc',
                    '700': '#004ba8',
                    '800': '#003f8a',
                    '900': '#003366',
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
