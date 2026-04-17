import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                hijauToska: "#00CBB8",
                biruNavy: "#2F327D",
                orange: "#F48C06",
                unguTua: "#5B2C89",
                abuabuSedang: "#696984",
                abuabuCerah: "#B2B3CF",
                biruMariana: "#252641",
                biruCerah: "#9DCCFF",
                biruLangit: "#5B72EE",
                biruTelurAsin: "#29B9E7",
                "primary-gradient": "linear-gradient(to right, #922B80, #5B2C89)",
                "secondary-gradient": "linear-gradient(to right, #6fcae3, #216e7f)",
            },

            backgroundImage: {
                "primary-gradient": "linear-gradient(to right, #922B80, #5B2C89)",
                "secondary-gradient": "linear-gradient(to right, #6fcae3, #216e7f)",
            },
        },
    },

    plugins: [forms],
};
