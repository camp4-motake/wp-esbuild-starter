export default () => ({
  plugins: {
    // WORKAROUND https://github.com/csstools/postcss-plugins/tree/main/plugins/postcss-global-data#readme
    "@csstools/postcss-global-data": {
      files: ["./src/styles/config/custom-media.css"],
    },
    "postcss-url": { filter: "**/_inline/*", url: "inline" },
    "postcss-preset-env": { stage: 2, features: { "nesting-rules": true } },
    "postcss-sort-media-queries": {},
  },
})
