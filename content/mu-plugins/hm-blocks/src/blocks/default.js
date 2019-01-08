/**
 * A default block config with some common configurations.
 * When creating new block types, this can be extended to avoid having to declare the same things for all blocks.
 */
export default {
	// Default category.
	category: 'common',
	// Default icon.
	icon: 'wordpress-alt',
	// By default, save to return null. Commonly used if your data is stored in as JSON only.
	save() {
		return null;
	},
	// By default, disable additional css class field and editing as html.
	supports: {
		// Remove "Additional CSS Class" field from the Advanced tab in the editor sidebar.
		// Unless your code supports this, it has no effect.
		customClassName: false,
		// Do not allow the block's HTML to be edited.
		html: false,
	},
};
