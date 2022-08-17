const HtmlWebpackPlugin = require("html-webpack-plugin");
const webpack = require("webpack");
const CopyPlugin = require("copy-webpack-plugin");

module.exports = {
    entry: { main: "./src/js/script.js", vendor: "./src/js/vendor.js" },
    performance: {
        maxEntrypointSize: 5120000,
        maxAssetSize: 5120000,
    },
    plugins: [
        new HtmlWebpackPlugin({
            filename: "index.html",
            template: "./src/index.html",
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
        }),
        new CopyPlugin({
            patterns: [
                {
                    from: "./src/img",
                    to: "img/[path]/[name][ext]",
                    noErrorOnMissing: true,
                },
            ],
        }),
    ],
    module: {
        rules: [
            {
                test: /\.html$/,
                use: "html-loader",
            },
            {
                test: /\.(svg|png|jpg|gif)$/,
                type: "asset/resource",
                generator: {
                    filename: (name) => {
                        /**
                         * @description Remove first & last item from ${path} array.
                         * @example
                         *      Orginal Path: 'src/images/avatar/image.jpg'
                         *      Changed To: 'images/avatar'
                         */
                        const path = name.filename
                            .split("/")
                            .slice(1, -1)
                            .join("/");
                        return `${path}/[name][ext]`;
                    },
                },
            },
        ],
    },
};
