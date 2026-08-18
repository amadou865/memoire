import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': {
                    DEFAULT: '#0A1B2E',    // Bleu marine foncé
                    50: '#E6EAF0',
                    100: '#B3BDD1',
                    200: '#8090B2',
                    300: '#4D6393',
                    400: '#1A3674',
                    500: '#0A1B2E',
                    600: '#081525',
                    700: '#06101C',
                    800: '#040B13',
                    900: '#02060A',
                    'light': '#132B47',    // Bleu marine clair
                },
                'accent': {
                    DEFAULT: '#F97316',    // Orange vif
                    50: '#FEF3E7',
                    100: '#FDE0BB',
                    200: '#FCC98B',
                    300: '#FBB25B',
                    400: '#FA9B2B',
                    500: '#F97316',        // Orange principal
                    600: '#EA580C',        // Orange hover
                    700: '#C2410C',
                    800: '#9A3412',
                    900: '#7C2D12',
                },
                'success': '#10B981',       // Vert (créneaux dispo)
                'success-light': '#D1FAE5', // Vert clair
            },
        },
    },

    plugins: [forms],
};