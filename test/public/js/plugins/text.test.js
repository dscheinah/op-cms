import text from 'js/plugins/text.js';
import State from 'vendor/dscheinah/sx-js/src/State.js';
import Page from 'vendor/dscheinah/sx-js/src/Page.js';
import * as helper from 'js/helper.js';

const action = jest.fn();
const listen = jest.fn();
const state = new State();
const page = new Page(state, null);

const helperCreateMock = jest.mocked(helper.create);

beforeEach(() => {
    jest.resetAllMocks();
});

describe('render', () => {
    const data = [{id: 42, name: 'name'}, {id: 43, name: 'alt'}];
    const content = {type: 'text', key: 'key', value: '42', label: 'label'};

    beforeEach(() => {
        helperCreateMock.mockReturnValueOnce(document.createElement('div'));
        text.listen({listen});
        expect(listen).toHaveBeenCalledWith('text-list', expect.any(Function));
        listen.mock.calls[0][1](data);
    });

    test('default', () => {
        const result = text.render({helper}, content, {}, 23);

        const select = result.querySelector('select');
        expect(select.name).toEqual('text[key]');
        expect(select.options).toHaveLength(3);
        const selected = result.querySelector('option[selected]');
        expect(selected.value).toEqual(content.value);
        expect(selected.innerHTML).toEqual(data[0].name);
        const label = result.querySelector('label');
        expect(label.innerHTML).toEqual(content.label);
        expect(label.getAttribute('for')).toEqual(select.id);
        const button = result.querySelector('button');
        expect(button.value).toEqual(content.value);
        expect(button.dataset.pluginTextEdit).toEqual('');
    });

    test('with values', () => {
        const result = text.render({helper}, content, {'text[key]': 43}, 23);

        const selected = result.querySelector('option[selected]');
        expect(selected.value).toEqual('43');
        expect(selected.innerHTML).toEqual(data[1].name);
        const button = result.querySelector('button');
        expect(button.value).toEqual('43');
    });

    test('without value', () => {
        const result = text.render({helper}, {...content, value: 0}, {'text[key]': 0}, 23);

        const selected = result.querySelector('option[selected]');
        expect(selected).toBeFalsy();
        const button = result.querySelector('button');
        expect(button.disabled).toBeTruthy();
    });

    test('without label', () => {
        const result = text.render({helper}, {...content, label: undefined}, {}, 23);

        const label = result.querySelector('label');
        expect(label.innerHTML).toEqual(content.key);
    });
});

test('show', () => {
    text.show({state});
    expect(state.dispatch).toHaveBeenCalledWith('text-list', null);
});

test('action', () => {
    text.action({action, page, state})
    expect(action).toHaveBeenCalledWith('[data-plugin-text-edit]', 'click', expect.any(Function));

    action.mock.calls[0][2](null, {value: '42'});

    expect(state.dispatch).toHaveBeenCalledWith('text-edit', true);
    expect(state.dispatch).toHaveBeenCalledWith('text-load', 42);
    expect(page.show).toHaveBeenCalledWith('texts-edit');
});
