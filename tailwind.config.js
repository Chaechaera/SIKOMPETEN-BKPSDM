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
                hijauMint: "#E8FBE8",
                hijauBening: "#DEFFE2",
                hijauDaun: "#157667",
                hijauTua: "#01483D",
                hijauGreen: "#004B3F",
                hijauTransparan: "#EBFEFE",
                biruNavy: "#2F327D",
                kuningBening: "#FFF0DD",
                orangeBening: "#FFE7C9",
                orange: "#F48C06",
                orangeMuda: "#FFA736",
                unguBening: "#FDEBF9",
                unguTua: "#5B2C89",
                unguSedang: "#58036F",
                unguMuda: "#E9E1FF",
                unguTransparan: "#F1EBFE",
                unguBening: "#FFE6FC",
                abuabuSedang: "#696984",
                abuabuCerah: "#B2B3CF",
                abuabuMuda: "#D9D9D9",
                abuabuGelap: "#868FA0",
                abuabuBesi: "#ACACAC",
                abuabuDark: "#757575",
                abuabuKoin: "#F3F3F3",
                biruMariana: "#252641",
                biruCerah: "#9DCCFF",
                biruLangit: "#5B72EE",
                biruTelurAsin: "#29B9E7",
                biruMuda: "#F0F7FF",
                biruGelap: "#CFE4FC",
                biruBlue: "#0660FE",
                biruDark: "#2F327D",
                coklat: "#6C430F",
                coklatGelap: "#502D00",
                coklatMuda: "#825C2A",
                merahBening: "#FFDEDF",
                merahCabai: "#FF0000",
                merahMaroon: "#A80000",
                merahBata: "#AA5252",
                hitamSedang: "#040404",
            },

            backgroundImage: {
                "primary-gradient": "linear-gradient(to right, #922B80, #5B2C89)",
                "secondary-gradient": "linear-gradient(to right, #6fcae3, #216e7f)",
            },
        },
    },

    plugins: [forms],
};
