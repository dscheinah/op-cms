import Plugin from '../plugin.js';

let data = [];

class Text extends Plugin {
    render({helper}, content, values, index) {
        const name = `${content.type}[${content.key}]`;
        const value = parseInt(values[name] || content.value);

        const options = ['<option value="0"></option>'];
        data.forEach((entry) => {
            const selected = parseInt(entry.id) === value;
            options.push(`<option value="${entry.id}" ${selected ? 'selected' : ''}>${entry.name}</option>`);
        });

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

    show({state}) {
        state.dispatch('text-list', null);
    }

    action({state, page, action}) {
        action('[data-plugin-text-edit]', 'click', (event, target) => {
            state.dispatch('text-edit', true);
            state.dispatch('text-load', parseInt(target.value));
            page.show('texts-edit');
        });
    }

    listen({listen}) {
        listen('text-list', (texts) => data = texts || []);
    }
}

export default new Text();
