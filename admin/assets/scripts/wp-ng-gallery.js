(function ($) {
  'use strict';

  $(document).ready(function () {
    if ('undefined' === typeof (wp) || 'undefined' === typeof (wp.media)) {
      return;
    }


    var set_theme = function ( ng_modules ){

      console.log(ng_modules);

      ng_modules.$el_select_theme.html('');

      var module_index = ng_modules.data.map(function(o) { return o.name; }).indexOf(ng_modules.current_module);

      if ( module_index !== -1 && ng_modules.current_type !== '' && !$.isEmptyObject(ng_modules.data[module_index].themes[ng_modules.current_type]) ) {

        $.each(ng_modules.data[module_index].themes[ng_modules.current_type], function(i, value) {
          ng_modules.$el_select_theme.append($('<option>').text(value).attr('value', i));
        });
        ng_modules.$el_theme.show();
      }
      else {
        ng_modules.$el_select_theme.html(ng_modules.$el_theme_options_default);
        ng_modules.$el_theme.hide();
      }

      ng_modules.current_theme = ng_modules.$el_select_theme.val();
      ng_modules.mediaGallery.update.apply(ng_modules.mediaGallery, ['theme']);
    };

    var set_type  = function ( ng_modules ) {

      console.log(ng_modules);

      ng_modules.$el_select_type.html('');

      var module_index = ng_modules.data.map(function(o) { return o.name; }).indexOf(ng_modules.current_module);

      if ( module_index !== -1 && !$.isEmptyObject(ng_modules.data[module_index].types) ) {

        $.each(ng_modules.data[module_index].types, function(i, value) {
          ng_modules.$el_select_type.append($('<option>').text(value).attr('value', i));
        });
        ng_modules.$el_type.show();
      }
      else {
        ng_modules.$el_select_type.html(ng_modules.$el_type_options_default);
        ng_modules.$el_type.hide();
      }

      ng_modules.current_type = ng_modules.$el_select_type.val();
      ng_modules.mediaGallery.update.apply(ng_modules.mediaGallery, ['type']);
    };

    var get_ng_modules = function ( $el ) {
      var $el_settings = $el.find('#ng_module_settings');
      var $el_select = $el_settings.find('select');

      var $el_type = $el.find('#ng_module_type');
      var $el_theme = $el.find('#ng_module_theme');
      var $el_select_type = $el_type.find('select');
      var $el_select_theme = $el_theme.find('select');

      var ng_modules = {
        $element: $el_settings,
        $el_select: $el_select,
        $el_type: $el_type,
        $el_theme: $el_theme,
        $el_select_type: $el_select_type,
        $el_select_theme: $el_select_theme,
        $el_type_options_default: $el_type.html(),
        $el_theme_options_default: $el_theme.html()
      };

      if ($el_settings[0]) {
        ng_modules.data = JSON.parse($el_settings.data('ng-modules').replace(/\'/g, '\"'));
      }

      console.log(ng_modules);

      return ng_modules;
    };


    var media = wp.media;

    media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
      render: function () {
        var $el = this.$el;
        media.view.Settings.prototype.render.apply(this, arguments);

        $el.append(media.template('wp-ng-gallery-settings'));

        //Set default value
        media.gallery.defaults.ng_module = '';
        media.gallery.defaults.type = '';
        media.gallery.defaults.theme = '';


        var ng_modules = {};

        try {

          //Get module object
          ng_modules = get_ng_modules($el);

          //Apply model ng_module.
          this.update.apply(this, ['ng_module']);

          ng_modules.mediaGallery = this;
          ng_modules.current_module = this.model.get('ng_module');

          if (ng_modules.current_module === '') {
            ng_modules.$el_type.hide();
            ng_modules.$el_theme.hide();
          }

        }
        catch (e) {
          console.logError(e);
        }

        if (ng_modules.data) {

          console.log(ng_modules);

          //Module Change
          ng_modules.$el_select.change(function () {
            ng_modules.current_module = ng_modules.$el_select.val();

            if (ng_modules.current_module === '') {
              ng_modules.$el_select_type.val('').change();
              ng_modules.$el_select_theme.val('').change();
            }

            set_type(ng_modules);
            set_theme(ng_modules);
          });

          //Type Change
          ng_modules.$el_select_type.change(function () {
            ng_modules.current_type = ng_modules.$el_select_type.val();

            set_theme(ng_modules);
          });


          //Init
          set_type(ng_modules);
          ng_modules.current_type = this.model.get('type');

          set_theme(ng_modules);
          ng_modules.current_theme = this.model.get('theme');
        }

        return this;
      }
    });
  });

}(jQuery));

