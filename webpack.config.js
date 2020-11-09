var Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build-vue/')
    .setPublicPath('/build-vue')
    .addEntry('app-vue', './assets-vue/app.js')
    .configureDefinePlugin(options => {
        const env = dotenv.config();

        if (env.error) {
            throw env.error;
        }

        options['process.env'].WEBSOCKET_PORT = JSON.stringify(env.parsed.WEBSOCKET_PORT);
    })
    .enableSassLoader()
    .enableVueLoader()
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
;

module.exports = Encore.getWebpackConfig();
