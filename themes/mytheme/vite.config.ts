import { existsSync } from "fs";
import { resolve } from "path";
import { defineConfig } from "vite";
import FullReload from "vite-plugin-full-reload";
import dotenv from "dotenv";

const root = existsSync("../../package.json") ? "../../" : "./";
const nodeModules = resolve(__dirname, root, "node_modules");
const envFile = resolve(process.cwd(), "../../.env");
dotenv.config({ path: envFile || undefined });

const { LOCAL_URL, LOCAL_SERVER_PORT, IS_OPEN } = process.env;
let open: string | boolean = false;

if (IS_OPEN !== "false") {
  open =
    LOCAL_URL ||
    (LOCAL_SERVER_PORT ? `http://localhost:${LOCAL_SERVER_PORT}` : false);
}

// https://ja.vitejs.dev/config/
export default defineConfig({
  plugins: [FullReload(["**/*.{php,twig}", "theme.json"])],
  // logLevel: "warn",
  server: { strictPort: true, open },
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
