import Alpine from "alpinejs"
import { sleep } from "../utils/sleep"

const rootStyle = () => getComputedStyle(document.documentElement)

Alpine.data("accordion", () => ({
	isRunning: false,
	isOpen: false,
	isTriggerActive: false,

	accordion: {
		[":class"]() {
			return { "-is-active": this.isOpen }
		},
		[":open"]() {
			return this.isOpen
		},
	},

	accordionTrigger: {
		[":class"]() {
			return { "-is-active": this.isTriggerActive }
		},
		["@click"]({ preventDefault }: Event) {
			preventDefault()
			if (!this.isRunning) this.toggle(!this.isOpen)
		},
	},

	toggle(open: boolean) {
		if (open) this.open()
		else this.close()
	},

	close() {
		const animation = this.$refs.accordionContent.animate(
			this.closeKeyframes(this.$refs.accordionContent),
			this.animationTiming,
		)
		this.isRunning = true
		this.isTriggerActive = false
		animation.onfinish = () => {
			this.isOpen = false
			this.isRunning = false
		}
	},

	open() {
		this.isOpen = true
		this.isTriggerActive = true
		this.isRunning = true
		this.$refs.accordionContent.style.height = "0"
		sleep(1).then(() => {
			this.$refs.accordionContent.style.height = ""
			const animation = this.$refs.accordionContent.animate(
				this.openKeyframes(this.$refs.accordionContent),
				this.animationTiming,
			)
			animation.onfinish = () => (this.isRunning = false)
		})
	},

	/**
	 * animation keyframes
	 */
	animationTiming: {
		duration: 400,
		easing: rootStyle().getPropertyValue("--ease-out-circ"),
	},
	closeKeyframes(el: HTMLElement) {
		return [{ height: el.offsetHeight + "px" }, { height: 0 }]
	},
	openKeyframes(el: HTMLElement) {
		return [{ height: 0 }, { height: el.offsetHeight + "px" }]
	},
}))
