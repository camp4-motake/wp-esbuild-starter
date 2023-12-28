/**
 * ブロックバリエーション
 * @see https://ja.wordpress.org/team/handbook/block-editor/reference-guides/block-api/block-variations/
 */

type Variation = {
  block: string
  variations: unknown[]
}

export const blockVariations = () => {
  if (!wp?.blocks) return

  // ブロックバリエーションを配列で登録
  const addVariations: Variation[] = [
    /*
    // ex
    {
      block: "core/embed",
      variations: [
        {
          name: "custom-embed",
          attributes: { providerNameSlug: "custom" },
        },
      ],
    },
    */
  ]

  if (!addVariations.length) return
  addVariations.forEach(
    (s) => wp?.blocks?.registerBlockVariation(s.block, s.variations),
  )
}
