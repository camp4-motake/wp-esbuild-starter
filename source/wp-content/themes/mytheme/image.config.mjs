import path from "path";
import findWorkspaceRoot from "find-yarn-workspace-root";
import { fileURLToPath } from "url";
import ImgMin from "./src/_lib/ImgMin.mjs";
import chokidar from "chokidar";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = findWorkspaceRoot(__dirname) || "./";
const inProduction = process.env.NODE_ENV === "production";

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
  });
  return await img.run();
};
await imgTask(["./src/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"]);

// watch
if (!inProduction) {
  const watcher = chokidar.watch("./src/images", {
    ignored: [".*", "**/_*/**"],
    persistent: true,
  });
  watcher
    .on("add", async (path) => await imgTask(path))
    .on("change", async (path) => await imgTask(path));
}
