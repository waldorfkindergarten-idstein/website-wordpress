import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( {
		className: 'pb-quote pb-reveal is-in',
	} );

	return (
		<figure { ...blockProps }>
			<RichText
				tagName="p"
				value={ attributes.quote }
				allowedFormats={ [] }
				placeholder={ __( 'Zitat …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( quote ) => setAttributes( { quote } ) }
			/>
			<RichText
				tagName="footer"
				value={ attributes.source }
				allowedFormats={ [] }
				placeholder={ __( 'Quelle …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( source ) => setAttributes( { source } ) }
			/>
		</figure>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
