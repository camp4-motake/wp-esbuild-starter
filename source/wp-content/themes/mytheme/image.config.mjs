import path from "path";
import findWorkspaceRoot from "find-yarn-workspace-root";
import { execSync } from "child_process";
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

/**
 * generate svg sprite
 * https://github.com/svg-sprite/svg-sprite/blob/main/docs/command-line.md
 */
const svgSprites = [
  {
    src: "src/images/_sprite/*.svg",
    dest: "dist/images",
    outFileName: "svg-sprite.svg",
  },
];
svgSprites.forEach((svg) => {
  execSync(
    `svg-sprite -s --symbol-dest ${svg.dest} --symbol-sprite ${svg.outFileName} ${svg.src} --svg-xmldecl=false --shape-transform=svgo`
  );
});
