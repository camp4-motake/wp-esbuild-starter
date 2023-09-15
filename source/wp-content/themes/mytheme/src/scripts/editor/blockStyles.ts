export const blockStyles = () => {
  if (!wp?.blocks) return;

  const addedStyles = [
    {
      block: "core/heading",
      option: { name: "sample", label: "サンプル" },
    },
  ];

  addedStyles.forEach((s) => wp?.blocks?.registerBlockStyle(s.block, s.option));
};
