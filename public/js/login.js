$(document).ready(function(){
    $('#btnLogin').click(function(){
        // Deklarasi variabel untuk menyimpan nilai inputan
        var email    = $('#email').val();
        var password = $('#password').val();

        // console.log(email);
        // console.log(password);

        // Buat objek untuk menampung data inputan
        var data = {
            _token   : $('input[name="_token"]').val(), // CSRF token Laravel
            email    : email,
            password : password
        }

        // Disable tombol supaya tidak double submit
        $('#btnLogin').prop('disabled', true);

        // Kirim data ke server dengan AJAX POST
        $.ajax({
            url      : $('#loginForm').attr('action'),
            type     : 'POST',
            dataType : 'json',
            data     : data,
            success  : function(response){
                if(response.success === true){
                    Swal.fire({
                        icon: 'success',
                        text: response.message || 'Login Berhasil',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function(){
                        window.location.replace(response.redirect || '/');
                    });
                } else {
                    Swal.fire({icon: 'error', text: response.message || 'Email atau Password salah!'});
                    $('#btnLogin').prop('disabled', false);
                }
            },
            error    : function(xhr){
                var message = 'Terjadi kesalahan pada server';
                if(xhr.status === 422){
                    var errors = xhr.responseJSON?.errors;
                    if(errors){
                        message = Object.values(errors)[0][0];
                    }
                } else if(xhr.status === 419){
                    message = 'Sesi habis, silakan refresh halaman';
                }
                Swal.fire({icon: 'error', text: message});
                $('#btnLogin').prop('disabled', false);
            }
        });
    });
});