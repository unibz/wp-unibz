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
  event.stopPropagation();
});