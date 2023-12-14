import { defineConfig } from "vite"
import { pluginImage, pluginReload } from "./src/_lib/vitePlugins.js"

const { VITE_SERVER_OPEN, WP_PORT } = process.env

// https://ja.vitejs.dev/config/
export default defineConfig({
  build: {
    outDir: "dist",
    assetsDir: "",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: "src/main.ts",
        editor: "src/editor.ts",
      },
    },
  },

  server: { open: VITE_SERVER_OPEN || `http://localhost:${WP_PORT}` },

  plugins: [
    pluginImage(["./src/images/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]),
    pluginReload(["**/*.php", "dist/images/**/*"]),
  ],
})
