import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

export async function list() {
    return fetchJSON('/text/list');
}

export async function load(id) {
    const params = new URLSearchParams();
    params.set('id', id);
    return fetchJSON('/text/load?' + params.toString());
}

export async function save(data) {
    return fetchJSON('/text/save', {method: 'POST', body: data});
}

export async function remove(id) {
    const params = new URLSearchParams();
    params.set('id', id);
    return fetchJSON('/text/remove?' + params.toString(), {method: 'DELETE'});
}
