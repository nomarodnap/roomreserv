$('document').ready(function() {

    // สร้างตัวแปรเก็บค่า boolean ของ email_state และ email_state
    var email_state = false;
    var email_state = false;

    // get ไอดี email จาก input และเรียกใช้งาน event on blur หรือเมื่อมีการพิมพ์ก็ให้ทำการเรียกใช้ ajax
    $('#email').on('blur', function() {
        var email = $('#email').val();
        if (email == '') {
            email_state = false;
            return;
        }
        $.ajax({
            url: 'singup.php',
            type: 'post',
            data: {
                'email_check': 1,
                'email': email
            },
            // หากผลลัพธ์เป็น success ก็จะรับ response จากไฟล์ process.php มา เช็คว่าตรง กับ taken หรือมี email นี้หรือเปล่า
            success: function(response) {
                if (response == 'taken') {
                    email_state = false;
                    $('#email').parent().removeClass();
                    $('#email').parent().addClass('form_error');
                    $('#email').siblings("span").text("อีเมลนี้ถูกใช้งานแล้ว <i class='bi bi-x-circle text-danger'></i>");
                } else if (response == "not_taken") {
                    email_state = true;
                    $('#email').parent().removeClass();
                    $('#email').parent().addClass('form_success');
                    $('#email').siblings("span").text("อีเมลนี้ใช้งานได้ <i class='bi bi-check-circle text-success'></i>");
                }
            }
        })
    });

    $('#email').on('blur', function() {
        var email = $('#email').val();
        if (email == '') {
            email_state = false;
            return;
        }
        $.ajax({
            url: 'singup.php',
            type: 'post',
            data: {
                'email_check': 1,
                'email': email
            },
            success: function(response) {
                if (response == 'taken') {
                    email_state = false;
                    $('#email').parent().removeClass();
                    $('#email').parent().addClass('form_error');
                    $('#email').siblings("span").text("อีเมลนี้ถูกใช้งานแล้ว <i class='bi bi-x-circle text-danger'></i>");
                } else if (response == "not_taken") {
                    email_state = true;
                    $('#email').parent().removeClass();
                    $('#email').parent().addClass('form_success');
                    $('#email').siblings("span").text("อีเมลนี้ใช้งานได้ <i class='bi bi-check-circle text-success'></i>");
                }
            }
        })
    });

    $('#register_btn').on("click", function(e) {
        var email = $("#email").val();
        var email = $("#email").val();
        var password = $("#password").val();
        if (email_state == false || email_state == false) {
            e.preventDefault();
            $("#error_msg").text("Fix the errors in the form first");
        } else {
            $.ajax({
                url: 'singup.php',
                type: 'post',
                data: {
                    'save': 1,
                    'email': email,
                    'email': email,
                    'password': password
                },
                success: function(response) {
                    alert('User saved');
                    $('#email').val('');
                    $('#email').val('');
                    $('#password').val('');
                }
            })
        }
    });

});