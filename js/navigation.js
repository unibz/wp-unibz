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

    function setupChildren(parentLI){
        if(parentLI.className.indexOf('page_item_has_children')!=-1){
            parentLI.getElementsByTagName('a')[0].href='#';
        }

        var childUL = parentLI.getElementsByTagName('ul')[0];

        if(typeof childUL == 'undefined'){
            return;
        }
        else{
            childUL.style.display='none';
        }

        parentLI.onclick = function(event) {
            event.stopPropagation();
            toggle(childUL);
        }

        var children = childUL.childNodes;
        for(var i=0; i<children.length; i++){
            setupChildren(children[i]);
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

    children = menu.getElementsByTagName('li');

    for(var i=0; i<children.length; i++){
        setupChildren(children[i]);
    }

} )();
