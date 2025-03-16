import Plugin from '../plugin.js';

/**
 * A Plugin to render a placeholder for calendar entries as navigation button.
 */
class Calendar extends Plugin {
    /**
     * Renders the placeholder with a useful label.
     *
     * @param {object} helper
     * @param {PluginContent} content
     * @param {object} values
     * @param {integer} index
     *
     * @returns {HTMLDivElement}
     */
    render({helper}, content, values, index) {
        const translations = {
            next: `Nächste Termine (${content.value})`,
            list: 'Anstehende Termine',
        };
        const element = helper.create('div');
        element.innerHTML = `
            <p>
                <button data-navigation value="calendar">
                    <span class="sx-button-icon">📅</span>  ${translations[content.key] || 'Termine'}
                </button>   
            </p>
        `;
        return element;
    }
}

export default new Calendar();
