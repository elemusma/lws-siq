// Variable to track if the modal has already been shown
let modalShown = false;
const modal = document.getElementById('leadMagnetModal');

const leadCustomBtn = document.querySelector('button[data-modal-id="leadMagnetModal"]');

const closeCustomBtn = document.querySelector('#leadMagnetModal .close-custom');
const closeCustomNoThanks = document.querySelector('#leadMagnetModal .no-thanks-text');

const leadCustomWidget = document.querySelector('.lead-magnet-open-widget');
const leadCustomWidgetBtnOpen = document.querySelector('.lead-magnet-open');
const leadCustomBtnClose = document.querySelector('.lead-magnet-close');
const leadCustomBtnCircle = document.querySelector('.lead-magnet-circle');