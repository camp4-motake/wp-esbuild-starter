import Alpine from "alpinejs"

export type SiteStatus = {
	siteStatus: {
		isPageActive: boolean
		isScrollDown: boolean
		isDialogOpen: boolean
	}
}

Alpine.store("siteStatus", {
	isPageActive: false,
	isScrollDown: false,
	isDialogOpen: false,
})
