export default () => ({
  plugins: {
    "@csstools/postcss-global-data": {
      files: ["./src/styles/config/custom-media.css"],
    },
    "postcss-url": { filter: "**/_inline/*", url: "inline" },
    "postcss-preset-env": { stage: 2, features: { "nesting-rules": true } },
    "postcss-sort-media-queries": {},
  },
})
