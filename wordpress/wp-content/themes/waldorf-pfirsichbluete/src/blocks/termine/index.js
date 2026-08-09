import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-termine pb-reveal' } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'waldorf-termine__list' },
		{
			allowedBlocks: metadata.allowedBlocks,
			renderAppender: InnerBlocks.ButtonBlockAppender,
			templateLock: false,
		}
	);

	return (
		<aside { ...blockProps }>
			<RichText
				tagName="h3"
				value={ attributes.heading }
				allowedFormats={ [] }
				placeholder={ __( 'Überschrift', 'waldorf-pfirsichbluete' ) }
				onChange={ ( heading ) => setAttributes( { heading } ) }
			/>
			<ul { ...innerBlocksProps } />
		</aside>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
