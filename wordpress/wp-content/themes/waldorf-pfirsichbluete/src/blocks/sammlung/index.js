import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

const VARIANTS = {
	chips: {
		allowedBlocks: [ 'waldorf/chip' ],
		className: 'pb-chips',
		style: { marginTop: '30px' },
	},
	facts: {
		allowedBlocks: [ 'waldorf/fakt' ],
		className: 'pb-facts',
		style: { marginTop: '36px' },
	},
	testimonials: {
		allowedBlocks: [ 'waldorf/stimme' ],
		style: {
			display: 'grid',
			gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))',
			gap: '24px',
			marginTop: '44px',
		},
	},
};

function Edit( { attributes } ) {
	const variant = VARIANTS[ attributes.variant ] || VARIANTS.chips;
	const blockProps = useBlockProps( {
		className: variant.className,
		style: variant.style,
	} );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: variant.allowedBlocks,
		templateLock: false,
		renderAppender: InnerBlocks.ButtonBlockAppender,
	} );

	return <div { ...innerBlocksProps } />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
