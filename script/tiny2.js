


/**
 * Product view shortcode adding
 */
(function() {
   tinymce.PluginManager.add('video_link', function( ed, url ) {

        ed.addButton('video_link', {
            text : 'Video Link',
            cmd : 'video_link_cb',
            icon: 'dashicon icon-product-editor'
        });

        ed.addCommand('video_link_cb', function(editor, values, onsubmit_callback) {
          if(!values){
            values = [];
          }

          var shortcode_string = 'video_link';

          if(typeof onsubmit_callback != 'function'){
                onsubmit_callback = function( e ) {
                   var attributes = jQuery('.attributes-form').serializeArray();

                   var html = '';


                   var args = {
                        tag     : shortcode_string,
                        attrs : {
                          text       :  e.data.text,
                          url        :  e.data.url,
                          type       :  e.data.type,
                        }
                      };

                    for(id in attributes){
                      var name = attributes[id].name;
                      var value = attributes[id].value;
                      args.attrs[name]= value;
                    }


                   ed.insertContent( wp.shortcode.string( args ) );
                };
            }

            var body = [];

                select_options = null;

                body[0] = {
                    type: 'textbox',
                    name:  'text',
                    value: values.text,
                    label: 'Text',
                    placeholder: 'text',
                    style: 'height: 50px;',
                    multiline: true,
                };

                body[1] = {
                    type: 'textbox',
                    name:  'url',
                    value: values.url,
                    label: 'Video Url',
                    style: 'height: 50px;',
                    multiline: true,
                };

                var values = [
                {value: 'youtube', text: 'Youtube Video'},
                {value: 'plain', text: 'Video on current site'}
                ];

                body[2] = {
                  type   :"listbox",
                  label   : 'Video Sourse',
                  name    :  'type',
                  values : values,
                };



            ed.windowManager.open( {
                title    : 'Insert video Link',
                body     : body,
                style    : 'width: 480px',
                onsubmit : onsubmit_callback,
                classes  :' product-lp-popup'
            } );
        });
    });

   tinymce.PluginManager.add('theme_marked_button', function( ed, url ) {

        ed.addButton('theme_marked_button', {
            title : 'Inserts a link, that looks like a button',
            text : 'Insert Button',
            cmd : 'theme_marked_button_cb',
            icon: 'dashicon icon-product-editor'
        });

        ed.addCommand('theme_marked_button_cb', function(editor, values, onsubmit_callback) {
          if(!values){
            values = [];
          }

          var shortcode_string = 'marked_button';

            if(typeof onsubmit_callback != 'function'){
                onsubmit_callback = function( e ) {
                   var attributes = jQuery('.attributes-form').serializeArray();

                   var html = '';


                   var args = {
                        tag     : shortcode_string,
                        attrs : {
                          text         :  e.data.text,
                          url          :  e.data.url,
                          arrow       :  e.data.arrow,
                          style        :  e.data.style,
                          bgcolor        :  e.data.bgcolor,
                        }
                      };

                    for(id in attributes){
                      var name = attributes[id].name;
                      var value = attributes[id].value;
                      args.attrs[name]= value;
                    }


                   ed.insertContent( wp.shortcode.string( args ) );
                };
            }

            var body = [];

                select_options = null;


                body[0] = {
                    type: 'textbox',
                    name:  'text',
                    value: values.text,
                    label: 'Text',
                    style: 'height: 60px;',
                    multiline: true,
                };

                body[1] = {
                    type: 'textbox',
                    name:  'url',
                    value: values.url,
                    label: 'Button Url',
                    style: 'height: 60px;',
                    multiline: true,
                };
                var values = [
                {value: '', text: 'Blue Button'},
                {value: 'button_w', text: 'White Button'}
                ];

                body[2] = {
                  type   :"listbox",
                  label   : 'Button color',
                  name    :  'bgcolor',
                  values : values,
                };

                body[3] = {
                    type: 'Checkbox',
                    name:  'arrow',
                    value: 'yes',
                    label: 'Show Arrow',
                };

                // body[4] = {
                //     type: 'Checkbox',
                //     name:  'style',
                //     value: 'yes',
                //     label: 'Use page styles',
                // };



            ed.windowManager.open( {
                title    : 'Insert a button',
                body     : body,
                style    : 'width: 480px',
                onsubmit : onsubmit_callback,
            } );
        });
    });
})();
