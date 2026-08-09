import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-fact' } );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="b"
				value={ attributes.value }
				allowedFormats={ [] }
				placeholder={ __( 'Wert …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( value ) => setAttributes( { value } ) }
			/>
			<RichText
				tagName="span"
				value={ attributes.label }
				allowedFormats={ [] }
				placeholder={ __( 'Erläuterung …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( label ) => setAttributes( { label } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
