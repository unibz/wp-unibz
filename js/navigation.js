/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
    
    function toggle(elem) {
        elem.style.display = (elem.style.display=='none')?'block':'none';
    }

    function setupChildren(listItem, isRoot){
        
        // we do something only if the list item has children
        if(listItem.className.indexOf('page_item_has_children') == -1){
            return;
        }
        
        // remove the href from the link
        listItem.getElementsByTagName('a')[0].href='#';

        // get the children container node
        var childrenContainer = listItem.getElementsByTagName('ul')[0];

        // set the parent to show the childrenContainer on click
        if(isRoot==true) {
            listItem.onclick = function(event) {
                event.stopPropagation();
                childrenContainer.style.top = document.getElementById('masthead').getBoundingClientRect().bottom+"px";
                toggle(childrenContainer);
            }
        }
        else {
            listItem.onclick = function(event) {
                event.stopPropagation();
                childrenContainer.style.top =
                    listItem.parentNode.getBoundingClientRect().height +"px";
                toggle(childrenContainer);
            }
        }

        // recursive call on the children
        var children = childrenContainer.childNodes;
        for(var i=0; i<children.length; i++){
            setupChildren(children[i], false);
        }
    }
	
    var container, button, menu, children;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

    children = menu.childNodes;
    for(var i=0; i<children.length; i++){
        setupChildren(children[i], true);
    }

    children = menu.getElementsByClassName('children');
    for(var i=0; i<children.length; i++){
        toggle(children[i]);
    }

} )();
