import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { label, value } = attributes;
	const blockProps = useBlockProps( { className: 'pb-krow' } );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="span"
				value={ label }
				allowedFormats={ [] }
				placeholder={ __( 'Bezeichnung', 'waldorf-pfirsichbluete' ) }
				onChange={ ( content ) => setAttributes( { label: content } ) }
			/>
			<RichText
				tagName="b"
				value={ value }
				allowedFormats={ [] }
				placeholder={ __(
					'Kontaktangabe oder Zeit',
					'waldorf-pfirsichbluete'
				) }
				onChange={ ( content ) => setAttributes( { value: content } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
