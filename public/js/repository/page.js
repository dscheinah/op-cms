import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

/**
 * Proxy page load to backend.
 *
 * @returns {Promise<{}>}
 */
export async function load() {
    return fetchJSON('/page/load');
}

/**
 * Saves the given page data.
 *
 * @param {FormData} data
 *
 * @returns {Promise<*>}
 */
export async function save(data) {
    return fetchJSON('/page/save', {method: 'POST', body: data});
}
