/**
 * ブロックスタイル
 * @see https://ja.wordpress.org/team/handbook/block-editor/reference-guides/block-api/block-styles/
 */

type Style = {
	block: string
	option: unknown
}

export const blockStyles = () => {
	if (!wp?.blocks) return

	const addedStyles: Style[] = [
		/*
    // ex
    {
      block: "core/heading",
      option: { name: "sample", label: "サンプル" },
    },
     */
	]

	addedStyles.forEach((s) => wp?.blocks?.registerBlockStyle(s.block, s.option))
}
