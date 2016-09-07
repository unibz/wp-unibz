/**
 *  Date:       13-07-2016
 *  Authors:    Giulio Roman
 *              Anna Ricci
 *
 * Description: This javascript is used to toggle the submenus when the user clicks on them
 *
**/

$('.dropdown-submenu').click(function(event) {
  $(this).toggleClass('open');
  $(this).siblings('li').removeClass('open');
  $(this).siblings('li').find('.dropdown-submenu').removeClass('open');
  $(this).find('.dropdown-submenu').removeClass('open');
  event.stopPropagation();
});