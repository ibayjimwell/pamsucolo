const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'pamsucolo-primary': '#f89458',
                'pamsucolo-bg': '#fefefe', 
                'pamsucolo-text': '#333333', 
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
