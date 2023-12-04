module.exports = (ctx) => {
  const inProduction = process.env.NODE_ENV === "production"

  return {
    map: ctx.options.map,
    plugins: {
      "postcss-easy-import": {},
      "postcss-url": { filter: "**/_inline/*", url: "inline" },
      "postcss-preset-env": {
        stage: 2,
        features: { "nesting-rules": true, "custom-properties": false },
      },
      "postcss-sort-media-queries": {},
      ...(inProduction
        ? { cssnano: { preset: ["default", { calc: false }] } }
        : null),
    },
  }
}
