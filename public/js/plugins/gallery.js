import Plugin from '../plugin.js';

// Use dynamic loading for galleries on show and with listen to enable re-rendering on content changes.
let data = [];

/**
 * A Plugin to render a gallery selection with quick edit button.
 */
class Gallery extends Plugin {
    /**
     * Renders the select for one gallery and provides a quick edit button.
     *
     * @param {object} helper
     * @param {PluginContent} content
     * @param {object} values
     * @param {number} index
     *
     * @returns {HTMLDivElement}
     */
    render({helper}, content, values, index) {
        const name = `${content.type}[${content.key}]`;
        // Once an unsaved change was detected, values contain the current value.
        // Use initial, saved value from backend as fallback.
        const value = parseInt(values[name] || content.value);

        // Create all options based on the loaded galleries and start with an empty, unselected state.
        const options = ['<option value="0"></option>'];
        data.forEach((entry) => {
            const selected = parseInt(entry.id) === value;
            options.push(`<option value="${entry.id}" ${selected ? 'selected' : ''}>${entry.name}</option>`);
        });

        // Render select and quick edit button, enabled if a gallery is selected.
        const element = helper.create('div');
        element.innerHTML = `
            <div class="sx-control">
                <div>
                    <select id="plugin-gallery-${index}" name="${name}">${options.join('')}</select>
                    <label for="plugin-gallery-${index}">${content.label || content.key}</label>
                </div>
                <button type="button" value="${value}" ${value ? '' : 'disabled'} data-plugin-gallery-edit>
                  <span class="sx-button-icon">✏️</span> bearbeiten
              </button>
            </div>
        `;
        return element;
    }

    /**
     * Triggers gallery loading once the page is triggered to be shown.
     *
     * @param {State} state
     */
    show({state}) {
        state.dispatch('gallery-list', null);
    }

    /**
     * Adds click handling for the edit button. Loads the gallery to edit and shows the image-gallery page.
     *
     * @param {State} state
     * @param {Page} page
     * @param {Page~action} action
     */
    action({state, page, action}) {
        action('[data-plugin-gallery-edit]', 'click', (event, target) => {
            state.dispatch('gallery-edit', true);
            state.dispatch('gallery-load', parseInt(target.value));
            page.show('images-gallery');
        });
    }

    /**
     * On state updates store the new galleries locally to be used in render.
     *
     * @param {Page~listen} listen
     */
    listen({listen}) {
        listen('gallery-list', (galleries) => data = galleries || []);
    }
}

export default new Gallery();
