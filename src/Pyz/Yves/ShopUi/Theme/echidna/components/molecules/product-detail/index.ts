// import './product-detail.scss';

// document.addEventListener('DOMContentLoaded', function () {
//     const tabs = document.querySelectorAll('.product-info-tab');
//     const tabContent = document.querySelector('.product-info-content');
//     if (tabs != null) {
//         // Make the first tab active by default
//         console
//         tabs[0].classList.add('active');

//         // Show the content of the first tab by default
//         const defaultTabId = tabs[0].getAttribute('data-tab');
//         const defaultTabContent = document.getElementById(defaultTabId);
//         defaultTabContent.classList.add('active');

//         tabs.forEach(function (tab) {
//             tab.addEventListener('click', function () {
//                 const tabId = this.getAttribute('data-tab');
//                 const activeTab = document.getElementById(tabId);

//                 tabs.forEach(function (tab) {
//                     tab.classList.remove('active');
//                 });

//                 this.classList.add('active');

//                 const tabPanes = tabContent.querySelectorAll('.product-info-pane');
//                 tabPanes.forEach(function (pane) {
//                     pane.classList.remove('active');
//                 });

//                 activeTab.classList.add('active');
//             });
//         });
//     }

// });

// /// -------------------------------shopping list toggle------------------------------------------------------//

// const acc = document.getElementsByClassName("shopping__list");
// const shoppingInput = document.getElementById("shopping-list");
// let i: number;

// for (i = 0; i < acc.length; i++) {
//     acc[i].addEventListener("click", function () {
//         this.classList.toggle("active");
//         shoppingInput.classList.remove("is-hidden");
//         const select2 = this.nextElementSibling;
//         if (select2.style.maxHeight) {
//             select2.style.maxHeight = null;
//             shoppingInput.classList.add("is-hidden");
//         } else {
//             select2.style.maxHeight = select2.scrollHeight + "px";
//         }
//     });
// }
