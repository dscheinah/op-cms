import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

/**
 * Loads all images from the backend.
 *
 * @param {number|null} gallery
 *
 * @returns {Promise<[]>}
 */
export async function list(gallery) {
    const params = new URLSearchParams();
    if (gallery) {
        params.set('gallery', gallery.toString());
    }
    return fetchJSON('/image/list?' + params.toString());
}

/**
 * Loads one image from the backend.
 *
 * @param {number} id
 *
 * @returns {Promise<{}>}
 */
export async function load(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/image/load?' + params.toString());
}

/**
 * Saves the image data for one image.
 *
 * @param {FormData} data
 *
 * @returns {Promise<*>}
 */
export async function save(data) {
    return fetchJSON('/image/save', {method: 'POST', body: data});
}

/**
 * Deletes one image.
 *
 * @param {number} id
 *
 * @returns {Promise<*>}
 */
export async function remove(id) {
    const params = new URLSearchParams();
    params.set('id', id.toString());
    return fetchJSON('/image/remove?' + params.toString(), {method: 'DELETE'});
}
