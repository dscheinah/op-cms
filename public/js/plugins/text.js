import Plugin from '../plugin.js';

// Use dynamic loading for texts on show and with listen to enable re-rendering on content changes.
let data = [];

/**
 * A Plugin to render a text selection with quick edit button.
 */
class Text extends Plugin {
    /**
     * Renders the select for one text and provides a quick edit button.
     *
     * @param {object} helper
     * @param {PluginContent} content
     * @param {object} values
     * @param {number} index
     *
     * @returns {HTMLDivElement}
     */
    render({helper}, content, values, index) {
        return helper.page(content, values, index, data);
    }

    /**
     * Triggers text loading once the page is triggered to be shown.
     *
     * @param {State} state
     */
    show({state}) {
        state.dispatch('text-list', null);
    }

    /**
     * Adds click handling for the edit button. Loads the text to edit and shows the text-edit page.
     *
     * @param {State} state
     * @param {Page} page
     * @param {Page~action} action
     */
    action({state, page, action}) {
        action('[data-plugin-text-edit]', 'click', (event, target) => {
            state.dispatch('text-edit', true);
            state.dispatch('text-load', parseInt(target.value));
            page.show('texts-edit');
        });
    }

    /**
     * On state updates store the new texts locally to be used in render.
     *
     * @param {Page~listen} listen
     */
    listen({listen}) {
        listen('text-list', (texts) => data = texts || []);
    }
}

export default new Text();
