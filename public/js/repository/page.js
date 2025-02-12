import {fetchJSON} from '../../vendor/dscheinah/sx-js/src/fetch/json.js';

export async function load() {
    return fetchJSON('/page/load');
}

export async function save(data) {
    return fetchJSON('/page/save', {method: 'POST', body: data});
}
