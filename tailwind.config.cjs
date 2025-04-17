module.exports = {
  mode: 'jit',
  content: [
    "./src/**/*.js",
    './src/js/render.js',
    './views/**/*.html.php', // Include all PHP view files
    './src/css/**/*.css',    // Include all CSS files
    './src/js/**/*.js',      // Include all JavaScript files
    './controllers/**/*.php', // Include PHP controllers
    './includes/**/*.php',   // Include PHP includes
  ],
  safelist: [
    {
      pattern: /^(bg|text)-(red|blue|green|yellow|purple|pink|indigo|gray|slate|orange|emerald|cyan)-(100|200|300|400|500|600|700|800|900)$/,
    },
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};