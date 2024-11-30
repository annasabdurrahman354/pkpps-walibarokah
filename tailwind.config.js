/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'
const defaultTheme = require('tailwindcss/defaultTheme');
export default {
    darkMode: 'selector',
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/bezhansalleh/filament-exceptions/resources/views/**/*.blade.php',
        './vendor/awcodes/filament-quick-create/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                messiri: ['"El Messiri"', ...defaultTheme.fontFamily.sans],
                inter: ['"Inter"', ...defaultTheme.fontFamily.sans],
                cookie: ['"Cookie"', ...defaultTheme.fontFamily.sans],
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
