// https://github.com/svg/svgo
module.exports = {
  plugins: [
    'preset-default',
    // 'prefixIds',
    {
      name: 'sortAttrs',
      params: {
        xmlnsOrder: 'alphabetical',
      },
    },
  ],
};
