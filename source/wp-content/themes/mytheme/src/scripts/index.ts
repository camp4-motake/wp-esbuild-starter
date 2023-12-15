import intersect from "@alpinejs/intersect"
import Alpine from "alpinejs"

const components = import.meta.glob("./components/**/*.{js,ts,jsx,tsx}")
const stores = import.meta.glob("./stores/**/*.{js,ts,jsx,tsx}")

window.Alpine = Alpine
Alpine.plugin(intersect)
await Promise.all(
  [...Object.values(components), ...Object.values(stores)].map((mod) => mod()),
)
Alpine.start()
