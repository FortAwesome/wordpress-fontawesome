import { __ } from "@wordpress/i18n";
import apiFetch from "@wordpress/api-fetch";

const ACCESS_TOKEN_REFRESH_THRESHOLD_SECONDS = 60;

function currentTimeUnixEpochSeconds() {
  return Math.floor(Date.now() / 1000);
}

export function prepareAccessTokenGetter(restApiNamespace) {
  // It's more secure to store the accessToken here in JavaScript memory, rather
  // than somewhere like localStorage that might be accessed by other scripts.
  // It'll only be stored here as long as this JavaScript module is in memory.
  // Thus, it'll be re-fetched from the WordPress REST /api/token endpoint on each
  // page load.
  let accessToken;
  let accessTokenExpiresAt;

  const shouldRefresh = () => {
    if (!accessToken) return true;
    if (!Number.isFinite(accessTokenExpiresAt)) return true;

    const remainingSeconds =
      accessTokenExpiresAt - currentTimeUnixEpochSeconds();

    return remainingSeconds <= ACCESS_TOKEN_REFRESH_THRESHOLD_SECONDS;
  };

  return async () => {
    if (!accessToken || !accessTokenExpiresAt || shouldRefresh()) {
      // This request does not necessarily refresh the access token with the Font Awesome API.
      // It simply requests a current access token from this plugin's /api/token REST
      // endpoint on the WordPress server.
      // It's the responsibility of the controller on that REST endpoint to handle any
      // refreshing that may be required.
      const accessTokenResponse = await apiFetch({
        path: `${restApiNamespace}/api/token`,
        method: "GET",
      });

      accessToken = accessTokenResponse?.access_token;
      accessTokenExpiresAt = accessTokenResponse?.expires_at;
    }

    if (!accessToken) {
      const error = __(
        "Font Awesome Icon Chooser could not get an access token from the WordPress server.",
        "font-awesome",
      );
      console.error(error);
      throw new Error(error);
    }

    return accessToken;
  };
}
