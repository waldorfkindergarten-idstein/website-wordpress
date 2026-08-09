import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { detail, isExtended, time, title } = attributes;
	const blockProps = useBlockProps( {
		className: `pb-tl${ isExtended ? ' pb-tl--optional' : '' }`,
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Tagesablauf', 'waldorf-pfirsichbluete' ) }
				>
					<ToggleControl
						label={ __(
							'Als verlängerte Betreuung markieren',
							'waldorf-pfirsichbluete'
						) }
						checked={ isExtended }
						onChange={ ( value ) =>
							setAttributes( { isExtended: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<li { ...blockProps }>
				<div className="pb-tl__time">
					<RichText
						tagName="span"
						placeholder={ __(
							'Uhrzeit',
							'waldorf-pfirsichbluete'
						) }
						value={ time }
						allowedFormats={ [] }
						onChange={ ( value ) =>
							setAttributes( { time: value } )
						}
					/>
					{ isExtended && (
						<span className="pb-tl__badge">
							{ __( 'Verlängert', 'waldorf-pfirsichbluete' ) }
						</span>
					) }
				</div>
				<RichText
					tagName="div"
					className="pb-tl__title"
					placeholder={ __( 'Titel', 'waldorf-pfirsichbluete' ) }
					value={ title }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { title: value } ) }
				/>
				<RichText
					tagName="div"
					className="pb-tl__sub"
					placeholder={ __( 'Zusatz', 'waldorf-pfirsichbluete' ) }
					value={ detail }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { detail: value } ) }
				/>
			</li>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
