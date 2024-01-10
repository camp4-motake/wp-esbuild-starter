/**
 * main css glob import
 * @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
 */
import.meta.glob("./styles/config/**/*.css", { eager: true })
import.meta.glob("ress", { eager: true })
import.meta.glob(
	"./styles/{global,plugins,blocks,components,partials,utils,routes}/**/*.css",
	{ eager: true },
)

/**
 * init alpine.js
 * @see https://alpinejs.dev/start-here
 */
import intersect from "@alpinejs/intersect"
import Alpine from "alpinejs"

const components = import.meta.glob("./components/**/*.{js,ts,jsx,tsx}")
const stores = import.meta.glob("./stores/**/*.{js,ts,jsx,tsx}")
const modules = [...Object.values(components), ...Object.values(stores)]

const main = async () => {
	window.Alpine = Alpine
	Alpine.plugin(intersect)
	await Promise.all(modules.map((mod) => mod()))
	Alpine.start()
}
main()
