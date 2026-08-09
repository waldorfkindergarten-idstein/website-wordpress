import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-date-pill' } );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="span"
				className="pb-eyebrow"
				value={ attributes.eyebrow }
				allowedFormats={ [] }
				placeholder={ __( 'Hinweis …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( eyebrow ) => setAttributes( { eyebrow } ) }
			/>
			<RichText
				tagName="b"
				value={ attributes.title }
				allowedFormats={ [] }
				placeholder={ __( 'Terminname …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( title ) => setAttributes( { title } ) }
			/>
			<RichText
				tagName="span"
				value={ attributes.date }
				allowedFormats={ [] }
				placeholder={ __(
					'Datum und Uhrzeit …',
					'waldorf-pfirsichbluete'
				) }
				onChange={ ( date ) => setAttributes( { date } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
