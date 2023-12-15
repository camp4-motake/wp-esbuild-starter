import { defineConfig } from "vite"
import { pluginImage, pluginReload } from "./src/_lib/vitePlugins.js"

const { VITE_SERVER_OPEN, WP_PORT, WP_ENTRY } = process.env

/**
 * @see https://ja.vitejs.dev/config/
 */
export default defineConfig(({ mode }) => {
  /**
   * editor (build only)
   */
  if (mode === "production" && WP_ENTRY === "editor") {
    return {
      build: {
        outDir: "dist",
        assetsDir: "",
        emptyOutDir: false,
        manifest: ".vite/manifest.editor.json",
        rollupOptions: { input: { editor: "src/editor.ts" } },
      },
    }
  }

  /**
   * main
   */
  return {
    build: {
      outDir: "dist",
      assetsDir: "",
      emptyOutDir: true,
      manifest: ".vite/manifest.main.json",
      rollupOptions: { input: { main: "src/main.ts" } },
    },

    server: { open: VITE_SERVER_OPEN || `http://localhost:${WP_PORT}` },

    plugins: [
      pluginImage(["./src/images/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]),
      pluginReload(["**/*.php", "dist/images/**/*"]),
    ],
  }
})
