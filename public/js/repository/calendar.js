import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

/**
 * Loads all calendar entries from the backend.
 *
 * @returns {Promise<[]>}
 */
export async function load() {
    return fetchJSON('/calendar/load');
}

/**
 * Saves the data for one calendar entry.
 *
 * @param {FormData} data
 *
 * @returns {Promise<*>}
 */
export async function save(data) {
    return fetchJSON('/calendar/save', {method: 'POST', body: data});
}

/**
 * Deletes one calendar entry.
 *
 * @param {integer} id
 *
 * @returns {Promise<*>}
 */
export async function remove(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/calendar/remove?' + params.toString(), {method: 'DELETE'});
}
