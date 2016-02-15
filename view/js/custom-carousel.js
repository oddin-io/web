$(document).ready(function() {
  var owl = $("#owl-demo");
  owl.owlCarousel({
    // Define custom and unlimited items depending from the width
    // If this option is set, itemsDeskop, itemsDesktopSmall, itemsTablet, itemsMobile etc. are disabled
    // For better preview, order the arrays by screen size, but it's not mandatory
    // Don't forget to include the lowest available screen size, otherwise it will take the default one for screens lower than lowest available.
    // In the example there is dimension with 0 with which cover screens between 0 and 450px
    itemsCustom : [
      [0, 1],
      [450, 1],
      [600, 2],
      [700, 2],
      [1000, 3],
      [1200, 4],
      [1400, 4],
      [1600, 5]
    ],
    navigation : true
  });
});
