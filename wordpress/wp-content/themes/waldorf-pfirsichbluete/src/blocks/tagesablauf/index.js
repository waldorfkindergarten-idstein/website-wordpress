import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const ALLOWED_BLOCKS = [ 'waldorf/tagesablauf-punkt' ];
const TEMPLATE = [
	[
		'waldorf/tagesablauf-punkt',
		{
			time: '8:00',
			title: __( 'Programmpunkt', 'waldorf-pfirsichbluete' ),
			detail: __( 'Beschreibung ergänzen', 'waldorf-pfirsichbluete' ),
		},
	],
];

function Edit() {
	const blockProps = useBlockProps( { className: 'pb-timeline' } );

	return (
		<ol { ...blockProps }>
			<InnerBlocks
				allowedBlocks={ ALLOWED_BLOCKS }
				template={ TEMPLATE }
				templateLock={ false }
			/>
		</ol>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
