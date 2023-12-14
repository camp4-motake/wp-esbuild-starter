import "./scripts"

// WORKAROUND: vite css glob import
// @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
import.meta.glob("./styles/config/**/*.css", { eager: true })
import.meta.glob("ress", { eager: true })
import.meta.glob(
  "./styles/{global,plugins,blocks,components,partials,utils,routes}/**/*.css",
  { eager: true },
)
