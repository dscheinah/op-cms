import * as text from 'js/repository/text.js';
import {fetchJSON} from 'vendor/dscheinah/sx-js/src/fetch/json';

jest.mock('vendor/dscheinah/sx-js/src/fetch/json.js');

const fetchJSONMock = jest.mocked(fetchJSON);

beforeEach(() => {
    jest.resetAllMocks();
});

test('list', async () => {
    const result = [{id: 42}];
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await text.list()).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/text/list');
});

test('load', async () => {
    const result = {id: 42};
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await text.load(42)).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/text/load?id=42');
});

test('save', async () => {
    const body = new FormData();
    await text.save(body);
    expect(fetchJSONMock).toHaveBeenCalledWith('/text/save', {method: 'POST', body});
});

test('remove', async () => {
    await text.remove(42);
    expect(fetchJSONMock).toHaveBeenCalledWith('/text/remove?id=42', {method: 'DELETE'});
})
