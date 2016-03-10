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
     * Set display:none to an HTML element
     */
    function hide(elem) {
        
        if (typeof elem == 'undefined') {
            // something undefined is already hidden
            return true;
        }

        elem.style.display = 'none';
        
        return true;
    }


    /*
     * Set display:block to an HTML element
     */
    function show(elem) {

        if (typeof elem == 'undefined') {
            // something undefined cannot be shown
            return false;
        }

        elem.style.display = 'block'; 
        
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
        return returnValue && hide(elem);
    }


    /*
     * Toggle a menu's children visibility
     */
    function toggle_menu(elem) {
        if (elem.style.display == 'none') {
            show(elem);
        }
        else {
            close_menu(elem);
        }
    }


    /*
     * Add the menu-toggle button to the menu
     */
    function set_menu_toggle_button() {
        
        // get the menu
        var container = document.getElementById('primary-menu')
            .getElementsByTagName('ul')[0];

        // create a new <ul> node
        var listAnchor = document.createElement('ul');
        listAnchor.className = 'children';
        listAnchor.id = 'menu_anchor';
        
        // create a new <li> node
        var buttonNode = document.createElement('li');
        buttonNode.className = 'fake_page_item page_item_has_children page_item_menu_toggle';
      
        // create a new <a> to wrap the button (needed by click listeners in set_listeners)
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
     * Set the menu click event listeners
     */
    function set_listeners() {
        
        // iterate over the <li>s with a child submenu to enable submenu-toggling
        var submenus = document.querySelectorAll('.page_item_has_children');
        for (var i=0; i<submenus.length; i++) {
            // set the link href to # to prevent redirecting when clicking
            submenus[i].getElementsByTagName('a')[0].href = '#';

            // set display:none to child to be able to read that stat yet at the first click
            submenus[i].getElementsByClassName('children')[0].style.display = 'none';

            // add click event listener to <li> items to show their <ul> children
            submenus[i].addEventListener('click', function(evt) {
                // get parent <ul>
                var ul = this.getElementsByClassName('children')[0];

                // set child position below the parent <ul>
                var top = (this.parentNode.parentNode.getAttribute('class') == 'menu') ?
                    document.getElementById('masthead').getBoundingClientRect().bottom :
                    this.parentNode.getBoundingClientRect().height;           //@ TODO: understand why here goes .height instead of .bottom (perhaps position:absolute of parent submenu?)
                ul.style.top = top + 'px';

                // do the job
                toggle_menu(ul);

                // stop event propagation to the parent menu
                evt.stopPropagation();
            });
        }
    }

  
    /*
     * Handle menu modification when the page switches from one size-class to another
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
            items = root.querySelectorAll(':scope > li.page_item');
            destination = anchor;
        }
        else {
            // page was small -> list items are in the anchor <ul>
            items = anchor.querySelectorAll(':scope > li.page_item');
            destination = root;
        }

        // move the items to their destination
        for (var i=0; i<items.length; i++) {
            destination.appendChild(items[i]);
        }
    }


    /*s
     * Test all features of this file
     */
    function test () {
    
        console.log('BEGIN TESTING');
        console.log('---');
        
        // test show/hide on the logo
        var logo = document.getElementById('logo');
        logo.style.display = 'inline';
        console.log('Testing show/hide on "logo"');
        console.log('    logo.style.display = ' + logo.style.display);
        console.log('  > logo.show() = ' + show(logo));
        console.log('    logo.style.display = ' + logo.style.display);
        console.log('  > logo.hide() = ' + hide(logo));
        console.log('    logo.style.display = ' + logo.style.display);
        console.log('  > logo.show() = ' + show(logo));
        console.log('    logo.style.display = ' + logo.style.display)
        console.log('Resetting logo.style.display to "inline"');
        logo.style.display = 'inline';
        console.log('---');

        // test close_menu
        var menu = document.createElement('ul');
        menu.style.display = 'block';
        menu.appendChild(document.createElement('li'));
        menu.appendChild(document.createElement('li'));
        menu.appendChild(document.createElement('li'));
        menu.appendChild(document.createElement('li'));
        menu.appendChild(document.createElement('li'));
        var li_with_children = document.createElement('li');
        menu.appendChild(li_with_children);
        var submenu = document.createElement('ul');
        submenu.style.display = 'block';
        li_with_children.appendChild(submenu);
            submenu.appendChild(document.createElement('li'));
            submenu.appendChild(document.createElement('li'));
            submenu.appendChild(document.createElement('li'));
            submenu.appendChild(document.createElement('li'));
            var other_li_with_children = document.createElement('li');
            submenu.appendChild(other_li_with_children);
            var subsubmenu = document.createElement('ul');
            subsubmenu.style.display = 'block';
            other_li_with_children.appendChild(subsubmenu);
                subsubmenu.appendChild(document.createElement('li'));
                subsubmenu.appendChild(document.createElement('li'));
                subsubmenu.appendChild(document.createElement('li'));
        console.log('Testing close_menu on "submenu"');
        console.log('    menu.style.display = ' + menu.style.display);
        console.log('    submenu.style.display = ' + submenu.style.display);
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display);
        console.log('  > close_menu(submenu) = ' + close_menu(submenu));
        console.log('    menu.style.display = ' + menu.style.display);
        console.log('    submenu.style.display = ' + submenu.style.display);
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display);
        console.log('Resetting submenu.style.display to "block"');
        submenu.style.display = 'block';
        console.log('Resetting subsubmenu.style.display to "block"');
        subsubmenu.style.display = 'block';
        console.log('---');
        console.log('Testing close_menu on "menu"');
        console.log('    menu.style.display = ' + menu.style.display);
        console.log('    submenu.style.display = ' + submenu.style.display);
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display);
        console.log('  > close_menu(menu) = ' + close_menu(menu));
        console.log('    menu.style.display = ' + menu.style.display)
        console.log('    submenu.style.display = ' + submenu.style.display);
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display);
        console.log('---');
    }

    /*
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Begin self-executing code
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */
    
    // Uncomment the next line to test code above
    //test();return;
    
    // Do this if you want to have a working menu
    set_menu_toggle_button();
    set_listeners();

    // Listen to the window resize event and adapt the menu if the page class changes
    var page_size_class = get_page_size_class();
    adapt_page(page_size_class);
    window.addEventListener('resize', function(evt) {

        // adapt the page if the page-class changes
        var new_page_size_class = get_page_size_class();
        if (page_size_class != new_page_size_class) {
            
            // adapt page
            page_size_class = new_page_size_class;
            adapt_page(page_size_class);
        
            // close submenus
            var submenus = document.querySelectorAll('#primary-menu > ul > li > ul');
            console.log(submenus);
            for (var i=0; i<submenus.length; i++) {
                close_menu(submenus[i]);
            }
        }
    }, true);
    
})();
