import calendar from 'js/plugins/calendar.js';
import * as helper from 'js/helper.js';

const helperCreateMock = jest.mocked(helper.create);

beforeEach(() => {
    jest.resetAllMocks();
});

describe('render', () => {
    const content = {type: 'calendar', label: ''};

    beforeEach(() => {
        helperCreateMock.mockReturnValueOnce(document.createElement('div'));
    });

    test('default', () => {
        const result = calendar.render({helper}, {...content, key: ''}, {}, 0);
        const button = result.querySelector('button');
        expect(button.value).toEqual('calendar');
        expect(button.dataset.navigation).toEqual('');
    })

    test('next', () => {
        const result = calendar.render({helper}, {...content, key: 'next', value: 42}, {}, 0);
        const button = result.querySelector('button');
        expect(button.innerHTML).toContain('Nächste Termine (42)');
    });

    test('list', () => {
        const result = calendar.render({helper}, {...content, key: 'list'}, {}, 0);
        const button = result.querySelector('button');
        expect(button.innerHTML).toContain('Anstehende Termine');
    });
});
