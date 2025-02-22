/**
 * The base class that defines all available methods of plugins.
 *
 * The page uses a plugin to render the content selection for each template key.
 */
export default class Plugin {
    /**
     * Is called for each entry while the page is rendered.
     *
     * @param {PluginState} pluginState Provides access to variables from the page.
     * @param {PluginContent} content The provided content from the template with the saved value.
     * @param {object} values All currently selected (unsaved) values as {name: value}.
     * @param {integer} index The current unique index usable for id creation.
     */
    render(pluginState, content, values, index) {
    }

    /**
     * Is called each time the page is shown.
     *
     * @param {PluginState} pluginState Provides access to variables from the page.
     */
    show(pluginState) {
    }

    /**
     * Is called once after page creation to register event handlers.
     *
     * @param {PluginState} pluginState Provides access to variables from the page.
     */
    action(pluginState) {
    }

    /**
     * Is called once after page creation to register dynamic state listeners.
     *
     * @param {PluginState} pluginState Provides access to variables from the page.
     */
    listen(pluginState) {
    }
}

/**
 * @typedef {{helper: object, state: State, page: Page, action: Page~action, listen: Page~listen}} PluginState
 */

/**
 * @typedef {{type: string, key: string, label: string, value: any}} PluginContent
 *
 * If the plugin provides a form input to save, the name must be created as type[key].
 * A label is optional and the value must be used to read the initial value.
 */
