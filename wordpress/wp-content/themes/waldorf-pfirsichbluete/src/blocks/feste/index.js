import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

const ALLOWED_BLOCKS = [ 'waldorf/fest' ];
const GRID_STYLE = {
	display: 'grid',
	gridTemplateColumns: 'repeat(auto-fit,minmax(240px,1fr))',
	gap: '20px',
	marginTop: '46px',
};

function Edit() {
	const blockProps = useBlockProps( { style: GRID_STYLE } );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		templateLock: false,
	} );

	return <div { ...innerBlocksProps } />;
}

function Save() {
	return <InnerBlocks.Content />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: Save,
} );
