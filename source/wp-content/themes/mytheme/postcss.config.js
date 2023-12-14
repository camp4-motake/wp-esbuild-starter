export default () => ({
  plugins: {
    "postcss-url": { filter: "**/_inline/*", url: "inline" },
    "postcss-preset-env": { stage: 2, features: { "nesting-rules": true } },
    "postcss-sort-media-queries": {},
  },
})
