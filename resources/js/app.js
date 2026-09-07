import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// import TomSelect from 'tom-select';
// import 'tom-select/dist/css/tom-select.css';
// import TomSelect from 'tom-select/dist/js/tom-select.complete.min.js';
// document.addEventListener('DOMContentLoaded', () =>{
//     new TomSelect('#outlet_id', {
//         create: false,
//         sortField: {
//             field: 'text',
//             direction: 'asc'
//         },
//         placeholder: 'Select an outlet',
//     });
// });

import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';


new Choices('#outlet_id', {
    searchEnabled: true,
    searchPlaceholderValue: 'Search an outlet',
    itemSelectText: '',
    shouldSort: false,
    allowHTML: false,
    noResultsText: 'Outlet tidak ditemukan',
    noChoicesText: 'Tidak ada data outlet',
});

// document.addEventListener('DOMContentLoaded', () => {
//     new Choices('#outlet_id', {
//         searchEnabled: true,
//         itemSelectText: '',
//         placeholderValue: 'Select an outlet',
//         shouldSort: true,
//         searchPlaceholderValue: 'Search for an outlet',
//     });
// });