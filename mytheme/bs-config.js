/**
 * Browsersync options
 * https://browsersync.io/docs/options
 */
const path = require('path');
const httpProxy = require('http-proxy');
const dotenv = require('dotenv');
const proxy = httpProxy.createProxyServer();
const envFile = path.resolve(process.cwd(), '../.env');
dotenv.config({ path: envFile || null });

const port = {
  wp: process.env.LOCAL_SERVER_PORT || 5000,
  vite: 3000,
};

module.exports = {
  files: ['**/*.{php,twig}', 'theme.json'],
  ghostMode: false,
  ignore: ['node_modules'],
  notify: false,
  open: false,
  port: 8080,
  ui: false,
  proxy: {
    target: process.env.PROXY_URL || `http://localhost:${port.wp}`,

    // proxy vite dev server assets
    middleware: ['/src', '/@vite', '/@fs'].map((route) => ({
      route: route,
      handle: (req, res) => {
        proxy.web(req, res, {
          target: `http://localhost:${port.vite}${route}`,
        });
      },
    })),
  },
};
