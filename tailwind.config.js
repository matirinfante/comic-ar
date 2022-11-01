const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
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
            'animation': {
                'text':'text 5s ease infinite',
            },
            'keyframes': {
                'text': {
                    '0%, 100%': {
                       'background-size':'200% 200%',
                        'background-position': 'left center'
                    },
                    '50%': {
                       'background-size':'200% 200%',
                        'background-position': 'right center'
                    }
                },
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
