import { forEach } from 'lodash';
import './bootstrap';

const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle");



toggle.addEventListener("click", () =>{
    sidebar.classList.toggle("close");
    var sidebarState = sidebar.classList.contains('close') ? 'close' : 'visible';
    document.cookie = 'sidebarState=' + encodeURIComponent(sidebarState) + '; path=/';
});