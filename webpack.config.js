const path = require("path");

module.exports = {
    resolve: {
        alias: {
            '@js': path.resolve('./resources/js'),
            '@vue': path.resolve('./resources/js/vue'),
            '@scss': path.resolve('./resources/scss'),
            '@fonts': path.resolve('./resources/fonts'),
            '@images': path.resolve('./resources/images'),
        },
    },
    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {
                                includePaths: [
                                    'node_modules',
                                    path.resolve('./resources/'),
                                    path.resolve('./resources/scss/backend/'),
                                    path.resolve('./resources/scss/frontend/'),
                                ]
                            }
                        }
                    }
                ]
            },
            {
                test: /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/,
                loaders: {
                    loader: 'file-loader',
                    options: {
                        name: '[path][name].[ext]?[hash]',
                        context: './resources'
                    }
                }
            }
        ]
    },
    output: {
        chunkFilename: 'js/chunks/[name].js?[hash]'
    }
};
