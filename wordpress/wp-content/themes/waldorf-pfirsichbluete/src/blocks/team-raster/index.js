import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Placeholder } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { __, sprintf, _n } from '@wordpress/i18n';

import metadata from './block.json';

/**
 * The members themselves are edited under "Team" in wp-admin, not here, so the
 * editor only confirms how many will render and where to change them.
 */
function Edit() {
	const count = useSelect( ( select ) => {
		const records = select( coreStore ).getEntityRecords(
			'postType',
			'waldorf_person',
			{ per_page: 40, status: 'publish' }
		);
		return records ? records.length : null;
	}, [] );

	return (
		<div { ...useBlockProps() }>
			<Placeholder
				icon="groups"
				label={ __( 'Team', 'waldorf-pfirsichbluete' ) }
				instructions={ __(
					'Die Teammitglieder werden im Backend unter „Team“ gepflegt. Reihenfolge über das Feld „Reihenfolge“.',
					'waldorf-pfirsichbluete'
				) }
			>
				{ count === null
					? __(
							'Teammitglieder werden geladen …',
							'waldorf-pfirsichbluete'
					  )
					: sprintf(
							/* translators: %d: number of published team members. */
							_n(
								'%d veröffentlichtes Teammitglied',
								'%d veröffentlichte Teammitglieder',
								count,
								'waldorf-pfirsichbluete'
							),
							count
					  ) }
			</Placeholder>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
