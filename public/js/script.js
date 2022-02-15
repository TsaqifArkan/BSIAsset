const currentLocation = location.href;
console.log(currentLocation);
// const aActiveToggler = document.querySelectorAll('ul.parent-active-toggler li.active-toggler a');
const aActiveToggler = document.querySelectorAll('.nav-link');
console.log(aActiveToggler);
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
    console.log(aActiveToggler[i].parentElement);
}

// JQuery Simplified Version -- but not for this app
// $(document).on('click', '.nav-item.active-toggler', function(){
//     $(this).addClass('active').siblings().removeClass('active');
// });


// JQUERY - MODAL
$('#formModal').on('shown.bs.modal', function() {
    $('#nama').focus();
})