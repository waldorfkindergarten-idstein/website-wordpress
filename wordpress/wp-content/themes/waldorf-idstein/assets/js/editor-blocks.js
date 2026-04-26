( function ( blocks, element, blockEditor, components, i18n ) {
  var el = element.createElement;
  var Fragment = element.Fragment;
  var useBlockProps = blockEditor.useBlockProps;
  var RichText = blockEditor.RichText;
  var PlainText = blockEditor.PlainText;
  var Button = components.Button;
  var TextControl = components.TextControl;
  var TextareaControl = components.TextareaControl;
  var __ = i18n.__;

  blocks.registerBlockType( 'waldorf-idstein/news-panel', {
    title: __( 'Aktuelles', 'waldorf-idstein' ),
    icon: 'megaphone',
    category: 'widgets',
    description: __( 'Zeigt die neuesten Neuigkeiten automatisch an.', 'waldorf-idstein' ),
    edit: function () {
      var blockProps = useBlockProps( { className: 'news-panel-editor-placeholder' } );

      return el(
        'div',
        blockProps,
        el( 'strong', {}, __( 'Aktuelles', 'waldorf-idstein' ) ),
        el( 'p', {}, __( 'Dieser Block zeigt auf der Website automatisch die neuesten Beiträge an.', 'waldorf-idstein' ) )
      );
    },
    save: function () {
      return null;
    }
  } );

  blocks.registerBlockType( 'waldorf-idstein/tagesrhythmus', {
    title: __( 'Tagesrhythmus', 'waldorf-idstein' ),
    icon: 'clock',
    category: 'widgets',
    description: __( 'Bearbeitbarer Tagesablauf mit Zeit und Beschreibung.', 'waldorf-idstein' ),
    attributes: {
      badgeText: { type: 'string', default: 'Tagesrhythmus' },
      heading: { type: 'string', default: 'Verlässliche Abläufe geben Sicherheit' },
      intro: { type: 'string', default: 'Wir gestalten den Tag so, dass Kinder durch Nachahmung und Wiederholung lernen. Offenes Spiel, ritualisierte Kreise, gemeinsames Essen und Waldzeit wechseln sich ab – ruhig, überschaubar und liebevoll geführt.' },
      rows: { type: 'array', default: [] }
    },
    edit: function ( props ) {
      var attributes = props.attributes;
      var rows = attributes.rows && attributes.rows.length ? attributes.rows : [];
      var blockProps = useBlockProps( { className: 'tagesrhythmus-editor' } );

      function updateRow( index, key, value ) {
        var nextRows = rows.slice();
        nextRows[ index ] = Object.assign( {}, nextRows[ index ], key === 'replace' ? value : null );

        if ( key !== 'replace' ) {
          nextRows[ index ][ key ] = value;
        }

        props.setAttributes( { rows: nextRows } );
      }

      function addRow() {
        props.setAttributes( {
          rows: rows.concat( [ { time: '', text: '' } ] )
        } );
      }

      function removeRow( index ) {
        props.setAttributes( {
          rows: rows.filter( function ( _, currentIndex ) {
            return currentIndex !== index;
          } )
        } );
      }

      return el(
        'div',
        blockProps,
        el( RichText, {
          tagName: 'p',
          className: 'badge',
          value: attributes.badgeText,
          allowedFormats: [],
          placeholder: __( 'Badge', 'waldorf-idstein' ),
          onChange: function ( value ) {
            props.setAttributes( { badgeText: value } );
          }
        } ),
        el( RichText, {
          tagName: 'h2',
          value: attributes.heading,
          allowedFormats: [],
          placeholder: __( 'Überschrift', 'waldorf-idstein' ),
          onChange: function ( value ) {
            props.setAttributes( { heading: value } );
          }
        } ),
        el( RichText, {
          tagName: 'p',
          value: attributes.intro,
          placeholder: __( 'Einleitung', 'waldorf-idstein' ),
          onChange: function ( value ) {
            props.setAttributes( { intro: value } );
          }
        } ),
        el(
          'div',
          { className: 'tagesrhythmus-editor-rows' },
          rows.map( function ( row, index ) {
            return el(
              'div',
              { className: 'tagesrhythmus-editor-row', key: index },
              el( TextControl, {
                label: __( 'Uhrzeit', 'waldorf-idstein' ),
                value: row.time || '',
                onChange: function ( value ) {
                  updateRow( index, 'time', value );
                }
              } ),
              el( TextareaControl, {
                label: __( 'Beschreibung', 'waldorf-idstein' ),
                value: row.text || '',
                onChange: function ( value ) {
                  updateRow( index, 'text', value );
                }
              } ),
              el( Button, {
                isSecondary: true,
                onClick: function () {
                  removeRow( index );
                }
              }, __( 'Zeile entfernen', 'waldorf-idstein' ) )
            );
          } ),
          el( Button, {
            isPrimary: true,
            onClick: addRow
          }, __( 'Zeile hinzufügen', 'waldorf-idstein' ) )
        )
      );
    },
    save: function () {
      return null;
    }
  } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.i18n );
