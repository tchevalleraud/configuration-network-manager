import './styles/app/app.scss';
import './styles/app/bootstrap-menu-multilevel.scss';

import './bootstrap';
import '@popperjs/core';

import * as bootstrap from 'bootstrap';

require('@fortawesome/fontawesome-free/css/all.css');
require('@fortawesome/fontawesome-free/js/all.min.js');

/**
 * Bootstrap menu multi-level
 */
    document.addEventListener("DOMContentLoaded", function(){
        if (window.innerWidth < 992) {

            document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
                everydropdown.addEventListener('hidden.bs.dropdown', function () {
                    this.querySelectorAll('.submenu').forEach(function(everysubmenu){
                        everysubmenu.style.display = 'none';
                    });
                })
            });

            document.querySelectorAll('.dropdown-menu a').forEach(function(element){
                element.addEventListener('click', function (e) {
                    let nextEl = this.nextElementSibling;
                    if(nextEl && nextEl.classList.contains('submenu')) {
                        e.preventDefault();
                        if(nextEl.style.display == 'block'){
                            nextEl.style.display = 'none';
                        } else {
                            nextEl.style.display = 'block';
                        }

                    }
                });
            })
        }
});