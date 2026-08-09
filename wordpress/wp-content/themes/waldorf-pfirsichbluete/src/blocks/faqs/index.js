import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

function Edit() {
	const blockProps = useBlockProps( { className: 'pb-faq' } );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: metadata.allowedBlocks,
		renderAppender: InnerBlocks.ButtonBlockAppender,
		templateLock: false,
	} );

	return <div { ...innerBlocksProps } />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
