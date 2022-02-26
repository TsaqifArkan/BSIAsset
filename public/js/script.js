const currentLocation = location.href;
// console.log(currentLocation);
// const aActiveToggler = document.querySelectorAll('ul.parent-active-toggler li.active-toggler a');
const aActiveToggler = document.querySelectorAll('.nav-link');
// console.log(aActiveToggler);
const aATLength = aActiveToggler.length;
const aMyProfile = document.querySelector('.default-a-index');

for (let i = 0; i < aATLength; i++){
    // console.log(aActiveToggler[i].href);
    if (currentLocation === 'http://localhost:8080/' || currentLocation === 'http://localhost:8080/user'){
        aMyProfile.parentElement.classList.add('active');
    }
    else if (aActiveToggler[i].href === currentLocation){
        let j = aActiveToggler[0];
        while (j){
            if (j.tagName === 'a'){
                j.parentElement.classList.remove('active');
            }
            j = j.nextSibling;
        }
        aActiveToggler[i].parentElement.classList.add('active');
        
    }
    // console.log(aActiveToggler[i].parentElement);
}

// JQuery Simplified Version for toggle active class in sidebar -- but not for this app
// $(document).on('click', '.nav-item.active-toggler', function(){
//     $(this).addClass('active').siblings().removeClass('active');
// });

// JQUERY - MODAL
$('#formModal').on('shown.bs.modal', function() {
    $('#nama').focus();
})

// SweetAlert2 - JQuery
// 1.Konfigurasi flash data
const flashData = $('.flash-data').data('flashdata');
// console.log(flashData);
if(flashData){
    Swal.fire({
        title : 'SUCCESS !',
        text : flashData,
        icon : 'success'
    });
}
// 2.Konfigurasi tombol hapus
// $('.tombol-hapus').on('click', function(e){
//     e.preventDefault();
//     const href = $(this).data('id');
//     console.log(href);

//     Swal.fire({
//         title: 'Are you sure ?',
//         text: "You won't be able to undo this action!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//       }).then((result) => {
//         if (result.isConfirmed) {
//             // document.location.href = href;
//             window.location.replace(href);
//         }
//       })
// });