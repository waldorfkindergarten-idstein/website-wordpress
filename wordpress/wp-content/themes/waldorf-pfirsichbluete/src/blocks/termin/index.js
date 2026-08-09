import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

const MONTHS = [ 'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez' ];

function getDateParts( date ) {
	const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec( date );
	const month = match ? Number.parseInt( match[ 2 ], 10 ) : 0;

	if ( ! match || month < 1 || month > 12 ) {
		return { day: '--', month: '---' };
	}

	return { day: match[ 3 ], month: MONTHS[ month - 1 ] };
}

function Edit( { attributes, setAttributes } ) {
	const { date, detail, title } = attributes;
	const dateParts = getDateParts( date );
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Datum', 'waldorf-pfirsichbluete' ) }>
					<TextControl
						label={ __( 'Tag auswählen', 'waldorf-pfirsichbluete' ) }
						type="date"
						value={ date }
						onChange={ ( value ) => setAttributes( { date: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<li { ...blockProps }>
				<div className="pb-termine__date">
					<b>{ dateParts.day }</b>
					<span>{ dateParts.month }</span>
				</div>
				<div className="pb-termine__info">
					<RichText
						tagName="b"
						value={ title }
						allowedFormats={ [] }
						placeholder={ __( 'Titel', 'waldorf-pfirsichbluete' ) }
						onChange={ ( value ) => setAttributes( { title: value } ) }
					/>
					<RichText
						tagName="span"
						value={ detail }
						allowedFormats={ [] }
						placeholder={ __( 'Uhrzeit und Hinweis', 'waldorf-pfirsichbluete' ) }
						onChange={ ( value ) => setAttributes( { detail: value } ) }
					/>
				</div>
			</li>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
