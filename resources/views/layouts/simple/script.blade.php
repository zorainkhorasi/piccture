

<!-- Bootstrap js-->
<script src="{{asset(config('global.asset_path').'/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset(config('global.asset_path').'/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<!-- <script src="{{asset(config('global.asset_path').'/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/scrollbar/custom.js')}}"></script> -->


<script src="{{asset(config('global.asset_path_bnp').'/assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path').'/js/core.js')}}"></script>
<!-- BEGIN: Vendor JS-->
<script src="{{asset(config('global.asset_path_bnp').'/assets/vendors/js/forms/toggle/switchery.min.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path_bnp').'/assets/js/scripts/forms/switch.min.js')}}" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Theme JS-->
@yield('script')
<script src="{{asset(config('global.asset_path_bnp').'/assets/js/core/app-menu.min.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path_bnp').'/assets/js/core/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path_bnp').'/assets/js/scripts/customizer.min.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path_bnp').'/assets/vendors/js/jquery.sharrre.js')}}" type="text/javascript"></script>
<script src="{{asset(config('global.asset_path').'/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/notify/notify-script.js')}}"></script>
<!-- END: Theme JS-->
<!-- BEGIN: Page Vendor JS-->





<script>
    $(document).ready(function () {
        checkSession();
        $('#loader').hide();
    });

    function checkSession() {
        var lastActivityTime = new Date().getTime();
        sessionStorage.setItem("lastActivityTime", lastActivityTime);

        $(document).on('scroll mousedown keydown', function (event) {
            sessionStorage.setItem("lastActivityTime", new Date().getTime());
        });

        function logout() {
            document.getElementById('logout-form').submit();
        }

        setInterval(function () {
            var currentTime = new Date().getTime();
            var lastActivityTime = parseInt(sessionStorage.getItem("lastActivityTime"));
            var elapsedTime = currentTime - lastActivityTime;

            // Log out if no activity for 34 seconds (34000 milliseconds)
            if (elapsedTime >= 34000) {
                //logout();
            }
        }, 1000); // Check every second
    }






    function showloader(){
        $('#loader').show();
        return true;
    }
    function hideloader(){
        $('#loader').hide();
        return true;
    }



    function custome_validatePwd_format(password) {
        var myInput = $("#" + password);
        var letter = $("#" + password).parents('.userPasswordDiv').find('.letter');
        var capital = $("#" + password).parents('.userPasswordDiv').find('.capital');
        var number = $("#" + password).parents('.userPasswordDiv').find('.number');
        var length = $("#" + password).parents('.userPasswordDiv').find('.length');
        var special_character = $("#" + password).parents('.userPasswordDiv').find('.special_character');
        console.log(special_character);
        // When the user starts to type something inside the password field
        $("#" + password).keyup(function (e) {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if ($("#" + password).val().match(lowerCaseLetters)) {
                $(letter).removeClass("invalid");
                $(letter).addClass("valid");
            } else {
                $(letter).removeClass("valid");
                $(letter).addClass("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if ($("#" + password).val().match(upperCaseLetters)) {
                $(capital).removeClass("invalid");
                $(capital).addClass("valid");
            } else {
                $(capital).removeClass("valid");
                $(capital).addClass("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if ($("#" + password).val().match(numbers)) {
                $(number).removeClass("invalid");
                $(number).addClass("valid");
            } else {
                $(number).removeClass("valid");
                $(number).addClass("invalid");
            }

            // Validate length
            if ($("#" + password).val().length >= 8) {
                $(length).removeClass("invalid");
                $(length).addClass("valid");
            } else {
                $(length).removeClass("valid");
                $(length).addClass("invalid");
            }
            // Validate special characters
            var specialCharacters = /[!@#$%^&*(),.?":{}|<>]/g;
            if ($("#" + password).val().match(specialCharacters)) {
                $(special_character).removeClass("invalid");
                $(special_character).addClass("valid");
            } else {
                $(special_character).removeClass("valid");
                $(special_character).addClass("invalid");
            }
        });
    }

    function custome_validatePwdInp(password) {
        var myInput = $("#" + password);
        var flag = 1;
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;
        var specialCharacters = /[!@#$%^&*(),.?":{}|<>]/g; // Define the regex for special characters

        // Check if the password contains at least one lowercase letter, one uppercase letter,
        // one number, one special character, and has a minimum length of 8 characters
        if ($("#" + password).val().match(lowerCaseLetters) &&
            $("#" + password).val().match(upperCaseLetters) &&
            $("#" + password).val().match(numbers) &&
            $("#" + password).val().match(specialCharacters) &&
            $("#" + password).val().length >= 8) {
            flag = 0;
        }
        return flag;
    }


    function custome_validatePwd(password) {
        custome_validatePwd_format(password);

        $("#" + password).keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z0-9!@#$%^&*(),.?":{}|<>]+$/;
            // Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
               // toastMsg('Error', 'Only Alphabets, Numbers, and at least one Special Character allowed.', 'danger');
            }


            return true;
        });
    }



</script>

