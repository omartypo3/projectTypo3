/*!
Split Pane v0.9.4
Copyright (c) 2014 - 2016 Simon Hagström
Released under the MIT license
https://raw.github.com/shagstrom/split-pane/master/LICENSE
*/

(function ($) {

	'use strict';

	var methodsKanban = {};

	methodsKanban.init = function() {
		var $kanbanSplitPanes = this;
		$kanbanSplitPanes.each(setMinHeightAndMinWidth);
		$kanbanSplitPanes.children('.kanban-split-pane-divider').html('<div class="kanban-split-pane-divider-inner"></div>');
		$kanbanSplitPanes.children('.kanban-split-pane-divider').on('touchstart mousedown', mousedownHandler);
		setTimeout(function() {
			// Doing this later because of an issue with Chrome (v23.0.1271.64) returning split-pane width = 0
			// and triggering multiple resize events when page is being opened from an <a target="_blank"> .
			$kanbanSplitPanes.each(attachResizeHandler);
			$(window).trigger('resize');
		}, 100);
	};

	methodsKanban.firstComponentSize = function(value) {
		this.each(function() {
			var $kanbanSplitPane = $(this),
				components = getComponents($kanbanSplitPane);
			if ($kanbanSplitPane.is('.fixed-top')) {
				fixedTopHandler(components, components.divider.offsetTop)({pageY: value});
			} else if ($kanbanSplitPane.is('.fixed-bottom')) {
				value = components.kanbanSplitPane.offsetHeight -components.divider.offsetHeight - value;
				fixedBottomHandler(components, -components.last.offsetHeight)({pageY: -value});
			} else if ($kanbanSplitPane.is('.horizontal-percent')) {
				value = components.kanbanSplitPane.offsetHeight -components.divider.offsetHeight - value;
				horizontalPercentHandler(components, -components.last.offsetHeight)({pageY: -value});
			} else if ($kanbanSplitPane.is('.fixed-left')) {
				fixedLeftHandler(components, components.divider.offsetLeft)({pageX: value});
			} else if ($kanbanSplitPane.is('.fixed-right')) {
				value = components.kanbanSplitPane.offsetWidth -components.divider.offsetWidth - value;
				fixedRightHandler(components, -components.last.offsetWidth)({pageX: -value});
			} else if ($kanbanSplitPane.is('.vertical-percent')) {
				value = components.kanbanSplitPane.offsetWidth -components.divider.offsetWidth - value;
				verticalPercentHandler(components, -components.last.offsetWidth)({pageX: -value});
			}
		});
	};

	methodsKanban.lastComponentSize = function(value) {
		this.each(function() {
			var $kanbanSplitPane = $(this),
				components = getComponents($kanbanSplitPane);
			if ($kanbanSplitPane.is('.fixed-top')) {
				value = components.kanbanSplitPane.offsetHeight -components.divider.offsetHeight - value;
				fixedTopHandler(components, components.divider.offsetTop)({pageY: value});
			} else if ($kanbanSplitPane.is('.fixed-bottom')) {
				fixedBottomHandler(components, -components.last.offsetHeight)({pageY: -value});
			} else if ($kanbanSplitPane.is('.horizontal-percent')) {
				horizontalPercentHandler(components, -components.last.offsetHeight)({pageY: -value});
			} else if ($kanbanSplitPane.is('.fixed-left')) {
				value = components.kanbanSplitPane.offsetWidth -components.divider.offsetWidth - value;
				fixedLeftHandler(components, components.divider.offsetLeft)({pageX: value});
			} else if ($kanbanSplitPane.is('.fixed-right')) {
				fixedRightHandler(components, -components.last.offsetWidth)({pageX: -value});
			} else if ($kanbanSplitPane.is('.vertical-percent')) {
				verticalPercentHandler(components, -components.last.offsetWidth)({pageX: -value});
			}
		});
	};

	$.fn.kanbanSplitPane = function(method) {
		methodsKanban[method || 'init'].apply(this, $.grep(arguments, function(it, i) { return i > 0; }));
	};

	function setMinHeightAndMinWidth() {
		var $kanbanSplitPane = $(this),
			components = getComponents($kanbanSplitPane);
		if ($kanbanSplitPane.is('.fixed-top, .fixed-bottom, .horizontal-percent')) {
			$kanbanSplitPane.css('min-height', (minHeight(components.first) + minHeight(components.last) + $(components.divider).height()) + 'px');
		} else {
			$kanbanSplitPane.css('min-width', (minWidth(components.first) + minWidth(components.last) + $(components.divider).width()) + 'px');
		}
	}

	function mousedownHandler(event) {
		event.preventDefault();
		var $divider = $(this),
			$kanbanSplitPane = $divider.parent();
		$divider.addClass('dragged');
		if (event.type.match(/^touch/)) {
			$divider.addClass('touch');
		}
		var moveEventHandler = createMousemove($kanbanSplitPane, pageXof(event), pageYof(event));
		$(document).on('touchmove mousemove', moveEventHandler);
		$(document).one('touchend mouseup', function(event) {
			$(document).off('touchmove mousemove', moveEventHandler);
			$divider.removeClass('dragged touch');
			$kanbanSplitPane.trigger('dividerdragend', [ getComponentsSizes($kanbanSplitPane) ]);
		});
		$kanbanSplitPane.trigger('dividerdragstart', [ getComponentsSizes($kanbanSplitPane) ]);
	}

	function getComponentsSizes($kanbanSplitPane) {
		var property = $kanbanSplitPane.is('.fixed-top, .fixed-bottom, .horizontal-percent') ?
			'height' : 'width';
		return {
			firstComponentSize: parseInt($kanbanSplitPane.find('.kanban-split-pane-component:first').css(property), 10),
			lastComponentSize: parseInt($kanbanSplitPane.find('.kanban-split-pane-component:last').css(property), 10)
		};
	}

	function attachResizeHandler() {
		var $kanbanSplitPane = $(this),
			internalHandler = createParentresizeHandler($kanbanSplitPane),
			parent = $kanbanSplitPane.parent().closest('.kanban-split-pane')[0] || window;
		$(parent).on(parent === window ? 'resize' : 'kanbansplitpaneresize', function(event) {
			var target = event.target === document ? window : event.target;
			if (target === parent) {
				internalHandler(event);
			}
		});
	}

	function createParentresizeHandler($kanbanSplitPane) {
		var components = getComponents($kanbanSplitPane);
		if ($kanbanSplitPane.is('.fixed-top')) {
			return function(event) {
				var lastComponentMinHeight = minHeight(components.last),
					maxfirstComponentHeight = components.kanbanSplitPane.offsetHeight - lastComponentMinHeight -  components.divider.offsetHeight;
				if (components.first.offsetHeight > maxfirstComponentHeight) {
					setTop(components, maxfirstComponentHeight + 'px');
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		} else if ($kanbanSplitPane.is('.fixed-bottom')) {
			return function(event) {
				var firstComponentMinHeight = minHeight(components.first),
					maxLastComponentHeight = components.kanbanSplitPane.offsetHeight - firstComponentMinHeight -  components.divider.offsetHeight;
				if (components.last.offsetHeight > maxLastComponentHeight) {
					setBottom(components, maxLastComponentHeight + 'px');
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		} else if ($kanbanSplitPane.is('.horizontal-percent')) {
			return function(event) {
				var lastComponentMinHeight = minHeight(components.last),
					firstComponentMinHeight = minHeight(components.first),
					maxLastComponentHeight = components.kanbanSplitPane.offsetHeight - firstComponentMinHeight -  components.divider.offsetHeight;
				if (components.last.offsetHeight > maxLastComponentHeight) {
					setBottom(components, (maxLastComponentHeight / components.kanbanSplitPane.offsetHeight * 100) + '%');
				} else {
					if (components.kanbanSplitPane.offsetHeight - components.first.offsetHeight -  components.divider.offsetHeight < lastComponentMinHeight) {
						setBottom(components, (lastComponentMinHeight / components.kanbanSplitPane.offsetHeight * 100) + '%');
					}
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		} else if ($kanbanSplitPane.is('.fixed-left')) {
			return function(event) {
				var lastComponentMinWidth = minWidth(components.last),
					maxFirstComponentWidth = components.kanbanSplitPane.offsetWidth - lastComponentMinWidth -  components.divider.offsetWidth;
				if (components.first.offsetWidth > maxFirstComponentWidth) {
					setLeft(components, maxFirstComponentWidth + 'px');
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		} else if ($kanbanSplitPane.is('.fixed-right')) {
			return function(event) {
				var firstComponentMinWidth = minWidth(components.first),
					maxLastComponentWidth = components.kanbanSplitPane.offsetWidth - firstComponentMinWidth -  components.divider.offsetWidth;
				if (components.last.offsetWidth > maxLastComponentWidth) {
					setRight(components, maxLastComponentWidth + 'px');
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		} else if ($kanbanSplitPane.is('.vertical-percent')) {
			return function(event) {
				var lastComponentMinWidth = minWidth(components.last),
					firstComponentMinWidth = minWidth(components.first),
					maxLastComponentWidth = components.kanbanSplitPane.offsetWidth - firstComponentMinWidth -  components.divider.offsetWidth;
				if (components.last.offsetWidth > maxLastComponentWidth) {
					setRight(components, (maxLastComponentWidth / components.kanbanSplitPane.offsetWidth * 100) + '%');
				} else {
					if (components.kanbanSplitPane.offsetWidth - components.first.offsetWidth -  components.divider.offsetWidth < lastComponentMinWidth) {
						setRight(components, (lastComponentMinWidth / components.kanbanSplitPane.offsetWidth * 100) + '%');
					}
				}
				$kanbanSplitPane.trigger('kanbansplitpaneresize', [ getComponentsSizes($kanbanSplitPane) ]);
			};
		}
	}

	function createMousemove($kanbanSplitPane, pageX, pageY) {
		var components = getComponents($kanbanSplitPane);
		if ($kanbanSplitPane.is('.fixed-top')) {
			return fixedTopHandler(components, pageY);
		} else if ($kanbanSplitPane.is('.fixed-bottom')) {
			return fixedBottomHandler(components, pageY);
		} else if ($kanbanSplitPane.is('.horizontal-percent')) {
			return horizontalPercentHandler(components, pageY);
		} else if ($kanbanSplitPane.is('.fixed-left')) {
			return fixedLeftHandler(components, pageX);
		} else if ($kanbanSplitPane.is('.fixed-right')) {
			return fixedRightHandler(components, pageX);
		} else if ($kanbanSplitPane.is('.vertical-percent')) {
			return verticalPercentHandler(components, pageX);
		}
	}

	function fixedTopHandler(components, pageY) {
		var firstComponentMinHeight =  minHeight(components.first),
			maxFirstComponentHeight = components.kanbanSplitPane.offsetHeight - minHeight(components.last) - components.divider.offsetHeight,
			topOffset = components.divider.offsetTop - pageY;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var top = newTop(firstComponentMinHeight, maxFirstComponentHeight, topOffset + pageYof(event));
			setTop(components, top + 'px');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function fixedBottomHandler(components, pageY) {
		var lastComponentMinHeight = minHeight(components.last),
			maxLastComponentHeight = components.kanbanSplitPane.offsetHeight - minHeight(components.first) - components.divider.offsetHeight,
			bottomOffset = components.last.offsetHeight + pageY;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var bottom = Math.min(Math.max(lastComponentMinHeight, bottomOffset - pageYof(event)), maxLastComponentHeight);
			setBottom(components, bottom + 'px');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function horizontalPercentHandler(components, pageY) {
		var splitPaneHeight = components.kanbanSplitPane.offsetHeight,
			lastComponentMinHeight = minHeight(components.last),
			maxLastComponentHeight = splitPaneHeight - minHeight(components.first) - components.divider.offsetHeight,
			bottomOffset = components.last.offsetHeight + pageY;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var bottom = Math.min(Math.max(lastComponentMinHeight, bottomOffset - pageYof(event)), maxLastComponentHeight);
			setBottom(components, (bottom / splitPaneHeight * 100) + '%');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function fixedLeftHandler(components, pageX) {
		var firstComponentMinWidth = minWidth(components.first),
			maxFirstComponentWidth = components.kanbanSplitPane.offsetWidth - minWidth(components.last) - components.divider.offsetWidth,
			leftOffset = components.divider.offsetLeft - pageX;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var left = newLeft(firstComponentMinWidth, maxFirstComponentWidth, leftOffset + pageXof(event));
			setLeft(components, left + 'px');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function fixedRightHandler(components, pageX) {
		var lastComponentMinWidth = minWidth(components.last),
			maxLastComponentWidth = components.kanbanSplitPane.offsetWidth - minWidth(components.first) - components.divider.offsetWidth,
			rightOffset = components.last.offsetWidth + pageX;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var right = Math.min(Math.max(lastComponentMinWidth, rightOffset - pageXof(event)), maxLastComponentWidth);
			setRight(components, right + 'px');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function verticalPercentHandler(components, pageX) {
		var splitPaneWidth = components.kanbanSplitPane.offsetWidth,
			lastComponentMinWidth = minWidth(components.last),
			maxLastComponentWidth = splitPaneWidth - minWidth(components.first) - components.divider.offsetWidth,
			rightOffset = components.last.offsetWidth + pageX;
		return function(event) {
			event.preventDefault && event.preventDefault();
			var right = Math.min(Math.max(lastComponentMinWidth, rightOffset - pageXof(event)), maxLastComponentWidth);
			setRight(components, (right / splitPaneWidth * 100) + '%');
			$(components.kanbanSplitPane).trigger('kanbansplitpaneresize', [ getComponentsSizes($(components.kanbanSplitPane)) ]);
		};
	}

	function getComponents($kanbanSplitPane) {
		return {
			kanbanSplitPane: $kanbanSplitPane[0],
			first: $kanbanSplitPane.children('.kanban-split-pane-component:first')[0],
			divider: $kanbanSplitPane.children('.kanban-split-pane-divider')[0],
			last: $kanbanSplitPane.children('.kanban-split-pane-component:last')[0]
		};
	}

	function pageXof(event) {
		if (event.pageX !== undefined) {
			return event.pageX;
		} else if (event.originalEvent.pageX !== undefined) {
			return event.originalEvent.pageX;
		} else if (event.originalEvent.touches) {
			return event.originalEvent.touches[0].pageX;
		}
	}

	function pageYof(event) {
		if (event.pageY !== undefined) {
			return event.pageY;
		} else if (event.originalEvent.pageY !== undefined) {
			return event.originalEvent.pageY;
		} else if (event.originalEvent.touches) {
			return event.originalEvent.touches[0].pageY;
		}
	}

	function minHeight(element) {
		return parseInt($(element).css('min-height'), 10) || 0;
	}

	function minWidth(element) {
		return parseInt($(element).css('min-width'), 10) || 0;
	}

	function maxHeight(element) {
		return parseInt($(element).css('max-height'), 10);
	}

	function maxWidth(element) {
		return parseInt($(element).css('max-width'), 10);
	}

	function newTop(firstComponentMinHeight, maxFirstComponentHeight, value) {
		return Math.min(Math.max(firstComponentMinHeight, value), maxFirstComponentHeight);
	}

	function newLeft(firstComponentMinWidth, maxFirstComponentWidth, value) {
		return Math.min(Math.max(firstComponentMinWidth, value), maxFirstComponentWidth);
	}
	function setTop(components, top) {
		components.first.style.height = top;
		components.divider.style.top = top;
		components.last.style.top = top;
	}

	function setBottom(components, bottom) {
		components.first.style.bottom = bottom;
		components.divider.style.bottom = bottom;
		components.last.style.height = bottom;
	}

	function setLeft(components, left) {
		components.first.style.width = left;
		components.divider.style.left = left;
		components.last.style.left = left;
	}

	function setRight(components, right) {
		components.first.style.right = right;
		components.divider.style.right = right;
		components.last.style.width = right;
	}

})(jQuery);