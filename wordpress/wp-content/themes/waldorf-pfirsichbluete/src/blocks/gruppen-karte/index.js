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
import {
	FocalPointPicker,
	PanelBody,
	TextControl,
	ToolbarGroup,
} from '@wordpress/components';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import './editor.scss';

const ALLOWED_MEDIA_TYPES = [ 'image' ];

function getFallbackUrl( baseUrl, fallback ) {
	const filename = fallback.split( '/' ).pop();

	return filename && baseUrl
		? `${ baseUrl }${ encodeURIComponent( filename ) }`
		: '';
}

function Edit( { attributes, setAttributes } ) {
	const {
		alt,
		caption,
		facts,
		fallback,
		focalPoint,
		id,
		linkLabel,
		tag,
		text,
		title,
		url,
	} = attributes;
	const media = useSelect(
		( select ) => ( id ? select( coreStore ).getMedia( id ) : null ),
		[ id ]
	);
	const fallbackBaseUrl = useSelect(
		( select ) =>
			select( blockEditorStore ).getSettings().waldorfPhotoImageBaseUrl ||
			'',
		[]
	);
	const fallbackUrl = getFallbackUrl( fallbackBaseUrl, fallback );
	const mediaUrl =
		media?.media_details?.sizes?.large?.source_url ||
		media?.source_url ||
		'';
	const imageUrl = mediaUrl || fallbackUrl;
	const objectPosition = `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`;
	const blockProps = useBlockProps( { className: 'pb-gcard pb-reveal' } );

	const onSelectImage = ( selectedMedia ) => {
		setAttributes( {
			id: selectedMedia.id,
			alt: selectedMedia.alt || selectedMedia.alt_text || '',
		} );
	};

	const updateFact = ( index, key, value ) => {
		setAttributes( {
			facts: facts.map( ( fact, factIndex ) =>
				factIndex === index ? { ...fact, [ key ]: value } : fact
			),
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
					{ imageUrl && (
						<FocalPointPicker
							label={ __(
								'Bildausschnitt',
								'waldorf-pfirsichbluete'
							) }
							url={ imageUrl }
							value={ focalPoint }
							onChange={ ( value ) =>
								setAttributes( { focalPoint: value } )
							}
						/>
					) }

					<TextControl
						label={ __(
							'Alternativtext',
							'waldorf-pfirsichbluete'
						) }
						help={ __(
							'Leer lassen, um den Alternativtext aus der Mediathek zu verwenden.',
							'waldorf-pfirsichbluete'
						) }
						value={ alt }
						onChange={ ( value ) =>
							setAttributes( { alt: value } )
						}
					/>
				</PanelBody>

				<PanelBody
					title={ __( 'Link', 'waldorf-pfirsichbluete' ) }
					initialOpen={ false }
				>
					<TextControl
						label={ __( 'Linkziel', 'waldorf-pfirsichbluete' ) }
						type="url"
						value={ url }
						onChange={ ( value ) =>
							setAttributes( { url: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<article { ...blockProps }>
				<figure className="pb-photo pb-gcard__photo">
					{ id && imageUrl ? (
						<img
							src={ imageUrl }
							alt={ alt }
							style={ { objectPosition } }
						/>
					) : (
						<div className="waldorf-gruppen-karte__placeholder">
							{ fallbackUrl && (
								<img
									src={ fallbackUrl }
									alt=""
									style={ { objectPosition } }
								/>
							) }
							<MediaPlaceholder
								icon="format-image"
								labels={ {
									title: __(
										'Gruppenfoto auswählen',
										'waldorf-pfirsichbluete'
									),
								} }
								onSelect={ onSelectImage }
								accept="image/*"
								allowedTypes={ ALLOWED_MEDIA_TYPES }
							/>
						</div>
					) }

					<RichText
						tagName="figcaption"
						placeholder={ __(
							'Bildunterschrift …',
							'waldorf-pfirsichbluete'
						) }
						value={ caption }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { caption: value } )
						}
					/>
				</figure>

				<div className="pb-gcard__body">
					<RichText
						tagName="span"
						className="pb-tag"
						placeholder={ __(
							'Altersgruppe',
							'waldorf-pfirsichbluete'
						) }
						value={ tag }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { tag: value } )
						}
					/>
					<RichText
						tagName="h3"
						placeholder={ __(
							'Gruppenname',
							'waldorf-pfirsichbluete'
						) }
						value={ title }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
					/>
					<RichText
						tagName="p"
						placeholder={ __(
							'Beschreibung',
							'waldorf-pfirsichbluete'
						) }
						value={ text }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { text: value } )
						}
					/>
					<ul className="pb-meta-list">
						{ facts.map( ( fact, index ) => (
							<li key={ index }>
								<RichText
									tagName="span"
									placeholder={ __(
										'Bezeichnung',
										'waldorf-pfirsichbluete'
									) }
									value={ fact.label }
									allowedFormats={ [] }
									onChange={ ( value ) =>
										updateFact( index, 'label', value )
									}
								/>
								<RichText
									tagName="b"
									placeholder={ __(
										'Wert',
										'waldorf-pfirsichbluete'
									) }
									value={ fact.value }
									allowedFormats={ [] }
									onChange={ ( value ) =>
										updateFact( index, 'value', value )
									}
								/>
							</li>
						) ) }
					</ul>
					<RichText
						tagName="span"
						className="pb-more"
						placeholder={ __(
							'Linktext',
							'waldorf-pfirsichbluete'
						) }
						value={ linkLabel }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { linkLabel: value } )
						}
					/>
				</div>
			</article>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
