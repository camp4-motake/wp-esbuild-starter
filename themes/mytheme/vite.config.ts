import { existsSync } from "fs";
import { resolve } from "path";
import { defineConfig } from "vite";
import FullReload from "vite-plugin-full-reload";

const root = existsSync("../../package.json") ? "../../" : "./";
const nodeModules = resolve(__dirname, root, "node_modules");

// https://ja.vitejs.dev/config/
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
