import Swal from 'sweetalert2';

const showMessage = (status, msg) => {
    let icon = 'error';
    if(status === 200) icon = 'success';
    Swal.fire({
        position: 'top-end',
        icon: icon,
        title: msg,
        showConfirmButton: false,
        timer: 1500
    });
}

export default showMessage;