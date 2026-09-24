import { webAuthVerification } from "@tsjippy/webauth";

import{
  fetchRestApi
} from "@tsjippy/form_submit_functions";

import { 
  showLoader 
} from "@tsjippy/show_loader";

import { 
  displayMessage 
} from "@tsjippy/display_message";

async function verifyAccountSwitch(target) {
  let targetAccountId = target.dataset.accountid;
  let nonce = target.dataset.nonce;

  let loader = showLoader(target);

  if (await webAuthVerification(targetAccountId)) {
    let formData = new FormData();

    formData.append("switch-account", targetAccountId);

    formData.append("nonce", nonce);

    let response = await fetchRestApi(
      "positional/switch_account",
      formData,
    );

    if (response) {
      displayMessage(response);

      window.location.href = window.location.href;

      return;
    }
  }

  displayMessage(
    "Passkey login for the account failed.\nLogging out...",
    "error",
  );

  // If the passkey login failed, we log out the user
  // This is to ensure that the user can try logging in with a different method
  document.querySelectorAll(`.logout`).forEach((el) => el.click());

  let menu = loader.closest(".menu-item-has-children");
  loader.remove();
  if (menu.querySelectorAll(`button`).length == 0) {
    menu.remove();
  }
}

console.log("Positional accounts script loaded");

document.addEventListener("click", function (event) {
  if (event.target.matches(`.account-switcher`)) {
    event.stopPropagation();
    verifyAccountSwitch(event.target);
  }
});
