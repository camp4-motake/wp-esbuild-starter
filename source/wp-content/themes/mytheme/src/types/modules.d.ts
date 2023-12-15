declare module "@alpinejs/collapse"
declare module "@alpinejs/intersect"
declare module "@alpinejs/persist"
declare module "splitting"

declare module "*.data.ts" {
  const value: () => void
  export default value
}

declare module "*.store.ts" {
  const value: () => void
  export default value
}
