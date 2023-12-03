import path from "path"
import findWorkspaceRoot from "find-yarn-workspace-root"
import { fileURLToPath } from "url"
import ImgMin from "./src/_lib/ImgMin.mjs"
import chokidar from "chokidar"
import { setTimeout } from "node:timers/promises"

const __dirname = path.dirname(fileURLToPath(import.meta.url))
const root = findWorkspaceRoot(__dirname) || "./"
const inProduction = process.env.NODE_ENV === "production"

const targets = ["./src/images/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]

/**
 * compress image & generate webp
 */
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
await imgTask(targets)

// watch
if (!inProduction) {
  await setTimeout(1000)
  const watcher = chokidar.watch(targets, {
    ignored: [".*", "**/_*/**"],
    persistent: true,
  })
  watcher
    .on("add", async (src) => await imgTask(`./${src}`))
    .on("change", async (src) => await imgTask(`./${src}`))
}
