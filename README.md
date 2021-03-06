A WordPress plugin that creates a shortcode, which when added to the Gutenberg editor alongside a gallery block, turns the gallery into a slick.js slider on the front-end.

The shortcode is named [slick-slider-gallery] and has two custom attributes:

- title (e.g. title="My Title") 
- gallery_id (e.g. gallery_id="my-gallery") 
 
In order to have multiple galleries and shortcodes for the same page/post, the "gallery_id" attribute should be the same as the gallery blocks anchor ID. Example - [slick-slider-gallery title="My Title" gallery_id="my-gallery"], where the gallery blocks ID is also equal to "my-gallery".

The code could of course be used without the custom attributes and just have the gallery block and shortcode, to produce just one gallery slider per page.

See this accompanying blog post on my website for more details: https://ajcode.net/turn-a-wordpress-gallery-block-into-a-slider-using-slick-js/
