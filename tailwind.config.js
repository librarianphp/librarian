module.exports = {
    content: [
        './app/Resources/themes/**/*.html.twig',
        './app/Resources/css/**/*.css',
    ],
  darkMode: 'media',
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
