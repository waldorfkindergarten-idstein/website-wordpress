import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-seal' } );

	return (
		<div { ...blockProps }>
			<div>
				<RichText
					tagName="b"
					value={ attributes.heading }
					allowedFormats={ [] }
					placeholder={ __( 'Seit …', 'waldorf-pfirsichbluete' ) }
					onChange={ ( heading ) => setAttributes( { heading } ) }
				/>
				<RichText
					tagName="span"
					value={ attributes.label }
					allowedFormats={ [] }
					placeholder={ __( 'Beschriftung …', 'waldorf-pfirsichbluete' ) }
					onChange={ ( label ) => setAttributes( { label } ) }
				/>
			</div>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
