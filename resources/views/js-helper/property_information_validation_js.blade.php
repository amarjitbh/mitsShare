<script>
    // Select your input element.
    var numInput = document.querySelector('input');

    // Listen for input event on numInput.
    numInput.addEventListener('input', function(){
        // Let's match only digits.
        var num = this.value.match(/^\d+$/);
        if (num === null) {
            // If we have no match, value will be empty.
            this.value = "";
        }
    }, false)
    function isNumberKey(evt,ths){ //numeric validation
        var i = 0;
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){

                $(ths).next('span').remove();
                $(ths).after('<span class="d-block small font-12 text-danger mt-5">Please enter numeric value</span>');
            i++;
            setTimeout(function(){

                $(ths).next('span').remove();
            },2000);
            return false;
        }else{

            $(this).next('span').remove();
            return true;
        }
    }
    function isAlphaNumeric(e,ths){ // Alphanumeric only

        var k;
        document.all ? k=e.keycode : k=e.which;
        if((k>47 && k<58)||(k>64 && k<91)||(k>96 && k<123)||k==0){
            $(ths).next('span').remove();
            return true
        }else if(k == 8){

            $(ths).next('span').remove();
         return true
        }else if(k == 32){

            $(ths).next('span').remove();
         return true
        }else{

            $(ths).next('span').remove();
            $(ths).after('<span class="d-block small font-12 text-danger mt-5">Please enter alphanumeric value</span>');


            setTimeout(function(){

                $(ths).next('span').remove();
            },2000);
            return false
        }
    }

    function onlyAlphabets(e, ths) {
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            }
            else if (e) {
                var charCode = e.which;
            }
            else { return true; }
            if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123)) {

                $(ths).next('span').remove();
                return true;
            }else if(charCode == 8){

                $(ths).next('span').remove();
                return true;
            }else if(charCode == 32){

                $(ths).next('span').remove();
            }else{

                $(ths).next('span').remove();
                $(ths).after('<span class="d-block small font-12 text-danger mt-5">Please enter alphabets value</span>');


                setTimeout(function(){

                    $(ths).next('span').remove();
                },2000);
                return false;
            }
        }
        catch (err) {

            $(ths).next('span').remove();
            $(ths).after('<span class="d-block small font-12 text-danger mt-5">Please enter alphabets value</span>');
            setTimeout(function(){
                $(ths).next('span').remove();
            },4000);
            return false;
        }
    }

    function validatedate(inputText,not) { //date validation

        var dateformat = /^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/;
        var dateformat = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-./])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;

        // Match the date format through regular expression
        if(inputText.value.match(dateformat)) {

            //document.form1.text1.focus();
            //inputText.value.focus();
            //Test which seperator is used '/' or '-'
            var opera1 = inputText.value.split('/');
            var opera2 = inputText.value.split('-');
            lopera1 = opera1.length;
            lopera2 = opera2.length;
            // Extract the string into month, date and year
            if (lopera1>1) {

                var pdate = inputText.value.split('/');
            }
            else if (lopera2>1) {

                var pdate = inputText.value.split('-');
            }
            var dd = parseInt(pdate[0]);
            var mm  = parseInt(pdate[1]);
            var yy = parseInt(pdate[2]);
            // Create list of days of a month [assume there is no leap year by default]
            var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
            if (mm==1 || mm>2) {

                if (dd>ListofDays[mm-1])
                {
                    $(inputText).next('span').remove();
                    $(inputText).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid date format EX:- DD/MM/YYYY</span>');


                    if($.isEmptyObject(not)) {
                        setTimeout(function () {

                            $(inputText).next('span').remove();
                        }, 4000);
                    }
                    return false;
                }
            }
            if (mm==2) {

                var lyear = false;
                if ( (!(yy % 4) && yy % 100) || !(yy % 400))
                {
                    lyear = true;
                }
                if ((lyear==false) && (dd>=29))
                {
                    $(inputText).next('span').remove();
                    $(inputText).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid date format EX:- DD-MM-YYYY</span>');



                    if($.isEmptyObject(not)) {
                        setTimeout(function () {

                            $(inputText).next('span').remove();
                        }, 4000);
                    }
                    return false;
                }
                if ((lyear==true) && (dd>29))
                {
                    $(inputText).next('span').remove();
                    $(inputText).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid date format EX:- DD-MM-YYYY</span>');


                    if($.isEmptyObject(not)) {
                        setTimeout(function () {

                            $(inputText).next('span').remove();
                        }, 4000);
                    }
                    return false;
                }
            }
        }
        else {


            $(inputText).next('span').remove();
            $(inputText).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid date format EX:- DD-MM-YYYY</span>');


            if($.isEmptyObject(not)) {
                setTimeout(function () {

                    $(inputText).next('span').remove();
                }, 4000);
            }
            return false;
        }
    }
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function emailValidate(txt,not) {

        var email = txt.value;
        if (validateEmail(email)) {

            return true
        } else {

            setTimeout(function () {

                $(txt).next('span').remove();
                $(txt).after('<span class="d-block small font-12 text-danger mt-5">Please enter correct email</span>');

            }, 50);

            if($.isEmptyObject(not)) {

                setTimeout(function () {

                    $(txt).next('span').remove();
                }, 4000);
            }
            return false;
        }
        return false;
    }
    function urlValidate(txt,not) {

        var url = txt.value;
        var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        if (!re.test(url)) {

            $(txt).next('span').remove();
            $(txt).after('<span class="d-block small font-12 text-danger mt-5">Please enter url only (EX :- www.abcd.com or abcd.com)</span>');

            if($.isEmptyObject(not)) {

                setTimeout(function () {

                    $(txt).next('span').remove();
                }, 4000);
            }
            return false;
        }else{

            $(txt).next('span').remove();
            return true;
        }
    }

    function reqiredFields(){
        var required = false;
        var req = 0;
        var b = 0;
        //required feild validations
        if($('.requiredClass').hasClass('requiredClass') == true) {

            $('.requiredClass').filter(function () {

                if( this.type == 'radio') {
                        var names = [];
                        //var radioName = this.name;

                    length = 0;
                    $('input:radio.requiredClass').each(function() {
                        if($(this).is(':checked') == true){
                            length += 1;
                        }
                    });
                    if(length == 0) {

                        $(this).parent().parent('div').next('span').remove();
                        $(this).parent().parent().after('<span  class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                        req += 1;
                        required = false;
                    }

                    return false;


                   /* $('input[type="radio"]').each(function () {
                            // Creates an array with the names of all the different checkbox group.
                            names[$(this).attr('name')] = true;
                        });
                        // Goes through all the names and make sure there's at least one checked.
                        for (name in names) {
                            if(required == false) {
                                var radio_buttons = $("input[name='" + name + "']");

                                if (radio_buttons.filter(':checked').length == 0) {
                                        alert(radio_buttons.filter(':checked').length);
                                    $(this).parent().parent('div').next('span').remove();
                                    $(this).parent().parent().after('<span  class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                                    req += 1;
                                    required = false;
                                }
                            }
                        }
                    return false;*/
                }else if(this.type == 'checkbox'){
                    length = 0;
                    $('input:checkbox.requiredClass').each(function() {
                        if($(this).is(':checked') == true){
                            length += 1;
                        }
                    });
                    if(length == 0) {

                        $(this).parent().parent().parent().next('span').remove();
                        $(this).parent().parent().parent().after('<span  class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                        req += 1;
                        required = false;
                    }

                    $(this).click(function(){

                        $(this).parent().parent().parent().next('span').remove();
                    });
                    return false;
                }else if(this.type == 'select-one' && this.value == ''){

                    $(this).parent().next().remove();
                    $(this).parent('.btn-group').after('<span class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');

                    $(this).parent('.btn-group').click(function(){
                        $(this).next().remove();
                    });
                    required = false;
                    return false;
                }else if(this.type == 'textarea'){

                    $('.cke_1').next().remove();
                    var editor_val = $(".textareaCls iframe").contents().find("body").text();

                    if (editor_val == '') {
                        $('.cke_1').after('<span class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                        required = false;
                        return false;
                    }


                }else if (this.value == '' && this.type != 'textarea' && this.type != 'radio' && this.type != 'checkbox') {b++

                    $(this).css('border', '1px solid #a94442');
                    $(this).next('span').remove();
                    $(this).after('<span class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                    $(this).focus(function () {

                        if($(this).attr('type') == 'date' || $(this).attr('type') == 'datetime'){

                            $(this).next().next('span').filter(function(){
                                if($(this).html() !=''){
                                    $(this).remove();
                                }
                            });
                        }else{

                            $(this).next('span').remove();
                        }
                        $(this).css('border', '');
                    });
                    if(b == 1){

                        $(this).focus();
                        $(this).css('border', '1px solid #a94442');
                        $(this).next('span').remove();
                        $(this).after('<span class="d-block small font-12 text-danger mt-5">Please fill the required fields</span>');
                        $(this).keyup(function () {

                            if($(this).attr('type') == 'date' || $(this).attr('type') == 'datetime'){

                                $(this).next().next('span').filter(function(){
                                    if($(this).html() !=''){
                                        $(this).remove();
                                    }
                                });
                            }else{

                                $(this).next('span').remove();
                            }
                            $(this).css('border', '');
                        });
                    }
                     /*$('html, body').animate({
                         scrollTop: $("#errorMessage").offset().top
                     }, 800);*/
                    req += 1;
                    required = false;
                }else {
                   if(req == 0){
                       return required = true;
                   }
                }
            });
        }else{
            return required = true;
        }
        return required;
    }

    /***  Remove radio validation  ***/
    $('input:radio').click(function(){

        $(this).parent().parent('div').next('span').remove();
    });
    /***  Remove radio validation  ***/
    $('input:checkbox').click(function(){
        //alert( attr('class'));
        $(this).parent().parent().parent().next().remove();
    });

    function reqiredPhotoFields(){

        var required = false;
        //required photo feild validations
        if($('.requiredfileClass').hasClass('requiredfileClass') == true) {
            $('.requiredfileClass').filter(function () {

                if (this.value == '') {
                    //alert($(this).next('span').find('button').html());
                    $(this).parent('div').next('span').remove();
                    $(this).closest('div').after('<span class="d-block small font-12 text-danger mt-5">Please select any file</span>');
                    $(this).next('span').find('button').click(function () {
                        //alert($(this).parents().parents().next('span').html());
                        $(this).parents().parents().next('span').remove();
                    });
                    return required = false;
                } else {
                    return required = true;
                }
            });
        }else{
            return required = true;
        }
        return required;
    }

    function urlSubmitValidation(){

        var url = false;
        //url feild validations
        var count= 0;
        if($('.urlClass').hasClass('urlClass') == true) {

            $('.urlClass').filter(function () {

                if (urlValidate(this, 'not') == false) {
                    count++;
                    $(txt).next('span').remove();
                    $(this).after('<span class="d-block small font-12 text-danger mt-5">Please enter url only (EX :- www.abcd.com or abcd.com)</span>');

                    $(this).css('border', '1px solid #a94442');

                    $(this).focus(function () {
                        $(this).next('span').remove();
                        $(this).css('border', '');
                    });
                    /*$('html, body').animate({
                        scrollTop: $("#errorMessage").offset().top
                    }, 800);*/
                    url = false;
                } else {
                    if(count == 0){
                        url = true;
                    }
                }
            });
        }else{

            url = true;
        }
        return url;
    }

    function emailSubmitValidation(){

        var email = false;
        //email feild validations
        if($('.emailClass').hasClass('emailClass') == true) {

            $('.emailClass').filter(function () {

                if (emailValidate(this, 'not') == false) {

                   setTimeout(function(){

                       $(this).next('span').remove();
                       $(this).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid email EX:- example.com</span>');
                       $(this).css('border', '1px solid #a94442');

                   },50);
                    $('.requiredClass').focus(function () {

                        $(this).next('span').remove();
                        $(this).css('border', '');
                    });
                    /*$('html, body').animate({
                        scrollTop: $("#errorMessage").offset().top
                    }, 800);*/
                    return email = false;
                } else {

                    return email = true;
                }
            });
        }else{
            return email = true;
        }
        return email;
    }

    function dateSubmitValidation(){

        var date = false;
        //date feild validations

        if($('.dateClass').hasClass('dateClass') == true) {

            $('.dateClass').filter(function () {

                if (validatedate(this, 'not') == false) {
                    $(this).next('span').remove();
                    $(this).after('<span class="d-block small font-12 text-danger mt-5">Please enter valid date format EX:- DD-MM-YYYY</span>');
                    $(this).css('border', '1px solid #a94442');

                    $(this).focus(function () {

                        $(this).next('span').remove();
                        $(this).css('border', '');
                    });
                   /* $('html, body').animate({
                        scrollTop: $("#errorMessage").offset().top
                    }, 800);*/
                    return date = false;

                } else {

                    return date = true;
                }
            });
        }else{
            return date = true;
        }
        return date;
    }

    function checkNagetiveValue(){
        var negetiveValue = false;
        //date feild validations

        if($('.typeNumber').hasClass('typeNumber') == true) {

            $('.typeNumber').filter(function () {

                val = this.value;
                if(val<0){
                    $(this).next('span').remove();
                    $(this).after('<span class="d-block small font-12 text-danger mt-5">Negative Value is not allowed</span>');
                    $(this).css('border', '1px solid #a94442');

                    $(this).focus(function () {
                        $(this).next('span').remove();
                        $(this).css('border', '');
                    });
                    $('html, body').animate({
                        scrollTop: $("#errorMessage").offset().top
                    }, 800);
                    return date = false;
               } else {

                    return negetiveValue = true;
                }
            });
        }else{
            return negetiveValue = true;
        }
        return negetiveValue;
    }

    $('#submitProperty').click(function() {
        //alert(reqiredFields());
        if(reqiredFields() == false){
            return false;
        }else if(reqiredPhotoFields() == false){
            return false;
        }else if(urlSubmitValidation() == false){
            return false;
        }else if(emailSubmitValidation() == false){
            return false;
        }else if(checkNagetiveValue() == false){
            return false;
        }else if(dateSubmitValidation() == false){
           return false;
        }else if($('#propertyType').val() == ''){
            $('#property_error').show();
            return false;
        }else{
            //alert('done');return false;
            $('#submitProperty').attr('type','submit');
            $('#submitProperty').click();
        }
    });
    // Fixed HTTP
    $(".inputTypeUrl").keydown(function(e) {
        var oldvalue=$(this).val();
        var field=this;
        setTimeout(function () {
            if(field.value.indexOf('http://') !== 0) {
                $(field).val(oldvalue);
            }
        }, 1);
    });

    $('#updateProperty').click(function(){

        //alert(reqiredFields());

        if(reqiredFields() == false){
            return false;
        }else if(reqiredPhotoFields() == false){
            return false;
        }else if(urlSubmitValidation() == false){
            return false;
        }else if(emailSubmitValidation() == false){
            return false;
        }else if(checkNagetiveValue() == false){
            return false;
        }else if(dateSubmitValidation() == false){
            return false;
        }else if($('#propertyType').val() == ''){
            $('#property_error').show();
            return false;
        }else{

            $('#updateProperty').attr('type','submit');
            $('#updateProperty').click();
        }
    });

    $(document).ready(function () {
        $(".urlClass").change(function() {
            if (!/^http:\/\//.test(this.value)) {
                this.value = "http://" + this.value;
            }
        });
    });

    $("input[type='datetime']").datetimepicker({
        format:'DD-MM-YYYY H:m',
    });
    $('.dateClass').datetimepicker({
        format:'DD-MM-YYYY',
    });

    function changeSingleQuote(plainTextStr){

         $('textarea').val(plainTextStr.replace(/'/g, '"'));
    }
</script>
