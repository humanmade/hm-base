/* global wp */

import edit from './edit';
import defaultOptions from '../default';

const { __ } = wp.i18n;

export const name = 'hmn/example';

export const options = {
	// Extend the default block.
	...defaultOptions,
	description: __( 'Just a little test.' ),
	edit,
	title: __( 'HM Test' ),
}
