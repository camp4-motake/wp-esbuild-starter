import Alpine from "alpinejs"
import type { MenuStatus } from "../stores/menuStatus"
import type { SiteStatus } from "../stores/siteStatus"

const mq = window.matchMedia("screen and (max-width: 782px)")

Alpine.data("app", () => ({
  get $store(): SiteStatus & MenuStatus {
    return this.$store
  },

  interval: 0,
  isRecaptcha: false,
  scrollBarWidth: 0,
  wpAdminBar: null as null | HTMLElement,

  init() {
    this.$nextTick(() => {
      this.$store.siteStatus.isPageActive = true
      this.scrollBarCheckInterval()
      this.setWPMatchMediaEvent()
    })
  },

  root: {
    [":class"]() {
      return {
        isDialogOpen: this.$store.siteStatus.isDialogOpen,
        isMenuOpen: this.$store.menuStatus.shown,
        isPageActive: this.$store.siteStatus.isPageActive,
        isScrollDown:
          this.$store.siteStatus.isScrollDown || this.$store.menuStatus.shown,
      }
    },
    [":style"]() {
      return { "--window-scroll-bar-width": `${this.scrollBarWidth}px` }
    },
    ["@resize.window"]() {
      this.setWPAdminBarSize()
    },
  },

  scrollBarCheckInterval() {
    this.interval = window.setInterval(() => {
      this.setScrollbarWidth()
    }, 1000)
  },

  setScrollbarWidth() {
    this.scrollBarWidth =
      window.innerWidth - document.documentElement.clientWidth
  },

  setWPMatchMediaEvent() {
    this.wpAdminBar = document.getElementById("wpadminbar")
    if (!this.wpAdminBar) return

    this.setWPAdminBarSize()
    mq.addEventListener("change", () => this.setWPAdminBarSize())
  },

  setWPAdminBarSize() {
    if (!this.wpAdminBar) return
    const size = this.wpAdminBar.getBoundingClientRect()
    this.$el.style.setProperty("--wp-adminbar-height", `${size.height}px`)
  },
}))
