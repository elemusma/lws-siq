/******/ (() => { // webpackBootstrap
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
console.log('Hello World! (from create-block-content-industries-we-serve block)');
/* eslint-enable no-console */

let tabTitle = document.querySelectorAll('.tab-title');
for (i = 0; i < tabTitle.length; i++) {
  tabTitle[i].addEventListener('click', activateContent);
  function activateContent() {
    tabActivate(this);
  }
}
let tabActivate = elem => {
  elemID = elem.getAttribute('id');
  elemContent = document.querySelector('.content-area.' + elemID);
  activeContent = document.querySelector('.content-area.activate');
  activeTitle = document.querySelector('.tab-title.active');

  // makes clicked title active
  elem.classList.add('active');
  elemContent.classList.add('activate');
  elemContent.classList.add('position-relative');
  elemContent.classList.remove('position-absolute');
  elemContent.style.opacity = "1";

  // makes all other titles inactive
  activeTitle.classList.remove('active');
  activeContent.classList.remove('activate');
  activeContent.classList.remove('position-relative');
  activeContent.classList.add('position-absolute');
  activeContent.style.opacity = "0";
};
/******/ })()
;
//# sourceMappingURL=view.js.map