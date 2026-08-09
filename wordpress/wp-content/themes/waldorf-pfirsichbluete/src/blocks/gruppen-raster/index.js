import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

const ALLOWED_BLOCKS = [ 'waldorf/gruppen-karte' ];

function Edit() {
	const blockProps = useBlockProps( {
		style: {
			display: 'grid',
			gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))',
			gap: '30px',
			marginTop: '50px',
		},
	} );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		templateLock: 'insert',
	} );

	return <div { ...innerBlocksProps } />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
