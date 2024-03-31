wp.domReady(() => {
  // List of embed block variations to keep. If you want to completely remove all, leave this array empty
  const keepEmbeds = []; // Example: ['core-embed/youtube', 'core-embed/twitter']

  wp.blocks.getBlockVariations("core/embed").forEach(function (variation) {
    if (!keepEmbeds.includes(variation.name)) {
      wp.blocks.unregisterBlockVariation("core/embed", variation.name);
    }
  });
});
