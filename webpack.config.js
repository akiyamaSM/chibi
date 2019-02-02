const path = require('path')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

const isDev = process.env.NODE_ENV === "dev"
const isProd = !isDev

const js = require('./kolores.config')

module.exports = {
        entry: js.source,
        output: {
            path: path.resolve('./dist'),
            filename: js.endpoint
        },
    devtool: "source-map",
    devServer: {
            lazy: false
        },
        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                },
                {
                    test: /\.m?css$/,
                    use: ['style-loader', 'css-loader']
                },
                {
                    test: /\.m?scss$/,
                    use: ['style-loader', 'css-loader', 'sass-loader']
                }
            ]
        },
        plugins: [
            ...isProd ? [new UglifyJsPlugin({
                sourceMap: false
            })] : []
        ]
}