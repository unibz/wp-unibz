/**
 * File navigation.js.
 *
 * Handles the navigation menu.
 */
( function() {

    /*
     * Returns a string representing the page size class
     *  + 'small'
     *  + 'big'
     */
    function get_page_size_class() {
        var w = window.innerWidth;
        if (w<800) {
            return 'small';
        } else {
            return 'big';
        }
    }


    /*
     * Move a menu item outsite of the page (on top)
     */
    function hide(elem) {
        
        if (typeof elem == 'undefined') {
            // something undefined is already hidden
            return true;
        }
        
        elem.style.top = -elem.getBoundingClientRect().height + 'px';
        elem.style.visibility = 'hidden';

        return true;
    }


    /*
     * Move a menu item back into the page
     */
    function show(elem) {

        if (typeof elem == 'undefined') {
            // something undefined cannot be shown
            return false;
        }

        elem.style.visibility = 'visible';
        var top;
        if (elem.parentNode.parentNode.parentNode.getAttribute('class') == 'menu') {
            top  = document.getElementById('masthead').getBoundingClientRect().bottom;
            top -= document.getElementById('masthead').getBoundingClientRect().top;
        }
        else {
            //@TODO understand why here goes .height instead of (bottom - top)
            //
            //      --> perhaps position:absolute of parent submenu?
            //
            top  = elem.parentNode.parentNode.getBoundingClientRect().height;
        }
        elem.style.top = (top-1) + 'px';

        return true;
    }


    /*
     * Recursively close (hide) all children of a nested <ul> menu
     */
    function close_menu (elem) {
        
        // base case
        if (typeof elem == 'undefined') {
            return true;
        }
        
        // elem has to be an <ul>, all its <ul> children will be closed
        if (elem.nodeName.toLowerCase() != 'ul') {
            if (elem.nodeName.toLowerCase() != 'li') {
                // elem is not part of a menu
                return false;
            }
            else {
                elem = elem.parentNode;
            }
        }

        // the return value is true if and only if all children can be
        // closed recursively returning true; the return value doesn't
        // affect the process of closing the children but only tells us
        // whether something strange has happened
        var returnValue = false;

        // get <li>s
        var listItems = elem.childNodes;

        // recursively explore the menu tree
        for (var i=0; i<listItems.length; i++) {
            if (listItems[i].nodeName.toLowerCase() != 'li'){
                // the element cannot have a child menu
                continue;
            }
            else {
                var submenu = elem.getElementsByTagName('ul')[0];
                returnValue = close_menu(submenu) && hide(submenu);
            }
        }

        // close the node
        elem.parentNode.className = elem.parentNode.className.replace(/ selected/g, '');
        return hide(elem) && returnValue;
    }


    /*
     * Toggle a menu's children visibility
     */
    function toggle_menu(elem) {
        if (elem.style.visibility == 'hidden') {
            show(elem);
            elem.parentNode.className += ' selected';
        }
        else {
            close_menu(elem);
        }
    }


    /*
     * Add the menu-toggle button to the menu (this is necessary because wordpress automatically
     * creates a menu with wp_nav_menu() populated with values and we want to add the menu-toggle
     * button that is not natively supported)
     *
     * @TODO try to insert the menu button on php side
     *
     *       --> perhaps by hacking into wp_nav_menu() and setting option 'echo' to false?
     *
     */
    function setup_menu_toggle_button() {
        
        // get the menu
        var container = document.getElementById('primary-menu')
            .getElementsByTagName('ul')[0];

        // create a new <ul> node
        var listAnchor = document.createElement('ul');
        listAnchor.className = 'children';
        listAnchor.id = 'menu_anchor';
        
        // create a new <li> nodeelem.getBoundingClientRect().height
        var buttonNode = document.createElement('li');
        buttonNode.className = 'fake_page_item page_item_has_children page_item_menu_toggle';
      
        // create a new <a> to wrap the button (needed by click listeners in setup_submenus)
        var buttonWrapper = document.createElement('a');

        // create the button 
        var button = document.createElement('button');
        
        // wrap everything together
        buttonWrapper.appendChild(button);
        buttonNode.appendChild(buttonWrapper);
        buttonNode.appendChild(listAnchor);

        // move the button node into the menu
        container.appendChild(buttonNode);
    }


    /*
     * Add the choose-language button to the menu (this is necessary because wordpress automatically
     * creates a menu with wp_nav_menu() populated with values and we want to add the choose-language
     * button that is not natively supported)
     *
     * @TODO try to insert the language button on php side
     *
     *       --> perhaps by hacking into wp_nav_menu() and setting option 'echo' to false?
     *
     */
    function setup_lang_choice_button() {
        var button = document.getElementById('lang_choice');
        if(button != null) {      
            var menu = document.getElementById('primary-menu')
                .childNodes[0];
            
            menu.insertBefore(button, menu.childNodes[0]);
        }
    } 


    /*
     * Style submenus and set their click event listeners
     */
    function setup_submenus() {
        
        // iterate over the <li>s with a child submenu to enable submenu-toggling
        var submenus = document.querySelectorAll('.page_item_has_children');
        for (var i=0; i<submenus.length; i++) {
            // set the link href to # to prevent redirecting when clicking
            submenus[i].getElementsByTagName('a')[0].href = '#';

            // set display:none to child to be able to read that stat yet at the first click
            submenus[i].getElementsByClassName('children')[0].style.visibility = 'hidden';
            submenus[i].getElementsByClassName('children')[0].style.top = 
                -submenus[i].getElementsByClassName('children')[0].getBoundingClientRect().height + 'px';
            submenus[i].getElementsByClassName('children')[0].style.zIndex = -(i+1);

            // add click event listener to <li> items to show their <ul> children
            submenus[i].addEventListener('click', function(evt) {

                // stop event propagation to the parent menu
                evt.stopPropagation();

                // get child <ul>
                var ul = this.getElementsByClassName('children')[0];

                // toggle the child
                toggle_menu(ul);

                // close the siblings
                var siblings = this.parentNode.getElementsByClassName('selected');
                for(var j=0; j<siblings.length; j++) {
                    if(siblings[j]!=this) {
                        toggle_menu(siblings[j].getElementsByTagName('ul')[0]);
                    }
                }
            });
        }

        // mark root level nodes
        var submenus = document.querySelectorAll('.page_item');
        for (var i=0; i<submenus.length; i++) {
            var rootMenu = document.getElementById('primary-menu');
            if(submenus[i].parentNode.parentNode == rootMenu){
                submenus[i].className += ' root_page_item';
            }
        }
    }

  
    /*
     * Handle menu modification when the page switches from one size class to another one
     */
    function adapt_page(pageClass) {
        
        // get the menu root
        var root = document.getElementById('primary-menu')
            .getElementsByTagName('ul')[0];
        
        // get the menu anchor
        var anchor = document.getElementById('menu_anchor');

        // get the items to move and choose the destination
        var items, destination;
        if (pageClass=='small') {
            // page was big -> list items are in the root <ul>
            items = root.querySelectorAll('li.root_page_item');
            destination = anchor;
        }
        else {
            // page was small -> list items are in the anchor <ul>
            items = anchor.querySelectorAll('li.root_page_item');
            destination = root;
        }

        // move the items to their destination
        for (var i=0; i<items.length; i++) {
            destination.appendChild(items[i]);
        }
    }


    /*
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Begin self-executing code
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */
    
    // Uncomment the next line to run the test function above
    //test();return;
    
    // Add choose-language and toggle-menu buttons
    setup_lang_choice_button();
    setup_menu_toggle_button();
   
    // set up the submenus by adding some styles and click listeners
    setup_submenus();

    // build the page layout depending on the page size
    var page_size_class = get_page_size_class();
    adapt_page(page_size_class);

    // Listen to the window resize event to adapt the page according to its size
    window.addEventListener('resize', function(evt) {

        // adapt the page if the page-class changes
        var new_page_size_class = get_page_size_class();
        if (page_size_class != new_page_size_class) {
            
            // adapt page
            page_size_class = new_page_size_class;
            adapt_page(page_size_class);
        
            // close submenus
            var submenus = document.querySelectorAll('ul.children');
            for (var i=0; i<submenus.length; i++) {
                close_menu(submenus[i]);
            }
        }
    }, true);
    
})();
