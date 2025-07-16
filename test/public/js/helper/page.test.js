import page from 'js/helper/page.js';
import * as helper from 'js/helper.js';

const helperCreateMock = jest.mocked(helper.create);

const data = [{id: 42, name: 'name'}, {id: 43, name: 'alt'}];
const content = {type: 'text', key: 'key', value: '42', label: 'label'};


beforeEach(() => {
    jest.resetAllMocks();
    helperCreateMock.mockReturnValue(document.createElement('div'));
});

test('default', () => {
    const result = page(content, {}, 23, data);

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
    const result = page(content, {'text[key]': 43}, 23, data);

    const selected = result.querySelector('option[selected]');
    expect(selected.value).toEqual('43');
    expect(selected.innerHTML).toEqual(data[1].name);
    const button = result.querySelector('button');
    expect(button.value).toEqual('43');
});

test('without value', () => {
    const result = page({...content, value: 0}, {'text[key]': 0}, 23, data);

    const selected = result.querySelector('option[selected]');
    expect(selected).toBeFalsy();
    const button = result.querySelector('button');
    expect(button.disabled).toBeTruthy();
});

test('without label', () => {
    const result = page({...content, label: undefined}, {}, 23, data);

    const label = result.querySelector('label');
    expect(label.innerHTML).toEqual(content.key);
});
