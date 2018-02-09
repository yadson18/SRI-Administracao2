$.fn.extend({
    notEmpty: function()
    {
        var tagName = $(this).prop('tagName');

        if (tagName === 'INPUT' || tagName === 'SELECT' ||
            tagName === 'TEXTAREA'
        ) {
            return ($(this).val().replace(/[ ]/g, '') !== '') ? true : false;
        }
        return ($(this).text().replace(/[ ]/g, '') !== '') ? true : false;
    },
    inputAlert: function(type) 
    {
        function addAlertClass($element, className)
        {
            var classesToReplace = [
                'has-error', 'has-success', 'has-warning', 'has-none'
            ];

            $.each(classesToReplace, function(index, className) {
                $element.removeClass(className);
            });
            $element.addClass(className);
        }

        return this.each(function() {
            var $parentDiv = $(this).closest('div');

            if ($parentDiv && type) {
                switch(type) {
                    case 'success': addAlertClass($parentDiv, 'has-success'); break;
                    case 'error': addAlertClass($parentDiv, 'has-error'); break;
                    case 'warning': addAlertClass($parentDiv, 'has-warning'); break;
                    case 'none': addAlertClass($parentDiv, 'has-none'); break;
                }
            }
        });
    },
    bootstrapAlert: function(alertType, message)
    {
        var $alert, $content;
        $alert = $('<div></div>', {
            class: 'alert alert-dismissable',
            role: 'alert',
            html: [
                $('<button></button>', {
                    type: 'button',
                    'data-dismiss': 'alert',
                    class: 'close',
                    'aria-label': 'Close',
                    html: $('<i></i>', {class: 'fas fa-times'})
                }),
                $('<div></div>', {
                    class: 'message-content',
                    html: [$('<i></i>', {class: 'fas'}), $('<span></span>')]
                })
            ]
        });
        $content = $alert.find('.message-content');
        $content.find('span').text(' ' + message);

        switch (alertType) {
            case 'success':
                $alert.addClass('alert-success');
                $content.find('i').addClass('fa-check-circle');
                break;
            case 'error':
                $alert.addClass('alert-danger');
                $content.find('i').addClass('fa-exclamation-circle');
                break;
            case 'info':
                $alert.addClass('alert-info');
                $content.find('i').addClass('fa-info-circle');
                break;
            case 'warning':
                $alert.addClass('alert-warning');
                $content.find('i').addClass('fa-exclamation-triangle');
                break;
        }

        $(this).find('.alert').remove();
        $(this).append($alert); 
    },
    redirect: function(redirect) 
    {
        if (redirect['controller'] && redirect['view']) {
            $(this).attr('href', '/' + redirect['controller'] + '/' + redirect['view']);
        }
    },
    disable: function() 
    {
        return this.each(function() { $(this).prop('disabled', true); });
    },
    enable: function() 
    {
        return this.each(function() { $(this).prop('disabled', false); });
    },
    formToJSON: function() 
    {
        var array = $(this).serializeArray();
        json = {};

        $.each(array, function() { json[this.name] = this.value || ''; });

        return json;
    }
});

$(document).ready(function(){
    function validateCpfCnpj($input, status)
    {
        var $div = $input.closest('div');
            $messageBox = $('form .message-box');
            classes = '';

        $div.find('i').remove();

        if ($input.prop('class').indexOf('cnpjMask') !== -1 &&
            $input.val().length === 18 ||
            $input.prop('class').indexOf('cpfMask') !== -1 &&
            $input.val().length === 14
        ) { 
            if (status === 'success' && 
                !(/^(.)\1+$/.test($input.cleanVal()))
            ) {   
                classes = 'fa-check success icon icon-sm';
                $div.removeClass('has-error');
                $messageBox.empty();
            } 
            else {
                classes = 'fa-times danger icon icon-sm';
                $div.addClass('has-error');

                if ($input.val().length === 18) {
                    $messageBox.bootstrapAlert('error', 'Digite um CNPJ válido.');
                }
                else {
                    $messageBox.bootstrapAlert('error', 'Digite um CPF válido.');
                }
            }
            
            $div.append($('<i></i>', { class: 'fas ' + classes }));
        }
    }

    var defaultMaskConfigs = {
        clearIfNotMatch: true,
        reverse: true,
        optional: false,
        translation: { '0': { pattern: /[0-9]/ } }
    };
    cnpj = { mask: '00.000.000/0000-00', size: 14 };
    cpf = { mask: '000.000.000-00', size: 11 };

    $('.thousand').mask('000.000.000.000.000', { reverse: true });
    $('.money.millions').mask('0.000.000,00', { reverse: true });
    $('.money.thousands').mask('000.000,00', { reverse: true });
    $('.rgMask').mask('00.000.000-0', defaultMaskConfigs);
    $('.cepMask').mask('00000-000', defaultMaskConfigs);
    $('.cnpjMask').mask(cnpj.mask, defaultMaskConfigs);
    $('.cpfMask').mask(cpf.mask, defaultMaskConfigs);
    $('.icms').mask('00.00', { reverse: true });
    $('.ali-pis').mask('0.0000');

    $('.money').maskMoney({ 
        thousands:'.', 
        decimal:',', 
        allowZero: true 
    });

    $('.percent').maskMoney({ 
        thousands:'', 
        decimal:'.', 
        allowZero: true
    });

    $.datetimepicker.setLocale('pt-BR');
    $('.date').datetimepicker({
        format:'d/m/Y',
        timepicker: false,
        minDate: 0,
        defaultSelect: true,
        todayButton:true
    }).mask('00/00/0000', { reverse: false });
    
    $('.date-time').datetimepicker({
        format:'d/m/Y H:i:s',
        minDate: 0,
        defaultSelect: true,
        todayButton:true
    }).mask('00/00/0000 00:00:00', { reverse: false });

    $('.cnpjCpfMask').mask(function(value) { 
        return (value.length === cpf.size) ? cpf.mask : cnpj.mask;
    });

    $('.cnpjMask, .cpfMask').not('#page-login .cnpjMask').cpfcnpj({
        ifValid: function ($input) { validateCpfCnpj($input, 'success'); },
        ifInvalid: function ($input) { validateCpfCnpj($input, 'error'); }  
    });

    $('form').on('submit', function() {
        return ($(this).find('div.has-error').length === 0) ? true : false;
    });

    $('.disabled').on('keydown', function(event){
        event.preventDefault();
    });

    $('input').not('#page-login form input, #colaborador-mudar-senha input').on('change', function() { 
        $(this).val($(this).val().toUpperCase()); 
    });
});