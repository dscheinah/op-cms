import Plugin from '../plugin.js';

let counter = 0;

let data = [];

class Text extends Plugin {
    render({helper}, content) {
        counter++;

        const options = ['<option value="0"></option>'];
        data.forEach((entry) => {
            options.push(`<option value="${entry.id}" ${entry.id === content.value ? 'selected' : ''}>${entry.name}</option>`);
        });

        const element = helper.create('div');
        element.innerHTML = `
            <div class="sx-control">
                <div>
                    <select id="plugin-text-${counter}" name="${content.type}[${content.key}]">${options.join()}</select>
                    <label for="plugin-text-${counter}">${content.label || content.key}</label>
                </div>
                <button value="${content.value}" data-plugin-text-edit><span class="sx-button-icon">✏️</span> bearbeiten</button>
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
