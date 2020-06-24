const { createConfig } = require('@doghouse/webpack-base'); 

module.exports = [];
module.exports.push(createConfig({
    entry: {
        main: [
            './src/index.js',
        ],
    },
}));