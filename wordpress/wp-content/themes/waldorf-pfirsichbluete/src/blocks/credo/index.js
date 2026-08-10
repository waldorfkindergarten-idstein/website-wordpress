import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( {
		className: 'pb-credo pb-reveal',
		style: { marginTop: '44px' },
	} );

	return (
		<div { ...blockProps }>
			<RichText
				tagName="blockquote"
				value={ attributes.quote }
				allowedFormats={ [] }
				placeholder={ __( 'Leitbild-Zitat …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( quote ) => setAttributes( { quote } ) }
			/>
			<RichText
				tagName="cite"
				value={ attributes.citation }
				allowedFormats={ [] }
				placeholder={ __( 'Quelle …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( citation ) => setAttributes( { citation } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
