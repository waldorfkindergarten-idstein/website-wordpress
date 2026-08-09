import { InnerBlocks, RichText, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-kbox' } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'waldorf-kontaktbox__rows' },
		{
			allowedBlocks: metadata.allowedBlocks,
			renderAppender: InnerBlocks.ButtonBlockAppender,
			templateLock: false,
		}
	);

	return (
		<div { ...blockProps }>
			<RichText
				tagName="h3"
				value={ attributes.heading }
				allowedFormats={ [] }
				placeholder={ __( 'Überschrift', 'waldorf-pfirsichbluete' ) }
				onChange={ ( heading ) => setAttributes( { heading } ) }
			/>
			<div { ...innerBlocksProps } />
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
