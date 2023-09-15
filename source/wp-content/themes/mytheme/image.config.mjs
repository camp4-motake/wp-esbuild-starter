import path from "path";
import findWorkspaceRoot from "find-yarn-workspace-root";
import { fileURLToPath } from "url";
import ImgMin from "./src/_lib/ImgMin.mjs";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = findWorkspaceRoot(__dirname) || "./";

/**
 * compress image & generate webp
 */
const imgTask = new ImgMin({
  src: ["./src/**/*.{jpg,jpeg,png,svg}", "!./src/**/_*/**"],
  dest: "./dist",
  option: {
    base: "./src",
    cacheDir: path.resolve(root, `node_modules/.cache/images`),
  },
});
await imgTask.run();
