import {create} from '../helper.js';

/**
 * Common page plugin code to render content selection with edit button.
 *
 * @param {PluginContent} content
 * @param {object} values
 * @param {number} index
 * @param {Array<{id: string, name: string}>} data
 *
 * @returns {HTMLDivElement}
 */
export default function page(content, values, index, data) {
    const name = `${content.type}[${content.key}]`;
    // Once an unsaved change was detected, values contain the current value.
    // Use initial, saved value from backend as fallback.
    const value = parseInt(values[name] || content.value);

    // Create all options based on the loaded data and start with an empty, unselected state.
    const options = ['<option value="0"></option>'];
    data.forEach((entry) => {
        const selected = parseInt(entry.id) === value;
        options.push(`<option value="${entry.id}" ${selected ? 'selected' : ''}>${entry.name}</option>`);
    });

    // Render select and quick edit button, enabled if an option is selected.
    const element = create('div');
    element.innerHTML = `
        <div class="sx-control">
            <div>
                <select id="plugin-${content.type}-${index}" name="${name}">${options.join('')}</select>
                <label for="plugin-${content.type}-${index}">${content.label || content.key}</label>
            </div>
            <button type="button" value="${value}" ${value ? '' : 'disabled'} data-plugin-${content.type}-edit>
              <span class="sx-button-icon">✏️</span> bearbeiten
          </button>
        </div>
    `;
    return element;
}
