/* global wp */

// Import the blocks.
import * as ExampleBlock from './blocks/example';

const { registerBlockType } = wp.blocks;

// Value of 'hm-blocks' theme supoort passed using localise script.
const { HMCurrentThemeBlockSupport: enabledBlocks = [] } = window;

// Map of block name to block options.
const availableBlocks = {
	[ExampleBlock.name]: ExampleBlock.options,
}

// Loop through enabled blocks, filter to check they exist and register the the.
enabledBlocks.filter( name => !! availableBlocks[ name ] )
	.forEach( name => registerBlockType( name, availableBlocks[ name ] ) );
