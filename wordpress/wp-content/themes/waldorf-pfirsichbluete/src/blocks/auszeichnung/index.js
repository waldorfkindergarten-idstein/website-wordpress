import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<RichText
			{ ...blockProps }
			tagName="span"
			placeholder={ __( 'Auszeichnung', 'waldorf-pfirsichbluete' ) }
			value={ attributes.text }
			allowedFormats={ [] }
			onChange={ ( value ) => setAttributes( { text: value } ) }
		/>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
