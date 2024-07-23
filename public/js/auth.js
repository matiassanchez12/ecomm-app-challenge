$(document).ready(function () {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })

    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();
        console.log(
            email,
password
        )
        $.ajax({
            url: '/login',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Ahora esta logueado!'
                })
                const { token } = JSON.parse(response);
                localStorage.setItem('email', email);
                localStorage.setItem('token', token);

                window.location.replace("/");
            }
        });
    });
})
