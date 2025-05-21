/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Update/reset user image of account page
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }

    // Update/reset site logo of setting page
    let siteLogoImage = document.getElementById('uploadedLogo');
    const fileLogoInput = document.querySelector('.logo-file-input'),
      resetFileLogoInput = document.querySelector('.logo-image-reset');

    if (siteLogoImage) {
      const resetLogoImage = siteLogoImage.src;
      fileLogoInput.onchange = () => {
        if (fileLogoInput.files[0]) {
          siteLogoImage.src = window.URL.createObjectURL(fileLogoInput.files[0]);
        }
      };
      resetFileLogoInput.onclick = () => {
        fileLogoInput.value = '';
        siteLogoImage.src = resetLogoImage;
      };
    }

    // Update/reset site fav logo of setting page
    let siteFavLogoImage = document.getElementById('uploadedFav');
    const fileFavLogoInput = document.querySelector('.fav-file-input'),
      resetFileFavLogoInput = document.querySelector('.fav-image-reset');

    if (siteFavLogoImage) {
      const resetFavImage = siteFavLogoImage.src;
      fileFavLogoInput.onchange = () => {
        if (fileFavLogoInput.files[0]) {
          siteFavLogoImage.src = window.URL.createObjectURL(fileFavLogoInput.files[0]);
        }
      };
      resetFileFavLogoInput.onclick = () => {
        fileFavLogoInput.value = '';
        siteFavLogoImage.src = resetFavImage;
      };
    }


  })();
});
