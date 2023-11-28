// Declare the Toast variable globally
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

function alertSuccessToast(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
        timer: 3000
    });
}

// Global function for error toast
function alertErrorToast(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: true,
        timer: 3000
    });
}

function successToast(message) {
    Toast.fire({
        icon: 'success',
        title: message,
        timerProgressBar: true,
    });
}

function failToast(message) {
    Toast.fire({
        icon: 'error',
        title: message,
        timerProgressBar: true,
    });
}
