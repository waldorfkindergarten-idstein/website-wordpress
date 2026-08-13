import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, Notice, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( { className: 'pb-date-pill' } );
	const isAuto = attributes.source !== 'manual';

	const upcoming = useSelect(
		( select ) => {
			if ( ! isAuto ) {
				return undefined;
			}
			return select( coreStore ).getEntityRecords(
				'postType',
				'waldorf_termin',
				{ per_page: 100, status: 'publish' }
			);
		},
		[ isAuto ]
	);

	const controls = (
		<InspectorControls>
			<PanelBody
				title={ __( 'Terminhinweis', 'waldorf-pfirsichbluete' ) }
			>
				<ToggleControl
					__nextHasNoMarginBottom
					label={ __(
						'Nächstes Fest automatisch anzeigen',
						'waldorf-pfirsichbluete'
					) }
					help={ __(
						'Aus den Terminen im Backend. Ist kein Fest mehr in der Zukunft, wird der Hinweis ausgeblendet.',
						'waldorf-pfirsichbluete'
					) }
					checked={ isAuto }
					onChange={ ( on ) =>
						setAttributes( { source: on ? 'auto' : 'manual' } )
					}
				/>
			</PanelBody>
		</InspectorControls>
	);

	if ( isAuto ) {
		return (
			<div { ...blockProps }>
				{ controls }
				<RichText
					tagName="span"
					className="pb-eyebrow"
					value={ attributes.eyebrow }
					allowedFormats={ [] }
					placeholder={ __( 'Hinweis …', 'waldorf-pfirsichbluete' ) }
					onChange={ ( eyebrow ) => setAttributes( { eyebrow } ) }
				/>
				<Notice status="info" isDismissible={ false }>
					{ upcoming && upcoming.length === 0
						? __(
								'Noch keine Termine angelegt — der Hinweis bleibt vorerst unsichtbar.',
								'waldorf-pfirsichbluete'
						  )
						: __(
								'Name und Datum kommen automatisch vom nächsten Fest.',
								'waldorf-pfirsichbluete'
						  ) }
				</Notice>
			</div>
		);
	}

	return (
		<div { ...blockProps }>
			{ controls }
			<RichText
				tagName="span"
				className="pb-eyebrow"
				value={ attributes.eyebrow }
				allowedFormats={ [] }
				placeholder={ __( 'Hinweis …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( eyebrow ) => setAttributes( { eyebrow } ) }
			/>
			<RichText
				tagName="b"
				value={ attributes.title }
				allowedFormats={ [] }
				placeholder={ __( 'Terminname …', 'waldorf-pfirsichbluete' ) }
				onChange={ ( title ) => setAttributes( { title } ) }
			/>
			<RichText
				tagName="span"
				value={ attributes.date }
				allowedFormats={ [] }
				placeholder={ __(
					'Datum und Uhrzeit …',
					'waldorf-pfirsichbluete'
				) }
				onChange={ ( date ) => setAttributes( { date } ) }
			/>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
