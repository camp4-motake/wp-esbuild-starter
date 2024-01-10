import Alpine from "alpinejs"
import { MenuStatus } from "../stores/menuStatus"

Alpine.data("navPrimary", () => ({
	get $store(): MenuStatus {
		return this.$store
	},

	navPrimary: {
		["x-init"]() {
			this.$watch("$store.menuStatus.shown", (isShown) => {
				if (isShown) this.$el.scrollTo(0, 0)
			})
		},
		[":data-menu-status"]() {
			return this.$store.menuStatus.shown ? "shown" : "close"
		},
	},

	navPrimaryLink: {
		["@click"]() {
			this.$store.menuStatus.shown = false
		},
	},
}))
