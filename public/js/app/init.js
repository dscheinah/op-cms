import * as helper from '../helper.js';

async function loading(state, payload, next) {
    try {
        state.dispatch('loading', true);
        return await next(payload);
    } finally {
        state.dispatch('loading', false);
    }
}

export function repositories(state, map) {
    for (const [key, callback] of Object.entries(map)) {
        state.handle(key, (payload, next) => loading(state, payload, next));
        state.handle(key, callback);
    }
}

export function state(state) {
    state.listen('page-load', (page) => {
        if (page.title) {
            helper.set('title', 'innerHTML', page.title);
        }
    });
    state.dispatch('page-load', null);
}
