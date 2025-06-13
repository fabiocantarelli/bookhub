/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// assets/app.js

// 1) jQuery – deve vir antes de plugins que dependem dele
import $ from 'jquery';
global.$ = global.jQuery = $;


import 'bootstrap';

const dt = require('datatables.net-bs5');
const select2 = require('select2');



import './styles/app.scss';
import './styles/app.css';
