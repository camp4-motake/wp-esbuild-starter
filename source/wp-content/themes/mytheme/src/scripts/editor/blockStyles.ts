export const blockStyles = () => {
  const cfg = [
    {
      block: "core/heading",
      option: {
        name: "fit-after-line",
        label: "近接行",
      },
    },
    {
      block: "core/paragraph",
      option: {
        name: "fit-after-line",
        label: "近接行",
      },
    },
  ];

  cfg.forEach((c) => wp?.blocks?.registerBlockStyle(c.block, c.option));
};
