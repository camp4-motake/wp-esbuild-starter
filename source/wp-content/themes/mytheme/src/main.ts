import "./scripts"

// styles
import "./styles/main.css"

// WORKAROUND: vite css glob import
// @see https://github.com/vitejs/vite/discussions/6688#discussioncomment-3649999
import.meta.glob(
  "./styles/{global,plugins,blocks,components,partials,utils,routes}/**/*.css",
  { eager: true },
)
