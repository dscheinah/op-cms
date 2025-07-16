import * as gallery from 'js/repository/gallery.js';
import {fetchJSON} from 'vendor/dscheinah/sx-js/src/fetch/json';

jest.mock('vendor/dscheinah/sx-js/src/fetch/json.js');

const fetchJSONMock = jest.mocked(fetchJSON);

beforeEach(() => {
    jest.resetAllMocks();
});

test('list', async () => {
    const result = [{id: 42}];
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await gallery.list()).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/gallery/list');
});

test('load', async () => {
    const result = {id: 42};
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await gallery.load(42)).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/gallery/load?id=42');
});

test('save', async () => {
    const body = new FormData();
    await gallery.save(body);
    expect(fetchJSONMock).toHaveBeenCalledWith('/gallery/save', {method: 'POST', body});
});

test('remove', async () => {
    await gallery.remove(42);
    expect(fetchJSONMock).toHaveBeenCalledWith('/gallery/remove?id=42', {method: 'DELETE'});
})
