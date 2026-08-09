import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import './editor.scss';
import './style.scss';

const MOTIFS = [
	{ label: __( 'Pfirsich und Grün', 'waldorf-pfirsichbluete' ), value: 'c' },
	{ label: __( 'Sommerblau', 'waldorf-pfirsichbluete' ), value: 'summer' },
	{ label: __( 'Rosa und Blau', 'waldorf-pfirsichbluete' ), value: 'e' },
	{ label: __( 'Beere und Grün', 'waldorf-pfirsichbluete' ), value: 'f' },
	{ label: __( 'Gold und Rosa', 'waldorf-pfirsichbluete' ), value: 'b' },
	{ label: __( 'Blau und Gold', 'waldorf-pfirsichbluete' ), value: 'd' },
];

function Edit( { attributes, setAttributes } ) {
	const { month, motif, text, title } = attributes;
	const blockProps = useBlockProps( { className: 'pb-fest pb-reveal' } );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Aquarell-Motiv', 'waldorf-pfirsichbluete' ) }
				>
					<SelectControl
						label={ __( 'Motiv', 'waldorf-pfirsichbluete' ) }
						value={ motif }
						options={ MOTIFS }
						onChange={ ( value ) =>
							setAttributes( { motif: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<RichText
					tagName="div"
					className="pb-meta"
					placeholder={ __( 'Monat', 'waldorf-pfirsichbluete' ) }
					value={ month }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { month: value } ) }
				/>
				<RichText
					tagName="h4"
					placeholder={ __( 'Festname', 'waldorf-pfirsichbluete' ) }
					value={ title }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { title: value } ) }
				/>
				<RichText
					tagName="p"
					placeholder={ __(
						'Beschreibung',
						'waldorf-pfirsichbluete'
					) }
					value={ text }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { text: value } ) }
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
