const inProduction = process.env.NODE_ENV === "production";

module.exports = {
  plugins: {
    "postcss-import": {},
    "postcss-preset-env": {
      stage: 2,
      autoprefixer: { grid: "autoplace" },
      features: {
        "custom-properties": false,
        "nesting-rules": true,
      },
    },
    "postcss-url": { filter: "**/_inline/*", url: "inline" },
    "postcss-sort-media-queries": {},
    ...(inProduction ? { cssnano: { preset: "default" } } : null),
  },
};
