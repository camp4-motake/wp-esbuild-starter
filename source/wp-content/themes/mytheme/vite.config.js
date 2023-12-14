import { defineConfig } from "vite"
import { pluginImage, pluginReload } from "./src/_lib/vitePlugins.js"
import postcssConfig from "./postcss.config.js"

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

  server: {
    open:
      process.env.VITE_SERVER_OPEN || `http://localhost:${process.env.WP_PORT}`,
  },

  css: { postcss: postcssConfig },

  plugins: [
    pluginReload(["**/*.php", "dist/images/**/*"]),
    pluginImage(["./src/images/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]),
  ],
})
