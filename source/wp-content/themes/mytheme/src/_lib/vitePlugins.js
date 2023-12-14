import path from "path"
import findWorkspaceRoot from "find-yarn-workspace-root"
import { fileURLToPath } from "url"
import { globby } from "globby"
import ImgMin from "./ImgMin.js"

/**
 * vite plugin image optimize
 *
 * @param {string[]} images target glob array
 * @returns
 */
export function pluginImage(images = []) {
  const dirname = path.dirname(fileURLToPath(import.meta.url))
  const root = findWorkspaceRoot(dirname) || "./"

  const imgTask = async (src) => {
    const img = new ImgMin({
      src,
      dest: "./dist",
      option: {
        base: "./src",
        cacheDir: path.resolve(root, `node_modules/.cache/images`),
      },
    })
    return await img.run()
  }

  return {
    name: "image",
    async buildStart() {
      if (process.env.NODE_ENV === "development") {
        await imgTask(images)
      }
    },
    async buildEnd() {
      if (process.env.NODE_ENV === "production") {
        await imgTask(images)
      }
    },
    async watchChange(id, change) {
      if (change.event === "delete") return
      const watchPaths = await globby(images)
      const src = `.${id.replace(dirname, "")}`
      if (watchPaths.some((ext) => src.endsWith(ext))) {
        await imgTask(src)
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
