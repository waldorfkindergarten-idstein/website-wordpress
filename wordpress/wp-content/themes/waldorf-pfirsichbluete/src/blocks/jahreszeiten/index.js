import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { ColorPalette, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import './editor.scss';
import './style.scss';

const ALLOWED_BLOCKS = [ 'core/buttons' ];

function SeasonContent( { attributes, setAttributes } ) {
	const { colorFour, colorOne, colorThree, colorTwo } = attributes;
	const richTextProps = ( attribute, placeholder ) => ( {
		value: attributes[ attribute ],
		placeholder,
		allowedFormats: [],
		onChange: ( value ) => setAttributes( { [ attribute ]: value } ),
	} );

	return (
		<>
			<div className="pb-season__ring">
				<div>
					<RichText
						tagName="b"
						{ ...richTextProps(
							'season',
							__( 'Jahreszeit', 'waldorf-pfirsichbluete' )
						) }
					/>
					<RichText
						tagName="span"
						{ ...richTextProps(
							'ringLabel',
							__( 'Bezeichnung', 'waldorf-pfirsichbluete' )
						) }
					/>
				</div>
			</div>

			<div className="wp-block-group pb-sec-head pb-sec-head--wide">
				<RichText
					tagName="p"
					className="pb-eyebrow"
					{ ...richTextProps(
						'eyebrow',
						__( 'Übertitel', 'waldorf-pfirsichbluete' )
					) }
				/>
				<RichText
					tagName="h3"
					className="wp-block-heading"
					style={ { marginTop: '0.2em', marginBottom: '0.25em' } }
					{ ...richTextProps(
						'title',
						__( 'Überschrift', 'waldorf-pfirsichbluete' )
					) }
				/>
				<RichText
					tagName="p"
					className="has-text-color"
					style={ { color: '#5a4046' } }
					{ ...richTextProps(
						'text',
						__( 'Beschreibung', 'waldorf-pfirsichbluete' )
					) }
				/>

				<div className="pb-swatches" style={ { marginTop: '14px' } }>
					<i style={ { background: colorOne } } />
					<i style={ { background: colorTwo } } />
					<i style={ { background: colorThree } } />
					<i style={ { background: colorFour } } />
				</div>
			</div>
		</>
	);
}

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-season pb-reveal' } );
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		templateLock: 'all',
		renderAppender: false,
	} );
	const colors = [
		[ 'colorOne', attributes.colorOne ],
		[ 'colorTwo', attributes.colorTwo ],
		[ 'colorThree', attributes.colorThree ],
		[ 'colorFour', attributes.colorFour ],
	];

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Farbtupfer', 'waldorf-pfirsichbluete' ) }
				>
					{ colors.map( ( [ attribute, color ], index ) => (
						<ColorPalette
							key={ attribute }
							clearable={ false }
							label={ `${ __(
								'Farbe',
								'waldorf-pfirsichbluete'
							) } ${ index + 1 }` }
							value={ color }
							onChange={ ( value ) =>
								setAttributes( { [ attribute ]: value } )
							}
						/>
					) ) }
				</PanelBody>
			</InspectorControls>

			<div { ...innerBlocksProps }>
				<SeasonContent
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
				{ innerBlocksProps.children }
			</div>
		</>
	);
}

function Save( { attributes } ) {
	const blockProps = useBlockProps.save( {
		className: 'pb-season pb-reveal',
	} );

	return (
		<div { ...blockProps }>
			<div className="pb-season__ring">
				<div>
					<RichText.Content tagName="b" value={ attributes.season } />
					<RichText.Content
						tagName="span"
						value={ attributes.ringLabel }
					/>
				</div>
			</div>

			<div className="wp-block-group pb-sec-head pb-sec-head--wide">
				<RichText.Content
					tagName="p"
					className="pb-eyebrow"
					value={ attributes.eyebrow }
				/>
				<RichText.Content
					tagName="h3"
					className="wp-block-heading"
					style={ { marginTop: '0.2em', marginBottom: '0.25em' } }
					value={ attributes.title }
				/>
				<RichText.Content
					tagName="p"
					className="has-text-color"
					style={ { color: '#5a4046' } }
					value={ attributes.text }
				/>

				<div className="pb-swatches" style={ { marginTop: '14px' } }>
					<i style={ { background: attributes.colorOne } } />
					<i style={ { background: attributes.colorTwo } } />
					<i style={ { background: attributes.colorThree } } />
					<i style={ { background: attributes.colorFour } } />
				</div>
			</div>

			<InnerBlocks.Content />
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: Save,
} );
