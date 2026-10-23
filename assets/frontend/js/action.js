$(document).ready(function(){
    // CSRF Token
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    // Save Form
   $(document).on('input change', '.submitForm input, .submitForm textarea', function() {
        var fieldId = $(this).attr('id');
        $(this).removeClass('is-invalid');
        $('[data-for="' + fieldId + '"]').html('');
        $(this).closest('.input-wrapper').find('p').removeClass('invalid-feedback').html('');
    });

    // Submit form
    $('.submitForm').submit(function(e) {
        e.preventDefault();

        var formElement = $(this);
        var storeUrl = formElement.data('storeurl');
        var submitBtn = formElement.find('[type="submit"]');
        var originalHtml = submitBtn.data('original-html') || submitBtn.html();

        function refreshCaptcha(captchaData) {
            if (!captchaData || !captchaData.html) {
                return;
            }

            $('#captcha-box').html(captchaData.html);
            $('#captcha').val('').removeClass('is-invalid');
            $('#captcha').closest('.input-wrapper').find('p').removeClass('invalid-feedback').html('');
        }

        submitBtn.data('original-html', originalHtml);
        submitBtn
            .prop('disabled', true)
            .addClass('is-loading')
            .html('<i class="fas fa-spinner fa-spin"></i> Sending...');

        $.ajax({
            url: storeUrl,
            type: 'post',
            data: new FormData(formElement[0]),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                submitBtn
                    .prop('disabled', false)
                    .removeClass('is-loading')
                    .html(originalHtml);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                if (data.status === true) {
                    formElement[0].reset();
                    refreshCaptcha(data.captcha);
                    Toast.fire({ icon: 'success', title: data.message });

                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 2000);
                    }
                } else {
                    refreshCaptcha(data.captcha);
                    Toast.fire({ icon: 'error', title: data.message });

                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 2000);
                    }

                    $.each(data.errors, function(key, value) {
                        var field = $('#' + key);
                        field.addClass('is-invalid');
                        field.closest('.input-wrapper').find('p')
                            .addClass('invalid-feedback')
                            .html(Array.isArray(value) ? value[0] : value);
                    });
                }
            },
            error: function(xhr) {
                submitBtn
                    .prop('disabled', false)
                    .removeClass('is-loading')
                    .html(originalHtml);

                if (xhr.status === 429) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Too Many Attempts',
                        text: 'Please wait a minute before submitting again.',
                    });
                    return;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.',
                });
            }
        });
    });
});