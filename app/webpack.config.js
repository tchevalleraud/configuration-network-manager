const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')
    .enableVersioning()
    .addEntry('app', './assets/app.js')
    .addEntry('app_adminoffice', './assets/app_adminoffice.js')
    .addEntry('app_adminoffice_authentication_database', './assets/app_adminoffice_authentication_database.js')
    .addEntry('app_backoffice_security', './assets/app_backoffice_security.js')
    .addEntry('app_frontoffice_dashboard_index', './assets/app_frontoffice_dashboard_index.js')
    .copyFiles({from: './assets/favicon', to: 'favicon/[path][name].[ext]'})
    .copyFiles({from: './assets/images', to: 'images/[path][name].[ext]'})
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enablePostCssLoader()
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();