import { generate } from '../node_modules/critical/index.js';

// Get the command line arguments
const args = process.argv.slice(2); // Slice off the first two elements

// Parse the command line arguments
const urlFlagIndex = args.indexOf('--url');
const folderFlagIndex = args.indexOf('--folder');
const filenameFlagIndex = args.indexOf('--filename');
let urlValue;
let folderPath;
let cssFileName;

if (urlFlagIndex === -1) {
    console.error('No page to process.');
    process.exit();
} else if (folderFlagIndex === -1) {
    console.error('No folder was provided.');
    process.exit();
} else if (filenameFlagIndex === -1) {
    console.error('No filename was provided.');
    process.exit();
} else {
    urlValue = args[urlFlagIndex + 1];
    folderPath = args[folderFlagIndex + 1];
    cssFileName = args[filenameFlagIndex + 1];
}

// Generate the critical CSS
generate({
    inline: false,
    base: folderPath,
    src: urlValue,
    target: cssFileName,
    width: 1300,
    height: 900,
});