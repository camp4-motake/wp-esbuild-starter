import Alpine from "alpinejs"

export type MenuStatus = {
  menuStatus: {
    shown: boolean
    toggle: () => void
  }
}

Alpine.store("menuStatus", () => ({
  shown: false,
  toggle() {
    this.shown = !this.shown
  },
}))
