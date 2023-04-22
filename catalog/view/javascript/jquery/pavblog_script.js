 

(function($) {
	$.fn.extend({
		// nextUntil is necessary, would be nice to have this in $ core
		nextUntil: function(expr) {
			var match = [];
		
			// We need to figure out which elements to push onto the array
			this.each(function(){
				// Traverse through the sibling nodes
				for( var i = this.nextSibling; i; i = i.nextSibling ) {
					// Make sure that we're only dealing with elements
					if ( i.nodeType != 1 ) continue;
		
					// If we find a match then we need to stop
					//if ( $.filter( expr, [i] ).r.length ) break;
		
					// Otherwise, add it on to the stack
					match.push( i );
				}
			});
		
			return this.pushStack( match );
		},
		// the plugin method itself
		Accordion: function(settings) {
			// setup configuration
			settings = $.extend({}, $.Accordion.defaults, {
				// define context defaults
				header: $(':first-child', this)[0].tagName // take first childs tagName as header
			}, settings);

			// calculate active if not specified, using the first header
			var container = this,
				active = settings.active
					? $(settings.active, this)
					: settings.active === false
						? $("<div>")
						: $(settings.header, this).eq(0),
				running = 0;

			container.find(settings.header)
				.not(active || "")
				.nextUntil(settings.header)
				.hide();
			active.addClass(settings.selectedClass);

			function clickHandler(event) {
				// get the click target
				var clicked = $(event.target);
				
				// due to the event delegation model, we have to check if one
				// of the parent elements is our actual header, and find that
				if ( clicked.parents(settings.header).length ) {
					while ( !clicked.is(settings.header) ) {
						clicked = clicked.parent();
					}
				}
				
				var clickedActive = clicked[0] == active[0];
				
				// if animations are still active, or the active header is the target, ignore click
				if(running || (settings.alwaysOpen && clickedActive) || !clicked.is(settings.header))
					return;

				// switch classes
				active.toggleClass(settings.selectedClass);
				if ( !clickedActive ) {
					clicked.addClass(settings.selectedClass);
				}

				// find elements to show and hide
				var toShow = clicked.nextUntil(settings.header),
					toHide = active.nextUntil(settings.header),
					data = [clicked, active, toShow, toHide];
				active = clickedActive ? $([]) : clicked;
				// count elements to animate
				running = toHide.size() + toShow.size();
				var finished = function(cancel) {
					running = cancel ? 0 : --running;
					if ( running )
						return;

					// trigger custom change event
					container.trigger("change", data);
				};
				// TODO if hideSpeed is set to zero, animations are crappy
				// workaround: use hide instead
				// solution: animate should check for speed of 0 and do something about it
				if ( settings.animated ) {
					if ( !settings.alwaysOpen && clickedActive ) {
						toShow.slideToggle(settings.showSpeed);
						finished(true);
					} else {
						toHide.filter(":hidden").each(finished).end().filter(":visible").slideUp(settings.hideSpeed, finished);
						toShow.slideDown(settings.showSpeed, finished);
					}
				} else {
					if ( !settings.alwaysOpen && clickedActive ) {
						toShow.toggle();
					} else {
						toHide.hide();
						toShow.show();
					}
					finished(true);
				}

				return false;
			};
			function activateHandlder(event, index) {
				// call clickHandler with custom event
				clickHandler({
					target: $(settings.header, this)[index]
				});
			};

			return container
				.bind(settings.event, clickHandler)
				.bind("activate", activateHandlder);
		},
		// programmatic triggering
		activate: function(index) {
			return this.trigger('activate', [index || 0]);
		}
	});

	$.Accordion = {};
	$.extend($.Accordion, {
		defaults: {
			selectedClass: "selected",
			showSpeed: 'slow',
			hideSpeed: 'fast',
			alwaysOpen: true,
			animated: true,
			event: "click"
		},
		setDefaults: function(settings) {
			$.extend($.Accordion.defaults, settings);
		}
	});
})(jQuery);