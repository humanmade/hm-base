/* global wp */

const { Fragment } = wp.element;
const { InspectorControls } = wp.editor;
const { __ } = wp.i18n;
const {
	PanelBody,
	TextControl,
} = wp.components;

export default ( {
	attributes,
	name: blockName,
	setAttributes,
} ) => {
	const {
		title,
	} = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Block Settings' ) }>
					<TextControl
						label={ __( 'Block title' ) }
						onChange={ title => setAttributes( { title } ) }
						value={ title }
					/>
				</PanelBody>
			</InspectorControls>
			<div>
				{ blockName }
			</div>
		</Fragment>
	);
};
