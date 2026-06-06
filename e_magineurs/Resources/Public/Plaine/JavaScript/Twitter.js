// Suppress Twitter widget 429 errors (rate limiting)
(function() {
    'use strict';
    if (typeof window === 'undefined') return;
    
    // Suppress all Twitter-related network errors
    const suppressTwitter = function(str) {
        if (!str) return false;
        const s = String(str).toLowerCase();
        return s.indexOf('twitter') !== -1 || 
               s.indexOf('syndication.twitter') !== -1 ||
               s.indexOf('platform.twitter') !== -1 ||
               (s.indexOf('dnt=') !== -1 && s.indexOf('embedid') !== -1) ||
               (s.indexOf('plainecommune') !== -1 && s.indexOf('dnt=') !== -1) ||
               s.indexOf('429') !== -1 ||
               (s.indexOf('failed to load resource') !== -1 && s.indexOf('429') !== -1);
    };
    
    // Suppress error events (capture phase - earliest possible)
    window.addEventListener('error', function(e) {
        let url = '';
        if (e.target) {
            url = e.target.src || e.target.href || e.target.getAttribute('src') || '';
            // Check iframe contentWindow for cross-origin errors
            if (e.target.tagName && e.target.tagName.toLowerCase() === 'iframe') {
                try {
                    if (e.target.contentWindow && e.target.contentWindow.location) {
                        url += ' ' + e.target.contentWindow.location.href;
                    }
                } catch (err) {
                    // Cross-origin iframe, can't access
                }
            }
        }
        const msg = e.message || '';
        const file = e.filename || e.source || '';
        const combined = url + ' ' + msg + ' ' + file;
        if (suppressTwitter(combined)) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return true;
        }
    }, true);
    
    // Also catch in bubble phase
    window.addEventListener('error', function(e) {
        const url = e.target ? (e.target.src || e.target.href || '') : '';
        const msg = e.message || '';
        const file = e.filename || '';
        if (suppressTwitter(url + msg + file)) {
            e.preventDefault();
            e.stopPropagation();
            return true;
        }
    }, false);
    
    // Suppress console errors and warnings
    const origError = console.error;
    const origWarn = console.warn;
    console.error = function(...args) {
        if (!suppressTwitter(args.join(' '))) origError.apply(console, args);
    };
    console.warn = function(...args) {
        if (!suppressTwitter(args.join(' '))) origWarn.apply(console, args);
    };
    
    // Suppress unhandled promise rejections
    window.addEventListener('unhandledrejection', function(e) {
        const reason = String(e.reason || '').toLowerCase();
        if (suppressTwitter(reason)) {
            e.preventDefault();
            return true;
        }
    });
    
    // Intercept iframe creation to prevent Twitter widget errors
    if (document.createElement) {
        const originalCreateElement = document.createElement;
        document.createElement = function(tagName) {
            const element = originalCreateElement.call(this, tagName);
            if (tagName && tagName.toLowerCase() === 'iframe') {
                const originalSetAttribute = element.setAttribute;
                element.setAttribute = function(name, value) {
                    if (name && name.toLowerCase() === 'src' && suppressTwitter(String(value))) {
                        // Don't set src for Twitter widgets to prevent errors
                        element.addEventListener('error', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }, true);
                        return;
                    }
                    return originalSetAttribute.apply(this, arguments);
                };
            }
            return element;
        };
    }
    
    // Use MutationObserver to catch Twitter widgets added dynamically
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check iframes
                        if (node.tagName && node.tagName.toLowerCase() === 'iframe') {
                            const src = node.src || node.getAttribute('src') || '';
                            if (suppressTwitter(src)) {
                                node.addEventListener('error', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                }, true);
                            }
                        }
                        // Check for Twitter widgets inside
                        if (node.querySelectorAll) {
                            const iframes = node.querySelectorAll('iframe');
                            for (let i = 0; i < iframes.length; i++) {
                                const iframe = iframes[i];
                                const src = iframe.src || iframe.getAttribute('src') || '';
                                if (suppressTwitter(src)) {
                                    iframe.addEventListener('error', function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                    }, true);
                                }
                            }
                        }
                    }
                });
            });
        });
        // Start observing when DOM is ready
        function startObserving() {
            if (document.body) {
                observer.observe(document.body, { childList: true, subtree: true });
            } else if (document.documentElement) {
                observer.observe(document.documentElement, { childList: true, subtree: true });
            }
        }
        if (document.body || document.documentElement) {
            startObserving();
        } else {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', startObserving);
            } else {
                // DOM already loaded
                setTimeout(startObserving, 0);
            }
        }
    }
})();
