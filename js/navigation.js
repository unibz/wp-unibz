/**
 * File navigation.js.
 *
 * Handles the navigation menu.
 */
( function() {

    /*
     * Set display:none to an HTML element and backup its original value
     */
    function hide(elem) {
        
        if (typeof elem == 'undefined') {
            // something undefined is already hidden
            return true;
        }

        elem.style.display = 'none';
        
        return true;
    };


    /*
     * Set display to an HTML element according to its original value
     */
    function show(elem) {

        if (typeof elem == 'undefined') {
            // something undefined cannot be shown
            return false;
        }

        elem.style.display = 'block'; 
        
        return true;
    };


    /*
     * Recursively close (hide) all children of a nested <ul> menu
     */
    function close_menu (elem) {
        
        // base case
        if (typeof elem == 'undefined') {
            return true;
        }
        
        // the return value is true if and only if all children can be
        // closed recursively returning true; the return value doesn't
        // affect the process of closing the children but only tells us
        // whether something strange happened
        var returnValue = false;

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

        // get the <li>s into an Array
        var listItems = Array.prototype.slice.call(elem.childNodes);

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
     * Move menu-toggle button inside nav as root element of the menu
     */
    function set_button_as_root_menu_item() {
        
        // get the menu container
        var container = document.getElementById('primary-menu')
        // get the actual root element of the menu
        var root = container.getElementsByTagName('ul')[0];
        root.className += 'children';
        
        // create a new root
        var newRoot = document.createElement('ul');
        var newFirstChild = document.createElement('li');
        newFirstChild.className += 'page_item page_item_has_children';
        newRoot.appendChild(newFirstChild);

        // move the old root into the first child of the new root
        newFirstChild.appendChild(document.getElementById('menu-toggle'));
        newFirstChild.appendChild(root);
        
        // move the new root into the menu container
        container.appendChild(newRoot);

        // reset menu click listeners
        set_listeners();
    }


    /*
     * Move away menu-toggle button and restore original root element of the menu
     */
    function set_original_root_menu_item() {
        //@TODO make this work
        // get the menu container
        var container = document.getElementById('primary-menu')
        // get the original root element of the menu
        var root = container.getElementsByClassName('children')[0];
        root.className = '';
        root.style.display = 'block';
       
        // create a temporary container
        var tmp = document.createElement('div');
        tmp.appendChild(root);
    
        // replace the actual root
        var actualRoot = container.getElementsByTagName('ul')[0];
        container.replaceChild(root, actualRoot);

        // move the menu-toggle button to the original place
        container.parentNode.insertBefore(document.getElementById('menu-toggle'), container);

        // reset menu click listeners
        set_listeners();
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
        console.log('    menu.style.display = ' + menu.style.display)
        console.log('    submenu.style.display = ' + submenu.style.display)
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display)
        console.log('  > close_menu(submenu) = ' + close_menu(submenu));
        console.log('    menu.style.display = ' + menu.style.display)
        console.log('    submenu.style.display = ' + submenu.style.display)
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display)
        console.log('Resetting submenu.style.display to "block"');
        submenu.style.display = 'block';
        console.log('Resetting subsubmenu.style.display to "block"');
        subsubmenu.style.display = 'block';
        console.log('---');
        console.log('Testing close_menu on "menu"');
        console.log('    menu.style.display = ' + menu.style.display)
        console.log('    submenu.style.display = ' + submenu.style.display)
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display)
        console.log('  > close_menu(menu) = ' + close_menu(menu));
        console.log('    menu.style.display = ' + menu.style.display)
        console.log('    submenu.style.display = ' + submenu.style.display)
        console.log('    subsubmenu.style.display = ' + subsubmenu.style.display)
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
    set_listeners();

    window.addEventListener('resize', function(evt) {
        /* check what has to be done and call either */
        //set_original_root_menu_item();

        /* or */
        //set_button_as_root_menu_item();
        console.log(evt);
    }, true);
    
    
})();
