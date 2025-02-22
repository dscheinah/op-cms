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
     * @param {integer} index
     *
     * @returns {HTMLDivElement}
     */
    render({helper}, content, values, index) {
        const name = `${content.type}[${content.key}]`;
        // Once an unsaved change was detected, values contain the current value.
        // Use initial, saved value from backend as fallback.
        const value = parseInt(values[name] || content.value);

        // Create all options based on the loaded texts and start with an empty, unselected state.
        const options = ['<option value="0"></option>'];
        data.forEach((entry) => {
            const selected = parseInt(entry.id) === value;
            options.push(`<option value="${entry.id}" ${selected ? 'selected' : ''}>${entry.name}</option>`);
        });

        // Render select and quick edit button, enabled if a text is selected.
        const element = helper.create('div');
        element.innerHTML = `
            <div class="sx-control">
                <div>
                    <select id="plugin-text-${index}" name="${name}">${options.join('')}</select>
                    <label for="plugin-text-${index}">${content.label || content.key}</label>
                </div>
                <button value="${value}" ${value ? '' : 'disabled'} data-plugin-text-edit>
                  <span class="sx-button-icon">✏️</span> bearbeiten
              </button>
            </div>
        `;
        return element;
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
