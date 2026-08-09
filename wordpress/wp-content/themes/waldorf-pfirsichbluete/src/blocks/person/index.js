import {
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	store as blockEditorStore,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Button, FocalPointPicker, PanelBody, TextControl } from '@wordpress/components';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const ALLOWED_MEDIA_TYPES = [ 'image' ];

function getFallbackUrl( baseUrl, fallback ) {
	const filename = fallback.split( '/' ).pop();

	return filename && baseUrl ? `${ baseUrl }${ encodeURIComponent( filename ) }` : '';
}

function Edit( { attributes, setAttributes } ) {
	const { alt, fallback, focalPoint, id, monogram, name, role } = attributes;
	const media = useSelect( ( select ) => ( id ? select( coreStore ).getMedia( id ) : null ), [ id ] );
	const fallbackBaseUrl = useSelect(
		( select ) => select( blockEditorStore ).getSettings().waldorfPhotoImageBaseUrl || '',
		[]
	);
	const fallbackUrl = getFallbackUrl( fallbackBaseUrl, fallback );
	const mediaUrl = media?.media_details?.sizes?.large?.source_url || media?.source_url || '';
	const imageUrl = mediaUrl || fallbackUrl;
	const objectPosition = `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`;
	const blockProps = useBlockProps( { className: 'pb-person pb-reveal' } );

	const onSelectImage = ( selectedMedia ) => {
		setAttributes( {
			id: selectedMedia.id,
			alt: selectedMedia.alt || selectedMedia.alt_text || '',
		} );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Foto oder Monogramm', 'waldorf-pfirsichbluete' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ onSelectImage }
							allowedTypes={ ALLOWED_MEDIA_TYPES }
							value={ id }
							render={ ( { open } ) => (
								<Button variant="secondary" onClick={ open }>
									{ id
										? __( 'Foto ersetzen', 'waldorf-pfirsichbluete' )
										: __( 'Foto auswählen', 'waldorf-pfirsichbluete' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>

					{ id > 0 && (
						<Button variant="tertiary" isDestructive onClick={ () => setAttributes( { id: 0 } ) }>
							{ __( 'Monogramm verwenden', 'waldorf-pfirsichbluete' ) }
						</Button>
					) }

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

			<div { ...blockProps }>
				<div className="pb-photo pb-shape-person pb-person__photo">
					{ imageUrl ? (
						<img src={ imageUrl } alt={ alt } style={ { objectPosition } } />
					) : (
						<RichText
							tagName="span"
							className="pb-person__mono"
							placeholder={ __( 'Initiale', 'waldorf-pfirsichbluete' ) }
							value={ monogram }
							allowedFormats={ [] }
							onChange={ ( value ) => setAttributes( { monogram: value } ) }
						/>
					) }
				</div>
				<RichText
					tagName="h4"
					placeholder={ __( 'Name', 'waldorf-pfirsichbluete' ) }
					value={ name }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { name: value } ) }
				/>
				<RichText
					tagName="span"
					placeholder={ __( 'Rolle', 'waldorf-pfirsichbluete' ) }
					value={ role }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { role: value } ) }
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
