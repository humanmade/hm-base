# Example block.

This directory should be named the same as the block name (not including namespace)

1. `index.js`. This is the entry point for the file
	* Shoud export `name` containing the block name and namespace e.g. `hmn/example`
	* Should export `options` - an object with all the block options.
2. The edit UI sould be split into a separate component in `edit.js`
3. (optional) `index.php` This is the PHP entry point, required if you are registering the block in PHP.
4. (optional) `style.scss`. If your block has any custom styles, add them here.
