import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

/**
 * Loads all galleries from the backend.
 *
 * @returns {Promise<[]>}
 */
export async function list() {
    return fetchJSON('/gallery/list');
}

/**
 * Loads one gallery from the backend.
 *
 * @param {number} id
 *
 * @returns {Promise<{}>}
 */
export async function load(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/gallery/load?' + params.toString());
}

/**
 * Saves the data for one gallery.
 *
 * @param {FormData} data
 *
 * @returns {Promise<*>}
 */
export async function save(data) {
    return fetchJSON('/gallery/save', {method: 'POST', body: data});
}

/**
 * Deletes one gallery.
 *
 * @param {number} id
 *
 * @returns {Promise<*>}
 */
export async function remove(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/gallery/remove?' + params.toString(), {method: 'DELETE'});
}
