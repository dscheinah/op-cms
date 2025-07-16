import Plugin from '../plugin.js';

// Use dynamic loading for images on show and with listen to enable re-rendering on content changes.
let data = [];

/**
 * A Plugin to render an image selection with quick edit button.
 */
class Image extends Plugin {
    /**
     * Renders the select for one image and provides a quick edit button.
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
     * Triggers image loading once the page is triggered to be shown.
     *
     * @param {State} state
     */
    show({state}) {
        state.dispatch('image-list', null);
    }

    /**
     * Adds click handling for the edit button. Loads the image to edit and shows the image-edit page.
     *
     * @param {State} state
     * @param {Page} page
     * @param {Page~action} action
     */
    action({state, page, action}) {
        action('[data-plugin-image-edit]', 'click', (event, target) => {
            state.dispatch('image-edit', true);
            state.dispatch('image-load', parseInt(target.value));
            page.show('images-edit');
        });
    }

    /**
     * On state updates store the new images locally to be used in render.
     *
     * @param {Page~listen} listen
     */
    listen({listen}) {
        listen('image-list', (images) => data = images || []);
    }
}

export default new Image();
