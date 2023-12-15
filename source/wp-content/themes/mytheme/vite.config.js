import { defineConfig } from "vite"
import { pluginImage, pluginReload } from "./src/_lib/vitePlugins.js"

/**
 * @see https://ja.vitejs.dev/config/
 */
export default defineConfig(({ mode }) => {
  const { VITE_SERVER_OPEN, WP_PORT, WP_ENTRY } = process.env

  /**
   * "editor" asset config (build only)
   */
  if (mode === "production" && WP_ENTRY === "editor") {
    return {
      publicDir: "src/static",
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
   * "main" assets config
   */
  return {
    publicDir: "src/static",
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
