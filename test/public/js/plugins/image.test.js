import image from 'js/plugins/image.js';
import State from 'vendor/dscheinah/sx-js/src/State.js';
import Page from 'vendor/dscheinah/sx-js/src/Page.js';
import * as helper from 'js/helper.js';

const action = jest.fn();
const listen = jest.fn();
const state = new State();
const page = new Page(state, null);

const helperPageMock = jest.mocked(helper.page);

beforeEach(() => {
    jest.resetAllMocks();
});

test('listen and render', () => {
    const data = [{id: 42, name: 'name'}, {id: 43, name: 'alt'}];
    const content = {type: 'image', key: 'key', value: '42', label: 'label'};

    image.listen({listen});
    expect(listen).toHaveBeenCalledWith('image-list', expect.any(Function));
    listen.mock.calls[0][1](data);

    const expected = document.createElement('div');
    helperPageMock.mockReturnValueOnce(expected);

    const result = image.render({helper}, content, {a: 'b'}, 23);
    expect(result).toEqual(expected);
    expect(helperPageMock).toHaveBeenCalledWith(content, {a: 'b'}, 23, data);
});

test('show', () => {
    image.show({state});
    expect(state.dispatch).toHaveBeenCalledWith('image-list', null);
});

test('action', () => {
    image.action({action, page, state})
    expect(action).toHaveBeenCalledWith('[data-plugin-image-edit]', 'click', expect.any(Function));

    action.mock.calls[0][2](null, {value: '42'});

    expect(state.dispatch).toHaveBeenCalledWith('image-edit', true);
    expect(state.dispatch).toHaveBeenCalledWith('image-load', 42);
    expect(page.show).toHaveBeenCalledWith('images-edit');
});
