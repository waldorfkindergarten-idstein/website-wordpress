import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const ALLOWED_BLOCKS = [ 'waldorf/getreidetag' ];
const TEMPLATE = [
	[
		'waldorf/getreidetag',
		{
			day: __( 'Montag', 'waldorf-pfirsichbluete' ),
			grain: __( 'Getreide', 'waldorf-pfirsichbluete' ),
			note: __( 'Hinweis ergänzen', 'waldorf-pfirsichbluete' ),
		},
	],
];

function Edit() {
	const blockProps = useBlockProps( {
		className: 'pb-grain',
		style: { marginTop: '24px' },
	} );

	return (
		<ul { ...blockProps }>
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
				templateLock={ false }
			/>
		</ul>
	);
}

function Save() {
	return <InnerBlocks.Content />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: Save,
} );
