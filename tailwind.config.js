/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#8EBA54',
                'secondary': '#C6D154',
                'tertiary': '#6FD154',
                'quaternary': '#50C75C',
                'quinary': '#C7BE50',
                'senary': '#f5f5f5',
                'septenary': '#f5f5f5',
                'octonary': '#f5f5f5',
                'nonary': '#f5f5f5',
                'denary': '#f5f5f5',
                'undenary': '#f5f5f5',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
