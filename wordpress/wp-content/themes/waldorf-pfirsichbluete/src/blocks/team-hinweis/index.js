import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	return (
		<RichText
			{ ...useBlockProps( {
				className: 'pb-team-note',
				style: {
					marginTop: '28px',
					fontSize: '.92rem',
					color: '#6e5a55',
				},
			} ) }
			tagName="p"
			placeholder={ __( 'Hinweis zum Team …', 'waldorf-pfirsichbluete' ) }
			value={ attributes.text }
			onChange={ ( text ) => setAttributes( { text } ) }
		/>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
