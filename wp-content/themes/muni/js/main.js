'use strict';

var j = jQuery.noConflict();

(function($) {
  // var $win = j(window);
  var $doc = j(document);

  $doc.on('ready', function() {
    // FormValidation Contact and Susbcribe
    j('#js-form-subs').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        email: {
          validators: {
            remote: {
              message: 'Email ya se encuentra registrado.',
              url: MuniAjax.url,
              data: {
                nonce: MuniAjax.nonce,
                action: 'validate_email_subscriber',
                email: 'email'
              },
              type: 'POST'
            }
          }
        }
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv   = j(e.target).data('formValidation');

      var email = j('input[name="email"]').val();
      var msg = j('#js-form-subs-msg');
      var loader = j('#js-form-subs-loader');

      loader.removeClass('hidden');
      msg.text('');

      j.post(MuniAjax.url, {
        nonce: MuniAjax.nonce,
        action: 'register_subscriptor',
        email: email
      }, function(data) {
        $form.data('formValidation').resetForm(true);

        if(data.result) {
          msg.text('Se agregó correctamente a nuestra lista de suscriptores.');
        } else {
          msg.text(data.error);
        }

        loader.addClass('hidden');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).text('');
          });
        }, 5000);
      }, 'json').fail(function(){
        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });
  });

})(jQuery);
