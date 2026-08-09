import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { answer, question } = attributes;
	const blockProps = useBlockProps();

	return (
		<details { ...blockProps } open>
			<RichText
				tagName="summary"
				value={ question }
				allowedFormats={ [] }
				placeholder={ __( 'Frage', 'waldorf-pfirsichbluete' ) }
				onChange={ ( value ) => setAttributes( { question: value } ) }
			/>
			<RichText
				tagName="p"
				value={ answer }
				allowedFormats={ [] }
				placeholder={ __( 'Antwort', 'waldorf-pfirsichbluete' ) }
				onChange={ ( value ) => setAttributes( { answer: value } ) }
			/>
		</details>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
