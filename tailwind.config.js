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
                'secondary': '#8EBA54',
                'tertiary': '#8EBA54',
                'quaternary': '#8EBA54',
                'quinary': '#8EBA54',
                'senary': '#8EBA54',
                'septenary': '#8EBA54',
                'octonary': '#8EBA54',
                'nonary': '#8EBA54',
                'denary': '#8EBA54',
                'undenary': '#8EBA54',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
