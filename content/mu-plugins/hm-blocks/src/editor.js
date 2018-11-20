/* global wp */

// Import the blocks.
import * as ExampleBlock from './blocks/hmn-example';

const { registerBlockType } = wp.blocks;

// Map of block name to block options.
const availableBlocks = {
	[ExampleBlock.name]: ExampleBlock.options,
}

// Loop through available blocks and register them.
Object.keys( availableBlocks )
	.forEach( name => registerBlockType( name, availableBlocks[ name ] ) );
