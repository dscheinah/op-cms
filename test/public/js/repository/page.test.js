import * as page from 'js/repository/page.js';
import {fetchJSON} from 'vendor/dscheinah/sx-js/src/fetch/json';

jest.mock('vendor/dscheinah/sx-js/src/fetch/json.js');

const fetchJSONMock = jest.mocked(fetchJSON);

beforeEach(() => {
    jest.resetAllMocks();
});

test('load', async () => {
    const result = {title: 'Title'};
    fetchJSONMock.mockResolvedValueOnce(result);
    expect(await page.load()).toEqual(result);
    expect(fetchJSONMock).toHaveBeenCalledWith('/page/load');
});

test('save', async () => {
    const body = new FormData();
    await page.save(body);
    expect(fetchJSONMock).toHaveBeenCalledWith('/page/save', {method: 'POST', body});
});
