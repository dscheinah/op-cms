import Action from '../vendor/dscheinah/sx-js/src/Action.js';
import Page from '../vendor/dscheinah/sx-js/src/Page.js';
import State from '../vendor/dscheinah/sx-js/src/State.js';
import navigate from './app/navigate.js';
import * as init from './app/init.js';
import * as PageRepository from './repository/page.js';
import * as TextRepository from './repository/text.js';
import * as ImageRepository from './repository/image.js';
import * as GalleryRepository from './repository/gallery.js';
import * as CalendarRepository from './repository/calendar.js';
// By separating the helpers to its own namespace they do not need to be packed to an object here.
import * as helper from './helper.js';
import * as plugins from './plugins.js';

// Only allow one app to be run. This may happen if browser cache loads an outdated page for some reason.
if (window.sxAppInitialized) {
    throw new Error('Tried to access a cached app. Please reload the page.');
}
window.sxAppInitialized = true;

// Create the global event listener (on the window) to be used for e.g., navigation.
const action = new Action(window);
// The repository that will handle the requests to the backend.
// Create the global state manager.
const state = new State();
// Create the page manager responsible for lazy loading pages and handling the history and page stack.
// The state manager is used to trigger sx-show and sx-hide when the state of pages changes.
// The state event gets the ID of the page as payload.
const page = new Page(state, helper.element('#main'));

// Handle the global navigation. This also handles links in pages automatically.
// To add a link use <button value="${id}" data-navigation>...</button>.
// The IDs must correspond with the pages defined later in this file.
action.listen('[data-navigation]', 'click', (event, target) => navigate(state, page, event, target));
// The navigation-back button is invisible but keyboard controllable.
action.listen('#navigation-back', 'click', () => history.back());

// A global state handler to show the loading animation.
// Use state.dispatch('loading', true) to trigger the animation and state.dispatch('loading', false) to stop it.
state.handle('loading', (payload, next) => {
    // The element is hidden by using visibility to not need extra CSS for positioning of the menu entries.
    helper.style('#loading', 'visibility', payload ? null : 'hidden');
    return next(payload);
});
// Always disable the loading animation when any loaded page is ready.
state.listen('sx-show', () => state.dispatch('loading', false));

// Initialize backend and page state.
init.repositories(state, {
    'page-load': PageRepository.load,
    'page-save': PageRepository.save,
    'text-list': TextRepository.list,
    'text-load': TextRepository.load,
    'text-save': TextRepository.save,
    'text-remove': TextRepository.remove,
    'image-list': ImageRepository.list,
    'image-load': ImageRepository.load,
    'image-save': ImageRepository.save,
    'image-remove': ImageRepository.remove,
    'gallery-list': GalleryRepository.list,
    'gallery-load': GalleryRepository.load,
    'gallery-save': GalleryRepository.save,
    'gallery-remove': GalleryRepository.remove,
    'calendar-load': CalendarRepository.load,
    'calendar-save': CalendarRepository.save,
    'calendar-remove': CalendarRepository.remove,
    // Add more backend calls here if needed.
});
init.state(state);

// Define all pages and load the main page. The ID defined here is globally used for:
//  - handling navigation by href or value (see above)
//  - registering scopes in pages
//  - payload of sx-show and sx-hide state events
// For real routing you can replace window.location.href with custom paths for each page.
page.add('page', 'pages/page.html', window.location.href);
page.add('texts', 'pages/texts.html', window.location.href);
page.add('texts-edit', 'pages/texts/edit.html', window.location.href);
page.add('images', 'pages/images.html', window.location.href);
page.add('images-edit', 'pages/images/edit.html', window.location.href);
page.add('images-gallery', 'pages/images/gallery.html', window.location.href);
page.add('calendar', 'pages/calendar.html', window.location.href);
page.add('calendar-edit', 'pages/calendar/edit.html', window.location.href);
// Add more plugin configuration pages here if needed.

// If used with routing, this must be replaced with a check on the called route.
page.show('page');

// The app.js file is used as a kind of service manager for dependency injection.
// Import the file in pages to get access to the exported modules.
export {helper, page, state, plugins};
