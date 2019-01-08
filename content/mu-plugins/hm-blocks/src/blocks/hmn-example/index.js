/* global wp */

import edit from './edit';
import defaultOptions from '../default';

const { __ } = wp.i18n;

export const name = 'hmn/example';

export const options = {
	...defaultOptions,
	title: __( 'HM Example' ),
	description: __( 'Just a little example plugin.' ),
	edit,
}
