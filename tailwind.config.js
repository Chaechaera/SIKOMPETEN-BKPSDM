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
                hijauBening: "#DEFFE2",
                hijauDaun: "#157667",
                hijauTua: "#01483D",
                biruNavy: "#2F327D",
                orangeBening: "#FFE7C9",
                orange: "#F48C06",
                orangeMuda: "#FFA736",
                unguTua: "#5B2C89",
                unguSedang: "#58036F",
                unguMuda: "#E9E1FF",
                abuabuSedang: "#696984",
                abuabuCerah: "#B2B3CF",
                abuabuMuda: "#D9D9D9",
                abuabuGelap: "#868FA0",
                biruMariana: "#252641",
                biruCerah: "#9DCCFF",
                biruLangit: "#5B72EE",
                biruTelurAsin: "#29B9E7",
                coklat: "#6C430F",
                merahBening: "#FFDEDF",
                merahCabai: "#FF0000",
                merahMaroon: "#A80000",
                merahBata: "#AA5252",
            },

            backgroundImage: {
                "primary-gradient": "linear-gradient(to right, #922B80, #5B2C89)",
                "secondary-gradient": "linear-gradient(to right, #6fcae3, #216e7f)",
            },
        },
    },

    plugins: [forms],
};
