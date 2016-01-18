( function( $ ) {

    tinymce.PluginManager.add( 'columns', function( editor ) {
        editor.addButton( 'columns', {
            //type: 'panelbutton',
            type: 'panelbutton',
            tooltip: editor.editorManager.i18n.translate( 'Columns' ),
            icon: 'columns',
            panel: {
                role: 'application',
                html: renderColumnsPanel,
                onclick: function( e ) {
                    var columnSet = $( editor.dom.getParent( editor.selection.getNode(), '.columns' )),
                        columns = $( 'div.column', columnSet ),
                        content = [], isLiquid = $( '#liquid-text' ).is(':checked'), insert = '', i;

                    if ( columnSet.length ) {
                        if ( columns.length ) {
                            for ( i = 0; i < columns.length; i++ ) {
                                content.push( columns[i].innerHTML.trim() );
                            }
                        }
                        // liquid
                        else content = [columnSet[0].innerHTML.trim()];
                    }
                    else {
                        content = [tinyMCE.activeEditor.selection.getContent()];
                        if ( content[0] ) content[0] = '<p>' + content[0] + '</p>';
                    }

                    // number of columns
                    columns = $( e.target ).closest( 'td' ).data( 'columns' );
                    if ( typeof columns === 'undefined' ) e.stopPropagation();
                    else {
                        // remove
                        if ( columns == 1 ) insert = content.join( '' );
                        // columns
                        else {
                            if ( !isNumeric( columns ) ) {
                                var widths = columns.split( '-' );
                                columns = widths.length;
                            }

                            insert = '<div class="columnwrapper"><div class="columns columns-' + columns + ( isLiquid ? ' columns-liquid' : '' ) + '" data-columns="' + columns + '">';

                            for ( i = 0; i < columns; i++ ) {
                                // for more 'content' then columns
                                // put rest in last column
                                if ( i == columns - 1 ) content[i] = content.slice(i).join( '' );

                                if ( !isLiquid )
                                    insert += '<div class="column column-' + (i+1) + ( widths ? ' column-' + widths[i] : '' ) + '">';

                                insert += ( content[i] || '<p>' + editor.editorManager.i18n.translate( 'Column' ) + ' ' + (i+1) + '</p>' );

                                if ( !isLiquid ) insert += '</div>'; // column
                            }
                            insert += '</div></div>'; // columns
                        }

                        insert = '&nbsp;' + insert + '&nbsp;';

                        // replace vs. insert
                        if ( columnSet.length ) {
                            columnSet.after( insert ).remove();
                        }
                        else editor.insertContent( insert );

                        // close panel
                        this.hide();
                    }
                }
            },
            onPostRender: function() {
                var columnsButton = this,
                    events = ['nodechange', 'click', 'show'];

                for ( var i = 0; i < events.length; i++ ) {
                    editor.on( events[i], function( e ) {
                        var body = editor.dom.getParent( editor.selection.getNode(), 'body' );
                        $( 'div.columns', $( body ) ).removeClass( 'active' );

                        var columns = editor.dom.getParent( editor.selection.getNode(), '.columns' );
                        $( columns ).addClass( 'active' );
                        columnsButton.active( columns );
                    });
                }
            }
        });

        function isNumeric( value ) {
            return !isNaN( parseFloat( value ) ) && isFinite( value );
        }

        function renderColumnsPanel() {
            var html = '<table class="mce-grid mce-grid-border mce-columns-grid"><tbody>';

            // liquid text
            html += '<tr style="display:none;"><td colspan="10"><input id="liquid-text" type="checkbox" /><label for="liquid-text">Liquid Text</label></td></tr>';

            // free select
            html += '<tr>';
            for ( var i = 1; i < 10; i++ ) {
                html += '<td data-columns="' + i + '"><span>' + ( i > 1 ? i : '&times;' ) + '</span></td>';
            }
            html += '</tr>';

            // narrow - wide
            html += '<tr><td data-columns="narrow-wide" colspan="3"><span>1/3</span></td><td data-columns="narrow-wide" colspan="6"><span>2/3</span></td></tr>';

            // narrow - wide
            html += '<tr><td data-columns="wide-narrow" colspan="6"><span>2/3</span></td><td data-columns="wide-narrow" colspan="3"><span>1/3</span></td></tr>';

             // narrow - wide
            html += '<tr><td data-columns="full" colspan="12"><span>3</span></td></tr>';

            html += '</tbody></table>';

            return html
        }
    });

} )( jQuery );
