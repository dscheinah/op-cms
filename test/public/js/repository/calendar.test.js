import * as calendar from 'js/repository/calendar.js';
import {fetchJSON} from 'vendor/dscheinah/sx-js/src/fetch/json';

jest.mock('vendor/dscheinah/sx-js/src/fetch/json.js');

const fetchJSONMock = jest.mocked(fetchJSON);

beforeEach(() => {
    jest.resetAllMocks();
});

test('load', async () => {
    const result = [{id: 42}];
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await calendar.load()).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/calendar/load');
});

test('save', async () => {
    const body = new FormData();
    await calendar.save(body);
    expect(fetchJSONMock).toHaveBeenCalledWith('/calendar/save', {method: 'POST', body});
});

test('remove', async () => {
    await calendar.remove(42);
    expect(fetchJSONMock).toHaveBeenCalledWith('/calendar/remove?id=42', {method: 'DELETE'});
})
