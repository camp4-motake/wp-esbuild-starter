import { defineConfig } from "vite"
import { pluginImage, pluginReload } from "./_lib/vitePlugins.js"

/**
 * @see https://ja.vitejs.dev/config/
 */
export default defineConfig(() => {
	const { VITE_SERVER_OPEN, TARGET } = process.env
	const prefix = TARGET || "main" // editor | main

	return {
		publicDir: "src/static",
		build: {
			outDir: "dist",
			assetsDir: "",
			emptyOutDir: false,
			manifest: `.vite/manifest.${prefix}.json`,
			rollupOptions: {
				input: { [prefix]: `src/${prefix}.ts` },
				output: { chunkFileNames: `chunk.[hash].js` },
			},
		},

		plugins: [
			pluginImage(["./src/images/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]),
			pluginReload(["**/*.php", "dist/images/**/*"]),
		],

		...(VITE_SERVER_OPEN ? { server: { open: VITE_SERVER_OPEN } } : {}),
	}
})
