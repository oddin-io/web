//$(".button-collapse").sideNav();
$(document).ready(function(){
  $('.collapsible').collapsible({
    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
  });
  $('ul.tabs').tabs();
  $('.modal-trigger').leanModal();
});
