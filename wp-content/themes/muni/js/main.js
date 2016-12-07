'use strict';

var j = jQuery.noConflict();

(function($) {
  var $win = j(window);
  var $doc = j(document);
  var body = j('body');

  $win.on('resize', function(){
    if (typeof playerInfoList === 'undefined') return;

    for (var i in players) {
      if (players[i].a.className === 'Single-video') {
        if ($win.width() < 500) {
          resizeVideoPlayer(players[i], '320', '240');
        } else {
          resizeVideoPlayer(players[i], '480', '270');
        }
      }
    }

    if (typeof player !== 'undefined') {
      if ($win.width() < 500) {
        resizeVideo('320', '240');
      } else {
        resizeVideo('480', '270');
      }
    }

    if (map) {
      var $map = j('#map');
      if ($map.length) {
        var lat = parseFloat($map.data('lat')),
            long = parseFloat($map.data('long'));

        map.setCenter({lat: lat, lng: long});
      }
    }
  });

  $doc.on('ready', function() {
    // FormValidation Susbcribers
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

      var email = j('input[name="emailsub"]').val();
      var msg = j('#js-form-subs-msg');
      var loader = j('#js-form-subs-loader');

      loader.removeClass('hidden').find('span').addClass('rotateIn');
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

        loader.addClass('hidden').find('span').removeClass('rotateIn');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).text('');
          });
        }, 5000);
      }, 'json').fail(function(){
        loader.addClass('hidden').find('span').removeClass('rotateIn');
        $form.data('formValidation').resetForm(true);

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });

    // FormValidation Contacts
    j('#js-frm-contact').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        phone: {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        },
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv   = j(e.target).data('formValidation');

      var name = j('input[name="name"]').val(),
          lastname = j('input[name="lastname"]').val(),
          email = j('input[name="email"]').val(),
          phone = j('input[name="phone"]').val(),
          address = j('input[name="address"]').val(),
          urba = j('input[name="urba"]').val(),
          message = j('textarea[name="message"]').val(),
          subject = j('select[name="subject"]').val();
      subject = parseInt(subject);

      var msg = j('#js-form-contact-msg'),
          loader = j('#js-form-contact-loader');

      if (subject > 0) {
        loader.removeClass('hidden').find('span').addClass('rotateIn');
        msg.text('');

        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'register_contact',
          name: name,
          lastname: lastname,
          email: email,
          phone: phone,
          address: address,
          urba: urba,
          phone: phone,
          subject: subject,
          message: message,
        }, function(data) {
          $form.data('formValidation').resetForm(true);

          if(data.result) {
            msg.text('Ya tenemos su consulta. En breve nos pondremos en contacto con usted.');
          } else {
            msg.text(data.error);
          }

          loader.addClass('hidden').find('span').removeClass('rotateIn');
          msg.fadeIn('slow');
          setTimeout(function(){
            msg.fadeOut('slow', function(){
              j(this).text('');
            });
          }, 5000);
        }, 'json').fail(function(){
          loader.addClass('hidden').find('span').removeClass('rotateIn');
          $form.data('formValidation').resetForm(true);

          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      }
    });

    j('.js-select-directory').on('change', function() {
      var $this = j(this),
          termId = parseInt($this.data('id')),
          value = parseInt($this.val());

      var square = $this.parent().next('.Square'),
          loader = square.find('.Square-loader'),
          title = square.find('.Title-semi'),
          phone = square.find('.Title-bold');

      if ( !value) {
        return false;
      }

      square.removeClass('hidden');
      title.addClass('hidden');
      phone.addClass('hidden');
      loader.addClass('infinite').removeClass('hidden');

      j.post(MuniAjax.url, {
        nonce: MuniAjax.nonce,
        action: 'get_directory',
        termid: termId,
        value: value,
      }, function(data) {
        if(data.result) {
          title.text(data.data.title).removeClass('hidden');
          phone.text(data.data.number).removeClass('hidden');
        } else {
          title.text(data.error);
        }

        loader.addClass('hidden').removeClass('infinite');
      }, 'json').fail(function(){
        loader.addClass('hidden').removeClass('infinite');

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });

    j('#carousel-programs-events').on('slide.bs.carousel', function (ev) {
      var $this = j(this);

      if (typeof playerInfoList === 'undefined') return;

      for (var i in players) {
        if (players[i].a.className === 'Page-video') {
          if (players[i].getPlayerState() === 1) {
            stopVideoPlayer(players[i]);
            $this.carousel('cycle');
          }
        }
      }
    });

    body.on('click', '#js-nav-authorities ul li a', function(ev) {
      ev.preventDefault();

      var $this = j(this),
          page = $this.text();

      if ( page === '»' || page === '«' ) {
        j("#js-nav-authorities .page-numbers li").each( function(index, el) {
          if ( j(this).find('span.current').length ) {
            var current = parseInt(j(this).find('span.current').text());

            page = (page === '»') ? current + 1 : current - 1;
            return false;
          }
        });
      }

      var url = $this.attr("href"),
          role = 0;
      url = url.replace("http://", "");

      role = parseInt(url.split('/')[1]);

      if (role > 0) {
        var loader = j('.Page-body-loader'),
            wrapper = j('.Page-authorities');

        loader.removeClass('hidden').find('.animated').addClass('infinite');

        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_authorities',
          role: role,
          page: page
        }, function(data, textStatus, xhr) {
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          if (data.result) {
            wrapper.html(data.data.content);
          }
        }, 'json').fail(function(){
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      }
    });

    body.on('click', '.js-menu-authorities a', function (ev) {
      ev.preventDefault();

      var $this = j(this),
          idRole = $this.data('id');

      if (idRole > 0) {
        var menus = j('.js-menu-authorities');
        menus.each(function(index, el) {
          j(this).removeClass('active');
        });
        $this.parent().addClass('active');

        var loader = j('.Page-body-loader'),
            wrapper = j('.Page-authorities');

        loader.removeClass('hidden').find('.animated').addClass('infinite');

        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_authorities_role',
          role: idRole
        }, function(data, textStatus, xhr) {
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          if (data.result) {
            wrapper.html(data.data.content);
          } else if (data.error.length) {
            var text = '<p class="text-center text--white h2">' + data.error + '</p>';
            wrapper.html(text);
          }
        }, 'json').fail(function(){
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      }
    });

    body.on('click', '#js-nav-services ul li a', function(ev) {
      ev.preventDefault();

      var $this = j(this),
          page = $this.text();

      if ( page === '»' || page === '«' ) {
        j("#js-nav-services .page-numbers li").each( function(index, el) {
          if ( j(this).find('span.current').length ) {
            var current = parseInt(j(this).find('span.current').text());

            page = (page === '»') ? current + 1 : current - 1;
            return false;
          }
        });
      }

      var url = $this.attr("href"),
          service = 0;
      url = url.replace("http://", "");

      service = parseInt(url.split('/')[1]);

      if (service > 0) {
        var loader = j('.Page-body-loader'),
            wrapper = j('.Cards-wrapper');

        loader.removeClass('hidden').find('.animated').addClass('infinite');

        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_services',
          service: service,
          page: page
        }, function(data, textStatus, xhr) {
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          if (data.result) {
            wrapper.html(data.data.content);
          }
        }, 'json').fail(function(){
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      }
    });

    body.on('click', '.js-menu-services a', function (ev) {
      ev.preventDefault();

      var $this = j(this),
          idService = $this.data('id');

      if (idService > 0) {
        var menus = j('.js-menu-services');
        menus.each(function(index, el) {
          j(this).removeClass('active');
        });
        $this.parent().addClass('active');

        var loader = j('.Page-body-loader'),
            wrapper = j('.Cards-wrapper');

        loader.removeClass('hidden').find('.animated').addClass('infinite');

        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_services_s',
          service: idService
        }, function(data, textStatus, xhr) {
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          if (data.result) {
            wrapper.html(data.data.content);
          } else if (data.error.length) {
            var text = '<p class="text-center text--white h2">' + data.error + '</p>';
            wrapper.html(text);
          }
        }, 'json').fail(function(){
          loader.addClass('hidden').find('.animated').removeClass('infinite');

          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      }
    });

    // Change select dpto
    j('#js-dpto').on('change', function () {
      var $this = j(this),
          idDpto = parseInt($this.val()),
          wrapperProv = j('#js-prov'),
          wrapperDist = j('#js-dist');

      if (idDpto > 0) {
        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_cities',
          id: idDpto,
          title: 'Seleccione Provincia',
        }, function(data, textStatus, xhr) {
          j('select[name="prov"]').val('');
          j('select[name="dist"]').val('');

          $('#js-frm-book, #js-frm-info').formValidation('revalidateField', 'prov');
          $('#js-frm-book, #js-frm-info').formValidation('revalidateField', 'dist');

          if (data.result) {
            wrapperProv.html(data.data.content);
          } else if (data.error.length) {
            wrapperProv.html('<option value="">-- Seleccione Provincia --</option>');
            wrapperDist.html('<option value="">-- Seleccione Distrito --</option>');
          }
        }, 'json').fail(function(){
          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      } else {
        j('select[name="prov"]').val('');
        j('select[name="dist"]').val('');

        // Limpiar select prov y dist
        wrapperProv.html('<option value="">-- Seleccione Provincia --</option>');
        wrapperDist.html('<option value="">-- Seleccione Distrito --</option>');
      }
    });

    // Change select prov
    j('#js-prov').on('change', function () {
      var $this = j(this),
          idProv = parseInt($this.val()),
          wrapper = j('#js-dist');

      if (idProv > 0) {
        j.post(MuniAjax.url, {
          nonce: MuniAjax.nonce,
          action: 'get_cities',
          id: idProv,
          title: 'Seleccione Distrito'
        }, function(data, textStatus, xhr) {
          j('select[name="dist"]').val('');
          j('#js-frm-book, #js-frm-info').formValidation('revalidateField', 'dist');

          if (data.result) {
            wrapper.html(data.data.content);
          } else if (data.error.length) {
            wrapper.html('<option value="">-- Seleccione Distrito --</option>');
          }
        }, 'json').fail(function(){
          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
        });
      } else {
        j('select[name="dist"]').val('');
        j('#js-frm-book, #js-frm-info').formValidation('revalidateField', 'dist');

        // Limpiar select prov y dist
        wrapper.html('<option value="">-- Seleccione Distrito --</option>');
      }
    });

    // FormValidation Book
    j('#js-frm-book').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        dni: {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        },
        phone: {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        },
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv   = j(e.target).data('formValidation'),
          formData = new FormData(),
          params   = $form.serializeArray(),
          files    = $form.find('[name="file"]')[0].files;

      formData.append('nonce', MuniAjax.nonce);
      formData.append('action', 'register_book');

      var checkFile = false;
      $.each(files, function(i, file) {
        if (file.type === 'application/pdf' || file.type === 'image/jpeg' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file.type === 'application/vnd.ms-excel') {
          if (file.size <= 2097152) {
            formData.append('files-' + i, file, file.name);
            checkFile = true;
          }
        }
      });

      if (!checkFile) {
        alert('Verifique que el archivo subido sea PDF, Word o Imagen y que no exceda los 2 Mb.');
        return false;
      }

      $.each(params, function(i, val) {
        formData.append(val.name, val.value);
      });

      var msg = j('#js-form-book-msg'),
          loader = j('#js-form-book-loader');

      loader.removeClass('hidden').find('span').addClass('infinite rotateIn');
      msg.removeClass('alert-success alert-danger').text('');

      $.ajax({
        url: MuniAjax.url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json'
      }).done(function(data){
        $form.data('formValidation').resetForm(true);

        if(data.result === true) {
          msg.addClass('alert-success').text('Ya tenemos su solicitud. En breve nos pondremos en contacto con usted.');
        } else {
          msg.addClass('alert-danger').text(data.error);
        }

        loader.addClass('hidden').find('span').removeClass('rotateIn infinite');
        msg.fadeIn('slow');

        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).text('').removeClass('alert-success alert-danger');
          });
        }, 5000);
      }).fail(function() {
        loader.addClass('hidden').find('span').removeClass('rotateIn');
        $form.data('formValidation').resetForm(true);

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });

    // FormValidation Information
    j('#js-frm-info').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        phone: {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        },
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv   = j(e.target).data('formValidation'),
          formData = new FormData(),
          params   = $form.serializeArray();

      formData.append('nonce', MuniAjax.nonce);
      formData.append('action', 'register_info');

      $.each(params, function(i, val) {
        formData.append(val.name, val.value);
      });

      var msg = j('#js-form-info-msg'),
          loader = j('#js-form-info-loader');

      loader.removeClass('hidden').find('span').addClass('infinite rotateIn');
      msg.removeClass('alert-success alert-danger').text('');

      $.ajax({
        url: MuniAjax.url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json'
      }).done(function(data){
        $form.data('formValidation').resetForm(true);

        if(data.result === true) {
          msg.addClass('alert-success').text('Ya tenemos su solicitud. En breve nos pondremos en contacto con usted.');
        } else {
          msg.addClass('alert-danger').text(data.error);
        }

        loader.addClass('hidden').find('span').removeClass('rotateIn infinite');
        msg.fadeIn('slow');

        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).text('').removeClass('alert-success alert-danger');
          });
        }, 5000);
      }).fail(function() {
        loader.addClass('hidden').find('span').removeClass('rotateIn');
        $form.data('formValidation').resetForm(true);

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo');
      });
    });
  });
})(jQuery);
