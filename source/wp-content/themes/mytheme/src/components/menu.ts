import Alpine from "alpinejs"
import { MQ } from "../constants"
import type { MenuStatus } from "../stores/menuStatus"

const ignoreCloseSelector = ".nav-primary,.menu-toggle,[data-menu-close-ignore]"
const breakpoint = MQ.xxl

/**
 * toggle
 */
Alpine.data("menuToggle", () => ({
	get $store(): MenuStatus {
		return this.$store as MenuStatus
	},

	init() {
		this.addMatchMediaEvent()
		this.addOuterClickEvent()
	},

	toggle: {
		["@click"]() {
			this.$store.menuStatus.toggle()
		},
		["@menu:close.window"]() {
			this.close()
		},
		[":title"]() {
			return this.$store.menuStatus.shown ? "Menu Close" : "Menu Open"
		},
		[":aria-expanded"]() {
			return this.$store.menuStatus.shown
		},
		[":data-menu-toggle"]() {
			return this.$store.menuStatus.shown ? "shown" : "close"
		},
	},

	menuLabel: {
		["x-text"]() {
			return this.$store.menuStatus.shown ? "Close" : "Menu"
		},
	},

	addMatchMediaEvent() {
		window.matchMedia(breakpoint).addEventListener("change", () => {
			this.$dispatch("menu:close")
		})
	},

	addOuterClickEvent() {
		document.addEventListener("click", (event) => {
			const { target } = event
			if (!(target instanceof Element)) return
			if (target?.closest(ignoreCloseSelector)) return
			this.close()
		})
	},

	close() {
		this.$store.menuStatus.shown = false
	},
}))

/**
 * close
 */
Alpine.data("menuClose", () => ({
	menuClose: {
		["@click"]() {
			;(this.$store as MenuStatus).menuStatus.shown = false
		},
	},
}))
