
const { spawn } = require('child_process');
const process = require('process');
const fs = require('fs');


process.env.NODE_ENV = 'production';
process.env.PUBLIC_URL = '/the-purse-club/wp-content/themes/the_purse_club_theme/js/frontend/build/';
process.env.FORCE_COLOR = true;

const __path = __dirname + '/build';

console.log('Starting service to listen and build...');

let __cachedFiles = [];
var cacheFiles = function (path) {
    if (fs.existsSync(path)) {
        fs.readdirSync(path).forEach(function (file, index) {
            var newPath = path + '/' + file;
            if (fs.lstatSync(newPath).isDirectory()) {
                cacheFiles(newPath);
            } else {
                if (!__cachedFiles.find((file) => {file == newPath})) {
                    __cachedFiles.push(newPath);
                }
            }
        });
    }
}

let recursiveRemove = function (path) {
    if (fs.existsSync(path)) {
        fs.readdirSync(path).forEach(function (file, index) {
            var newPath = path + '/' + file;
            if (fs.lstatSync(newPath).isDirectory()) {
                recursiveRemove(newPath);
            } else {
                let findEqual = function (file) {
                    return file == newPath;
                }
                if (__cachedFiles.find(findEqual)) {
                    fs.unlinkSync(newPath);
                    __cachedFiles.splice(__cachedFiles.indexOf(newPath), 1);
                }
            }
        });
        // fs.rmdir(path);
    }
}

cacheFiles(__path);
var webpack = spawn(
    'webpack', ['--watch', '--config', 'node_modules/react-scripts/config/webpack.config.prod.js'],
    { env: process.evn }
);

webpack.stdout.on('data', (data) => {
    recursiveRemove(__path);
    console.log(data.toString());
    cacheFiles(__path);
});

webpack.stderr.on('data', (data) => {
    console.error(data.toString());
});

webpack.stderr.on('close', (code) => {
    console.error(`child process exited with code ${code}`);
});
