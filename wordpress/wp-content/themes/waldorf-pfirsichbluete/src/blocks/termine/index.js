import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
	Placeholder,
	PanelBody,
	RangeControl,
	TextControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { __, sprintf, _n } from '@wordpress/i18n';

import metadata from './block.json';

/**
 * Dates live in the waldorf_termin post type, so the editor shows how many
 * upcoming entries exist rather than letting them be typed in twice.
 *
 * @param {Object}   root0               Block props.
 * @param {Object}   root0.attributes    Block attributes.
 * @param {Function} root0.setAttributes Attribute setter.
 */
function Edit( { attributes, setAttributes } ) {
	const total = useSelect( ( select ) => {
		const records = select( coreStore ).getEntityRecords(
			'postType',
			'waldorf_termin',
			{ per_page: 100, status: 'publish' }
		);
		return records ? records.length : null;
	}, [] );

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody
					title={ __( 'Terminliste', 'waldorf-pfirsichbluete' ) }
				>
					<TextControl
						__nextHasNoMarginBottom
						label={ __( 'Überschrift', 'waldorf-pfirsichbluete' ) }
						value={ attributes.heading }
						onChange={ ( heading ) => setAttributes( { heading } ) }
					/>
					<RangeControl
						__nextHasNoMarginBottom
						label={ __(
							'Anzahl der Termine',
							'waldorf-pfirsichbluete'
						) }
						value={ attributes.count }
						onChange={ ( count ) => setAttributes( { count } ) }
						min={ 1 }
						max={ 12 }
					/>
				</PanelBody>
			</InspectorControls>

			<Placeholder
				icon="calendar-alt"
				label={
					attributes.heading ||
					__( 'Termine', 'waldorf-pfirsichbluete' )
				}
				instructions={ __(
					'Termine werden im Backend unter „Termine“ gepflegt. Vergangene Termine verschwinden automatisch, „Intern“ bleibt unsichtbar.',
					'waldorf-pfirsichbluete'
				) }
			>
				{ total === null
					? __( 'Termine werden geladen …', 'waldorf-pfirsichbluete' )
					: sprintf(
							/* translators: 1: how many are shown, 2: how many exist. */
							_n(
								'Es wird %1$d Termin angezeigt (%2$d insgesamt angelegt).',
								'Es werden bis zu %1$d Termine angezeigt (%2$d insgesamt angelegt).',
								attributes.count,
								'waldorf-pfirsichbluete'
							),
							attributes.count,
							total
					  ) }
			</Placeholder>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
