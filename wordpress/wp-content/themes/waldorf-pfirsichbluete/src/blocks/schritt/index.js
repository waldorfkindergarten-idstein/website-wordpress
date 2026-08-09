import { RichText, store as blockEditorStore, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, clientId, setAttributes } ) {
	const { text, title } = attributes;
	const number = useSelect(
		( select ) => {
			const editor = select( blockEditorStore );
			const rootClientId = editor.getBlockRootClientId( clientId );
			const position = editor.getBlockOrder( rootClientId ).indexOf( clientId );

			return position < 0 ? 1 : position + 1;
		},
		[ clientId ]
	);
	const blockProps = useBlockProps( { className: 'pb-step pb-reveal' } );

	return (
		<div { ...blockProps }>
			<span className="pb-step__n">{ number }</span>
			<RichText
				tagName="h4"
				value={ title }
				allowedFormats={ [] }
				placeholder={ __( 'Titel des Schritts', 'waldorf-pfirsichbluete' ) }
				onChange={ ( value ) => setAttributes( { title: value } ) }
			/>
			<RichText
				tagName="p"
				value={ text }
				allowedFormats={ [] }
				placeholder={ __( 'Kurze Beschreibung', 'waldorf-pfirsichbluete' ) }
				onChange={ ( value ) => setAttributes( { text: value } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
