import {
	BlockControls,
	InspectorControls,
	MediaPlaceholder,
	MediaReplaceFlow,
	RichText,
	store as blockEditorStore,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { FocalPointPicker, PanelBody, SelectControl, TextControl, ToolbarGroup } from '@wordpress/components';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import './editor.scss';

const ALLOWED_MEDIA_TYPES = [ 'image' ];

const SHAPES = {
	hero: {
		className: 'pb-shape-hero',
		label: __( 'Hero', 'waldorf-pfirsichbluete' ),
		style: { aspectRatio: '4 / 4.4' },
	},
	mosaic1: {
		className: 'pb-mosaic__1',
		label: __( 'Mosaik 1', 'waldorf-pfirsichbluete' ),
	},
	mosaic2: {
		className: 'pb-mosaic__2',
		label: __( 'Mosaik 2', 'waldorf-pfirsichbluete' ),
	},
	mosaic3: {
		className: 'pb-mosaic__3',
		label: __( 'Mosaik 3', 'waldorf-pfirsichbluete' ),
	},
	mosaic4: {
		className: 'pb-mosaic__4',
		label: __( 'Mosaik 4', 'waldorf-pfirsichbluete' ),
	},
	group: {
		className: 'pb-gcard__photo',
		label: __( 'Gruppe', 'waldorf-pfirsichbluete' ),
	},
	rhythm: {
		className: 'pb-shape-rhythm',
		label: __( 'Rhythmus', 'waldorf-pfirsichbluete' ),
		style: { aspectRatio: '4 / 4.2' },
	},
	food: {
		className: 'pb-shape-food',
		label: __( 'Essen', 'waldorf-pfirsichbluete' ),
		style: { aspectRatio: '4 / 3.6' },
	},
	person: {
		className: 'pb-shape-person pb-person__photo',
		label: __( 'Person', 'waldorf-pfirsichbluete' ),
	},
	round: {
		className: 'pb-shape-round',
		label: __( 'Rund', 'waldorf-pfirsichbluete' ),
	},
};

function getFallbackUrl( baseUrl, fallback ) {
	const filename = fallback.split( '/' ).pop();

	return filename && baseUrl ? `${ baseUrl }${ encodeURIComponent( filename ) }` : '';
}

function Edit( { attributes, setAttributes } ) {
	const { alt, caption, fallback, focalPoint, id, shape } = attributes;
	const media = useSelect( ( select ) => ( id ? select( coreStore ).getMedia( id ) : null ), [ id ] );
	const fallbackBaseUrl = useSelect(
		( select ) => select( blockEditorStore ).getSettings().waldorfPhotoImageBaseUrl || '',
		[]
	);
	const fallbackUrl = getFallbackUrl( fallbackBaseUrl, fallback );
	const mediaUrl = media?.media_details?.sizes?.large?.source_url || media?.source_url || '';
	const imageUrl = mediaUrl || fallbackUrl;
	const selectedShape = SHAPES[ shape ] || SHAPES.hero;
	const objectPosition = `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`;
	const blockProps = useBlockProps( {
		className: `pb-photo ${ selectedShape.className }`,
		style: selectedShape.style,
	} );

	const onSelectImage = ( selectedMedia ) => {
		setAttributes( {
			id: selectedMedia.id,
			alt: selectedMedia.alt || selectedMedia.alt_text || '',
		} );
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<MediaReplaceFlow
						mediaId={ id }
						mediaURL={ imageUrl }
						allowedTypes={ ALLOWED_MEDIA_TYPES }
						accept="image/*"
						name={ __( 'Bild ersetzen', 'waldorf-pfirsichbluete' ) }
						onSelect={ onSelectImage }
					/>
				</ToolbarGroup>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={ __( 'Foto', 'waldorf-pfirsichbluete' ) }>
					<SelectControl
						label={ __( 'Form', 'waldorf-pfirsichbluete' ) }
						value={ shape }
						options={ Object.entries( SHAPES ).map( ( [ value, option ] ) => ( {
							label: option.label,
							value,
						} ) ) }
						onChange={ ( value ) => setAttributes( { shape: value } ) }
					/>

					{ imageUrl && (
						<FocalPointPicker
							label={ __( 'Bildausschnitt', 'waldorf-pfirsichbluete' ) }
							url={ imageUrl }
							value={ focalPoint }
							onChange={ ( value ) => setAttributes( { focalPoint: value } ) }
						/>
					) }

					<TextControl
						label={ __( 'Alternativtext', 'waldorf-pfirsichbluete' ) }
						help={ __(
							'Leer lassen, um den Alternativtext aus der Mediathek zu verwenden.',
							'waldorf-pfirsichbluete'
						) }
						value={ alt }
						onChange={ ( value ) => setAttributes( { alt: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<figure { ...blockProps }>
				{ id && imageUrl ? (
					<img src={ imageUrl } alt={ alt } style={ { objectPosition } } />
				) : (
					<div className="waldorf-photo__placeholder">
						{ fallbackUrl && <img src={ fallbackUrl } alt="" style={ { objectPosition } } /> }
						<MediaPlaceholder
							icon="format-image"
							labels={ {
								title: __( 'Foto auswählen', 'waldorf-pfirsichbluete' ),
							} }
							onSelect={ onSelectImage }
							accept="image/*"
							allowedTypes={ ALLOWED_MEDIA_TYPES }
						/>
					</div>
				) }

				<RichText
					tagName="figcaption"
					className="wp-element-caption"
					placeholder={ __( 'Bildunterschrift …', 'waldorf-pfirsichbluete' ) }
					value={ caption }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { caption: value } ) }
				/>
			</figure>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
