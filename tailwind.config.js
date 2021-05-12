module.exports = {
    purge: [
        './app/Resources/themes/**/**/*.html.twig',
    ],
  darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        "code::before": false,
                        "code::after": false,
                        "blockquote p:first-of-type::before": false,
                        "blockquote p:last-of-type::after": false,
                    },
                },
            },
        }
    },
  variants: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/typography'),
  ]
}
