import * as image from 'js/repository/image.js';
import {fetchJSON} from 'vendor/dscheinah/sx-js/src/fetch/json';

jest.mock('vendor/dscheinah/sx-js/src/fetch/json.js');

const fetchJSONMock = jest.mocked(fetchJSON);

beforeEach(() => {
    jest.resetAllMocks();
});

describe('list', () => {
    test('without gallery', async () => {
        const result = [{id: 42}];
        fetchJSONMock.mockResolvedValueOnce(result);
        expect(await image.list(null)).toEqual(result);
        expect(fetchJSONMock).toHaveBeenCalledWith('/image/list?');
    });

    test('with gallery', async () => {
        const result = [{id: 42}];
        fetchJSONMock.mockResolvedValueOnce(result);
        expect(await image.list(42)).toEqual(result);
        expect(fetchJSONMock).toHaveBeenCalledWith('/image/list?gallery=42');
    });
})

test('load', async () => {
    const result = {id: 42};
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await image.load(42)).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/image/load?id=42');
});

test('save', async () => {
    const body = new FormData();
    await image.save(body);
    expect(fetchJSONMock).toHaveBeenCalledWith('/image/save', {method: 'POST', body});
});

test('remove', async () => {
    await image.remove(42);
    expect(fetchJSONMock).toHaveBeenCalledWith('/image/remove?id=42', {method: 'DELETE'});
})
