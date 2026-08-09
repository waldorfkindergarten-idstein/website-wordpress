import {
	BlockControls,
	InspectorControls,
	MediaReplaceFlow,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Button, PanelBody, TextControl } from '@wordpress/components';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function getFileType( url, fallbackType ) {
	const path = url.split( /[?#]/, 1 )[ 0 ];
	const extension = path.includes( '.' ) ? path.split( '.' ).pop() : '';

	return extension ? extension.toUpperCase() : fallbackType;
}

function formatFileSize( bytes ) {
	if ( ! bytes ) {
		return '';
	}

	if ( bytes >= 1048576 ) {
		return `${ ( bytes / 1048576 ).toLocaleString( 'de-DE', {
			maximumFractionDigits: 1,
			minimumFractionDigits: 1,
		} ) } MB`;
	}

	if ( bytes >= 1024 ) {
		return `${ Math.round( bytes / 1024 ).toLocaleString( 'de-DE' ) } kB`;
	}

	return `${ bytes.toLocaleString( 'de-DE' ) } B`;
}

function Edit( { attributes, setAttributes } ) {
	const { description, fallbackSize, fallbackType, fileUrl, id, title } =
		attributes;
	const media = useSelect(
		( select ) => ( id ? select( coreStore ).getMedia( id ) : null ),
		[ id ]
	);
	const currentUrl = media?.source_url || fileUrl;
	const fileType = getFileType( currentUrl, fallbackType );
	const fileSize =
		formatFileSize( media?.media_details?.filesize ) || fallbackSize;
	const details = [ description, fileSize ].filter( Boolean ).join( ' · ' );
	const blockProps = useBlockProps( { className: 'pb-dl pb-reveal' } );

	const onSelectFile = ( selectedMedia ) => {
		setAttributes( {
			id: selectedMedia.id || 0,
			fileUrl: selectedMedia.url || selectedMedia.source_url || '#',
		} );
	};

	return (
		<>
			<BlockControls>
				<MediaReplaceFlow
					mediaId={ id }
					mediaURL={ currentUrl }
					name={ __( 'Datei ersetzen', 'waldorf-pfirsichbluete' ) }
					onSelect={ onSelectFile }
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Datei', 'waldorf-pfirsichbluete' ) }>
					<MediaUploadCheck>
						<MediaUpload
							value={ id }
							onSelect={ onSelectFile }
							render={ ( { open } ) => (
								<Button variant="secondary" onClick={ open }>
									{ id
										? __(
												'Andere Datei auswählen',
												'waldorf-pfirsichbluete'
										  )
										: __(
												'Datei auswählen',
												'waldorf-pfirsichbluete'
										  ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					<TextControl
						label={ __( 'Beschreibung', 'waldorf-pfirsichbluete' ) }
						help={ __(
							'Dateityp und Dateigröße werden automatisch ergänzt.',
							'waldorf-pfirsichbluete'
						) }
						value={ description }
						onChange={ ( value ) =>
							setAttributes( { description: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<span className="pb-dl__ext">{ fileType }</span>
				<span>
					<RichText
						tagName="b"
						value={ title }
						allowedFormats={ [] }
						placeholder={ __(
							'Titel des Dokuments',
							'waldorf-pfirsichbluete'
						) }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
					/>
					<small>{ details }</small>
				</span>
				<span className="pb-dl__arrow" aria-hidden="true">
					↓
				</span>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
