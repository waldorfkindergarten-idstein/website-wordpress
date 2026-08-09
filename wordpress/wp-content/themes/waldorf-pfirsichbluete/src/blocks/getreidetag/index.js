import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { day, grain, note } = attributes;
	const blockProps = useBlockProps();

	return (
		<li { ...blockProps }>
			<RichText
				tagName="span"
				className="pb-grain__day"
				placeholder={ __( 'Wochentag', 'waldorf-pfirsichbluete' ) }
				value={ day }
				allowedFormats={ [] }
				onChange={ ( value ) => setAttributes( { day: value } ) }
			/>
			<RichText
				tagName="b"
				placeholder={ __( 'Getreide', 'waldorf-pfirsichbluete' ) }
				value={ grain }
				allowedFormats={ [] }
				onChange={ ( value ) => setAttributes( { grain: value } ) }
			/>
			<RichText
				tagName="span"
				placeholder={ __( 'Hinweis', 'waldorf-pfirsichbluete' ) }
				value={ note }
				allowedFormats={ [] }
				onChange={ ( value ) => setAttributes( { note: value } ) }
			/>
		</li>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
