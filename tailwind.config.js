module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    theme: {
        extend: {
            backgroundColor: theme => ({
                'title': '#e3e7ec'
            }),
            textColor: theme => ({
                'title': '#3b4754',
                'subtitle': '#798da3'
            }),
            boxShadow: theme => ({
                'title': '5px 5px 15px -2px #000000'
            })
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
