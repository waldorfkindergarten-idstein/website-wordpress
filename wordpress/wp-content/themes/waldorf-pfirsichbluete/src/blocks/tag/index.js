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
	const { isForestDay, text, title, weekday } = attributes;
	const blockProps = useBlockProps( {
		className: `pb-day${ isForestDay ? ' pb-day--forest' : '' }`,
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Wochentag', 'waldorf-pfirsichbluete' ) }
				>
					<ToggleControl
						label={ __(
							'Waldtag hervorheben',
							'waldorf-pfirsichbluete'
						) }
						checked={ isForestDay }
						onChange={ ( value ) =>
							setAttributes( { isForestDay: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<RichText
					tagName="div"
					className="pb-day__name"
					placeholder={ __( 'Wochentag', 'waldorf-pfirsichbluete' ) }
					value={ weekday }
					allowedFormats={ [] }
					onChange={ ( value ) =>
						setAttributes( { weekday: value } )
					}
				/>
				<RichText
					tagName="h4"
					placeholder={ __( 'Angebot', 'waldorf-pfirsichbluete' ) }
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
