import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { label, linkType, value } = attributes;
	const blockProps = useBlockProps( { className: 'pb-krow' } );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Verknüpfung', 'waldorf-pfirsichbluete' ) }
				>
					<SelectControl
						label={ __(
							'Art der Angabe',
							'waldorf-pfirsichbluete'
						) }
						help={ __(
							'Telefonnummern und E-Mail-Adressen werden automatisch anklickbar.',
							'waldorf-pfirsichbluete'
						) }
						value={ linkType }
						options={ [
							{
								label: __(
									'Nur Text',
									'waldorf-pfirsichbluete'
								),
								value: 'plain',
							},
							{
								label: __(
									'Adresse (mehrzeilig)',
									'waldorf-pfirsichbluete'
								),
								value: 'address',
							},
							{
								label: __(
									'Telefonnummer',
									'waldorf-pfirsichbluete'
								),
								value: 'telephone',
							},
							{
								label: __(
									'E-Mail-Adresse',
									'waldorf-pfirsichbluete'
								),
								value: 'email',
							},
						] }
						onChange={ ( type ) =>
							setAttributes( { linkType: type } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<RichText
					tagName="span"
					value={ label }
					allowedFormats={ [] }
					placeholder={ __(
						'Bezeichnung',
						'waldorf-pfirsichbluete'
					) }
					onChange={ ( content ) =>
						setAttributes( { label: content } )
					}
				/>
				<RichText
					tagName="b"
					value={ value }
					allowedFormats={ [] }
					placeholder={ __(
						'Kontaktangabe oder Zeit',
						'waldorf-pfirsichbluete'
					) }
					onChange={ ( content ) =>
						setAttributes( { value: content } )
					}
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
