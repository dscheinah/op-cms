import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

/**
 * Loads all texts from the backend.
 *
 * @returns {Promise<[]>}
 */
export async function list() {
    return fetchJSON('/text/list');
}

/**
 * Loads one text from the backend.
 *
 * @param {integer} id
 *
 * @returns {Promise<{}>}
 */
export async function load(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/text/load?' + params.toString());
}

/**
 * Saves the text data for one text.
 *
 * @param {FormData} data
 *
 * @returns {Promise<*>}
 */
export async function save(data) {
    return fetchJSON('/text/save', {method: 'POST', body: data});
}

/**
 * Deletes one text.
 *
 * @param {integer} id
 *
 * @returns {Promise<*>}
 */
export async function remove(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/text/remove?' + params.toString(), {method: 'DELETE'});
}
