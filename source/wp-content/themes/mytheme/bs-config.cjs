const { resolve } = require("path");
const dotenv = require("dotenv");
const findWorkspaceRoot = require("find-yarn-workspace-root");

const root = findWorkspaceRoot(__dirname) || "./";

dotenv.config({ path: resolve(root, "./.env") });

const { PROXY_URL, WP_PORT } = process.env;

module.exports = {
  ui: false,
  files: [`**/*.php`, `dist/**/*`, `theme.json`],
  proxy: PROXY_URL || `http://localhost:${WP_PORT}`,
  ghostMode: false,
  open: false,
  notify: false,
};
