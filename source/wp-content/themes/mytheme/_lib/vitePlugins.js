import findWorkspaceRoot from "find-yarn-workspace-root"
import path from "path"
import { fileURLToPath } from "url"
import { globby } from "globby"
import ImgMin from "./ImgMin.js"

/**
 * vite plugin image optimize
 *
 * @param {string[]} images target glob array
 * @returns
 */
export function pluginImage(images = [], imgOptions = {}) {
	const dirname = path.dirname(fileURLToPath(import.meta.url))
	const root = findWorkspaceRoot(`${dirname}/../`) || "./"
	const imgTask = async (src) => {
		const img = new ImgMin({
			src,
			dest: "./dist",
			option: {
				base: "./src",
				cacheDir: path.resolve(root, `node_modules/.cache/images`),
			},
			...imgOptions,
		})
		return await img.run()
	}

	return {
		name: "image",
		async buildStart() {
			if (process.env.NODE_ENV !== "development") return
			await imgTask(images)
		},
		async buildEnd() {
			if (process.env.NODE_ENV !== "production") return
			await imgTask(images)
		},
		async watchChange(id, change) {
			if (change.event === "delete") return
			const src = path.relative(process.env.PWD, id)
			const watchPaths = await globby(images)
			if (watchPaths.some((ext) => `./${src}`.endsWith(ext))) {
				await imgTask(`./${src}`)
			}
		},
	}
}

/**
 * vite plugin: file reload
 *
 * @param {string[]} watches target with glob array
 * @returns
 */
export function pluginReload(watches = []) {
	return {
		name: "reload",
		async handleHotUpdate({ file, server }) {
			const watchPaths = await globby(watches)
			if (watchPaths.some((ext) => file.endsWith(ext))) {
				server.ws.send({ type: "full-reload", path: "*" })
			}
		},
	}
}
