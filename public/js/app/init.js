import * as helper from '../helper.js';

/**
 * Provides a state-middleware to wrap async calls within a loading animation.
 *
 * @param {State} state
 * @param payload
 * @param {Function} next
 *
 * @returns {Promise<*>}
 */
async function loading(state, payload, next) {
    try {
        state.dispatch('loading', true);
        return await next(payload);
    } finally {
        state.dispatch('loading', false);
    }
}

/**
 * Registers all given backend calls as state-handlers.
 * Each called is wrapped with a loading animation.
 *
 * The map must contain the state-key as keys and the backend calls as values.
 *
 * @param {State} state
 * @param {Object<string, Function>} map
 */
export function repositories(state, map) {
    for (const [key, callback] of Object.entries(map)) {
        state.handle(key, (payload, next) => loading(state, payload, next));
        state.handle(key, callback);
    }
}

/**
 * Initializes the state with the collected page data.
 *
 * If a title is present in the loaded data, the title of the CMS page will be updated.
 *
 * @param {State} state
 */
export function state(state) {
    state.listen('page-load', (page) => {
        if (page.title) {
            helper.set('title', 'innerHTML', page.title);
        }
    });
    state.dispatch('page-load', null);
}
