import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

const ALLOWED_BLOCKS = [ 'waldorf/photo' ];
const TEMPLATE = [
	[ 'waldorf/photo', { shape: 'mosaic1' } ],
	[ 'waldorf/photo', { shape: 'mosaic2' } ],
	[ 'waldorf/photo', { shape: 'mosaic3' } ],
	[ 'waldorf/photo', { shape: 'mosaic4' } ],
];

function Edit() {
	const blockProps = useBlockProps( {
		className: 'pb-mosaic pb-reveal',
		style: { marginTop: '46px' },
	} );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		template: TEMPLATE,
		templateLock: 'all',
	} );

	return <div { ...innerBlocksProps } />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
