import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes } ) {
	const isBackToTop = 'back-to-top' === attributes.variant;
	const blockProps = useBlockProps( {
		className: isBackToTop ? 'pb-totop is-visible' : 'pb-hero__bg',
	} );

	if ( isBackToTop ) {
		return (
			<button { ...blockProps } type="button">
				<span aria-hidden="true">↑</span>
				<span className="screen-reader-text">{ __( 'Nach oben', 'waldorf-pfirsichbluete' ) }</span>
			</button>
		);
	}

	return <div { ...blockProps } aria-hidden="true" />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
