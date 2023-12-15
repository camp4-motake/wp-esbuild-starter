import Alpine from "alpinejs"
import { SiteStatus } from "../stores/siteStatus"

const rootStyle = getComputedStyle(document.documentElement)
const closeIgnore = "[data-modal-content]"

Alpine.data("modal", () => ({
  get $store(): SiteStatus {
    return this.$store
  },

  dialog: null as null | HTMLDialogElement,
  isOpen: false,
  isRunning: false,
  isTriggerActive: false,

  modalDialog: {
    ["x-init"]() {
      if (!(this.$el instanceof HTMLDialogElement)) return
      this.dialog = this.$el
    },
    [":class"]() {
      return { "-is-active": this.isOpen }
    },
    [":open"]() {
      return this.isOpen
    },
    ["@click"]({ target }: Event) {
      if (!(target instanceof HTMLElement)) return
      if (target?.closest(closeIgnore)) return
      this.close()
    },
  },

  modalTrigger: {
    [":class"]() {
      return { "-is-active": this.isTriggerActive }
    },
    ["@click"](event: Event) {
      event.preventDefault()
      if (this.isRunning) return
      if (this.isOpen) this.close()
      else this.open()
    },
  },

  modalClose: {
    ["@click"](event: Event) {
      event.preventDefault()
      if (this.isRunning) return
      if (this.isOpen) this.close()
    },
  },

  close() {
    if (!this.dialog) return
    const animation = this.dialog?.animate(
      this.closeKeyframes(),
      this.animationTiming,
    )
    this.isRunning = true
    this.isTriggerActive = false
    this.$store.siteStatus.isDialogOpen = false
    animation.onfinish = () => {
      this.isOpen = false
      this.isRunning = false
      this.dialog?.close()
    }
  },

  open() {
    if (!this.dialog) return
    const animation = this.dialog.animate(
      this.openKeyframes(),
      this.animationTiming,
    )
    this.isOpen = true
    this.dialog?.showModal()
    this.isTriggerActive = true
    this.isRunning = true
    this.$store.siteStatus.isDialogOpen = true
    animation.onfinish = () => (this.isRunning = false)
  },

  /**
   * animation keyframes
   */
  animationTiming: {
    duration: 400,
    easing: rootStyle.getPropertyValue("--ease-out-circ"),
  },
  closeKeyframes() {
    return [{ opacity: 1 }, { opacity: 0 }]
  },
  openKeyframes() {
    return [{ opacity: 0 }, { opacity: 1 }]
  },
}))
