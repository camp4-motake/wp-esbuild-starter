import { existsSync } from "fs";
import { resolve } from "path";
import { defineConfig } from "vite";
import FullReload from "vite-plugin-full-reload";
import dotenv from "dotenv";

const root = existsSync("../../package.json") ? "../../" : "./";
const nodeModules = resolve(__dirname, root, "node_modules");
const envFile = resolve(process.cwd(), "../../.env");
const port = { wp: process.env.LOCAL_SERVER_PORT || 8888 };

dotenv.config({ path: envFile || undefined });

/**
 * vite config
 * @see https://ja.vitejs.dev/config/
 */
export default defineConfig({
  plugins: [FullReload(["**/*.{php,twig}", "theme.json"])],
  // logLevel: "warn",
  server: {
    host: "0.0.0.0",
    strictPort: true,
  },
  base: "./",
  publicDir: false,
  cacheDir: resolve(nodeModules, "./.vite"),
  build: {
    emptyOutDir: false,
    manifest: true,
    outDir: "dist",
    assetsDir: ".",
    rollupOptions: {
      input: {
        main: "src/main.ts",
        editor: "src/editor.ts",
      },
    },
  },
  resolve: {
    alias: [{ find: /~(.+)/, replacement: resolve(nodeModules, "./$1") }],
  },
});
