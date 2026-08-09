import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-chip' } );

	return (
		<RichText
			{ ...blockProps }
			tagName="span"
			value={ attributes.text }
			allowedFormats={ [] }
			placeholder={ __( 'Merkmal …', 'waldorf-pfirsichbluete' ) }
			onChange={ ( text ) => setAttributes( { text } ) }
		/>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
