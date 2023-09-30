import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Roboto", ...defaultTheme.fontFamily.sans],
            },
            screens: {
                "-2xl": { max: "1535px" },
                // => @media (max-width: 1536px) { ... }
                "-xl": { max: "1279px" },
                // => @media (max-width: 1279px) { ... }
                "-lg": { max: "1023px" },
                // => @media (max-width: 1023px) { ... }
                "-md": { max: "769px" },
                // => @media (max-width: 769px) { ... }
                "-sm": { max: "639px" },
                // => @media (max-width: 639px) { ... }
            },
            colors: {
                accent: "#D93232",
                "accent-hover": "#d84444",
                secondary: "#412F3B",
                "bg-black-opacity-50": "rgba(0, 0, 0, 0.5)",
                "dark-blue": "#0c0c1f",
            },
        },
    },

    plugins: [forms],
};
