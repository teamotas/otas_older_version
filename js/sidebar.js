const body = document.querySelector('body')
// sidebar = body.querySelector('nav'),
// toggle = body.querySelector(".toggle"),
// searchBtn = body.querySelector(".search-box"),
// modeSwitch = document.querySelector(".toggle-switch"),
// modeText = document.querySelector(".mode-text");

// toggle.addEventListener("click" , () =>{
//     sidebar.classList.toggle("close");
// })

// searchBtn.addEventListener("click" , () =>{
//     sidebar.classList.remove("close");
// })

// modeSwitch.addEventListener("click" , () =>{
//     body.classList.toggle("dark");
    
//     if(body.classList.contains("dark")){
//         modeText.innerText = "Light mode";
//     }else{
//         modeText.innerText = "Dark mode";
//     }
// });

const toggleButton = document.querySelector('.menu-button');
const sidebar = document.querySelector('.sidebar');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('close');
});

function checkdelete(){
    return confirm('Confirm Ok to Delete');
}
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');
    sidebar.classList.toggle('close');
}