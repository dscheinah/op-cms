import * as init from 'js/app/init.js';
import State from 'vendor/dscheinah/sx-js/src/State.js';
import * as helper from 'js/helper.js';

const state = new State();

beforeEach(() => {
   jest.resetAllMocks();
});

test('repositories', async () => {
    const callback = jest.fn();
    init.repositories(state, {key: callback});

    expect(state.handle).toHaveBeenNthCalledWith(1, 'key', expect.any(Function));
    expect(state.handle).toHaveBeenNthCalledWith(2, 'key', callback);

    const data = {key: 'value'};
    await state.handle.mock.calls[0][1](data, callback);

    expect(state.dispatch).toHaveBeenNthCalledWith(1, 'loading', true);
    expect(state.dispatch).toHaveBeenNthCalledWith(2, 'loading', false);

    expect(callback).toHaveBeenCalledWith(data);
});

test('state', () => {
    init.state(state);

    expect(state.listen).toHaveBeenCalledWith('page-load', expect.any(Function));
    expect(state.dispatch).toHaveBeenCalledWith('page-load', null);

    state.listen.mock.calls[0][1]({title: 'expected'});
    expect(helper.set).toHaveBeenCalledWith('title', 'innerHTML', 'expected');

    state.listen.mock.calls[0][1]({});
    expect(helper.set).toHaveBeenCalledTimes(1);
});
