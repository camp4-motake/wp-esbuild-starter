import intersect from "@alpinejs/intersect"
import Alpine from "alpinejs"

/**
 * WORKAROUND: main css glob import
 * @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
 */
import.meta.glob("./styles/config/**/*.css", { eager: true })
import.meta.glob("ress", { eager: true })
import.meta.glob(
  "./styles/{global,plugins,blocks,components,partials,utils,routes}/**/*.css",
  { eager: true },
)

/**
 * init alpine.js assets
 * @see https://alpinejs.dev/start-here
 */
const components = import.meta.glob("./scripts/components/**/*.{js,ts,jsx,tsx}")
const stores = import.meta.glob("./scripts/stores/**/*.{js,ts,jsx,tsx}")

window.Alpine = Alpine
Alpine.plugin(intersect)
await Promise.all(
  [...Object.values(components), ...Object.values(stores)].map((mod) => mod()),
)
Alpine.start()
