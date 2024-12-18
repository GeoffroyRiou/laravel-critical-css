import { generate } from '../node_modules/critical/index.js';

// process.argv is an array where:
// - The first element is the path to the Node.js executable.
// - The second element is the path to the JavaScript file being executed.
// - The remaining elements are the command-line arguments.

const args = process.argv.slice(2); // Slice off the first two elements

if (!args.length > 0) {
    console.error('No pages to process.');

}else{
    console.log('Pages', args);


    //generate({
    //    inline: true,
    //    base: 'test/',
    //    src: 'index.html',
    //    target: 'index-critical.html',
    //    width: 1300,
    //    height: 900,
    //});
}